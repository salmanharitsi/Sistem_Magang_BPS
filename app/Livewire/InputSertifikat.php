<?php

namespace App\Livewire;

use Livewire\Attributes\Validate;
use Livewire\Component;
use App\Models\Magang;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class InputSertifikat extends Component
{
    use WithFileUploads;

    #[Validate]
    public $magangId;
    public $magang;
    public $isGenerating = false;
    public $sertifikatGenerated = false;
    public $sertifikatPath = null;
    public $sertifikat_magang;
    public $showSubmitModal = false;
    
    protected $listeners = ['refreshComponent' => '$refresh'];

    public function rules()
    {
        return [
            'sertifikat_magang' => 'max:2048|required|file|mimes:pdf',
        ];
    }

    public function messages()
    {
        return [
            'sertifikat_magang' => [
                "max" => 'File tidak boleh lebih dari 2mb',
                "required" => 'Sertifikat Magang tidak boleh kosong',
                "file" => 'Sertifikat Magang harus berupa file',
                "mimes" => 'Sertifikat Magang harus berupa PDF',
            ]
        ];
    }

    public function confirmSubmit()
    {
        // Validasi terlebih dahulu sebelum menampilkan modal
        $this->validate();
        
        // Jika validasi berhasil, tampilkan modal konfirmasi
        $this->showSubmitModal = true;
    }

    public function mount($magang)
    {
        $this->magangId = $magang;
        $this->loadMagang();
    }
    
    public function loadMagang()
    {
        $this->magang = Magang::with(['user', 'pembimbingPertama', 'pembimbingKedua', 'pengajuan'])
            ->findOrFail($this->magangId);
            
        if ($this->magang->sertifikat_magang_temp) {
            $this->sertifikatGenerated = true;
            $this->sertifikatPath = $this->magang->sertifikat_magang_temp;
        }
    }

    public function generateSertifikat()
    {
        // Set loading state
        $this->isGenerating = true;
        
        // If there's an existing certificate, delete it first
        $this->deleteExistingCertificate();
        
        // Defer the actual work to allow component to re-render with loading state
        $this->dispatch('generatePdf');
    }
    
    /**
     * Delete existing certificate file from storage
     */
    protected function deleteExistingCertificate()
    {
        if ($this->magang->sertifikat_magang_temp && Storage::exists($this->magang->sertifikat_magang_temp)) {
            // Delete the file from storage
            Storage::delete($this->magang->sertifikat_magang_temp);
        }
    }
    
    /**
     * Generate a new certificate when user clicks "Generate Ulang"
     */
    public function regenerateCertificate()
    {
        // Delete existing certificate
        $this->deleteExistingCertificate();
        
        // Reset state
        $this->sertifikatGenerated = false;
        $this->sertifikatPath = null;
        
        // Update the database to remove reference to certificate
        $this->magang->sertifikat_magang_temp = null;
        $this->magang->save();
        
        // Now start the generation process
        $this->generateSertifikat();
    }
    
    public function doPdfGeneration()
    {
        try {
            // Get data for certificate
            $magang = $this->magang;
            $user = $magang->user;
            
            // Handle nilai_lainnya (JSON field)
            $nilaiLainnya = json_decode($magang->nilai_lainnya ?? '[]', true);
            
            // Prepare data for the certificate
            $data = [
                'nama_peserta' => $user->name,
                'program_magang' => $magang->jenis_magang,
                'tanggal_mulai' => \Carbon\Carbon::parse($magang->tanggal_mulai)->format('d F Y'),
                'tanggal_selesai' => \Carbon\Carbon::parse($magang->tanggal_selesai)->format('d F Y'),
                'asal_institusi' => $magang->pengajuan->institusi,
                'pembimbing' => $magang->pembimbingPertama->name,
                'tanggal' => now()->format('d F Y'),
                'nilai_presensi' => $magang->nilai_presensi,
                'nilai_logbook' => $magang->nilai_logbook,
                'nilai_lainnya' => $nilaiLainnya,
                'total_nilai' => $magang->nilai_magang,
            ];
            
            // Generate PDF
            $pdf = PDF::loadView('pdf.certificate', $data)
                ->setOption([
                    'fontDir' => public_path('/fonts'),
                    'fontCache' => public_path('/fonts'),
                    'defaultFont' => 'DroidSerif',
                ]);
            $pdf->setPaper('a4', 'landscape');
            
            // Save PDF to storage
            $filename = 'sertifikat-temp-' . Str::slug($user->name) . '-' . time() . '.pdf';
            $path = 'public/sertifikat-temp/' . $filename;
            
            Storage::put($path, $pdf->output());
            
            // Update magang record
            $magang->sertifikat_magang_temp = $path;
            $magang->save();
            
            // Update component state
            $this->sertifikatGenerated = true;
            $this->sertifikatPath = $path;
            
            // Turn off loading state
            $this->isGenerating = false;
            
            // Dispatch event for animations
            $this->dispatch('sertifikatGenerated');
        } catch (\Exception $e) {
            $this->isGenerating = false;
            session()->flash('error', 'Gagal membuat sertifikat: ' . $e->getMessage());
        }
    }

    public function submitSertifikat() 
    {
        // Generate nama file baru
        $namaPeserta = Str::slug($this->magang->user->name);
        $extension = $this->sertifikat_magang->getClientOriginalExtension(); // Dapatkan ekstensi file
        $newFilename = "sertifikat-{$namaPeserta}.{$extension}";

        // Simpan file dengan nama baru
        $path = $this->sertifikat_magang->storeAs(
            'sertifikat', 
            $newFilename,
            'public'
        );

        // Update database
        $this->magang->update([
            'sertifikat_magang' => $path,
        ]);

        return redirect('/daftar-bimbingan/' . $this->magang->id)->with([
            'success' => [
                "title" => "Sertifikat berhasil diberikan ke peserta!",
            ]
        ]);
    }
    
    public function downloadSertifikat()
    {
        if ($this->sertifikatPath) {
            return response()->download(
                storage_path('app/' . $this->sertifikatPath), 
                'sertifikat-temp-' . Str::slug($this->magang->user->name) . '.pdf'
            );
        }
    }
    
    public function render()
    {
        return view('livewire.input-sertifikat');
    }
}