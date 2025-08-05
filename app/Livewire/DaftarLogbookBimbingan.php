<?php

namespace App\Livewire;

use App\Models\Logbook;
use App\Models\Magang;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class DaftarLogbookBimbingan extends Component
{
    use WithPagination; 
    
    public $magang; 
    public $search;
    public $statusFilter = '';
    public $showModal = false;
    public $selectedData = [];

    public function updating($key): void
    {
        if (in_array($key, ['search', 'statusFilter'])) {
            $this->resetPage();
        }
    }

    public function mount($magang)
    {
        $this->magang = $magang;
        Magang::findOrFail($this->magang); 
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedData = [];
    }

    public function showDetail($id)
    {
        $logbook = Logbook::with('magang.user')->find($id);

        if ($logbook) {
            $this->originalStatus = $logbook->status;
            $this->selectedData = [
                'id' => $logbook->id,
                'nama' => $logbook->magang->user->name,
                'jenis_magang' => $logbook->magang->jenis_magang,
                'tanggal' => $logbook->tanggal,
                'deskripsi' => $logbook->deskripsi,
                'lampiran' => $logbook->lampiran,
                'status' => $logbook->status,
                'komentar' => $logbook->komentar,
                'updated_at' => $logbook->updated_at,
                'pembimbing_id' => $logbook->pembimbing->name ?? null
            ];
            $this->showModal = true;
        }
    }

    public function downloadPresensiPdf()
    {
        $this->isDownloading = true;
        
        try {            
            // Determine which magang to use
            if ($this->magang) {
                $magang = Magang::where('id', $this->magang)
                                ->first();
            }

            if (!$magang) {
                session()->flash('error', 'Data magang tidak ditemukan.');
                $this->isDownloading = false;
                return;
            }
            
            // Get all presensi data for this magang (not just the paginated ones)
            $logbookData = Logbook::where('magang_id', $magang->id)
                                  ->where('status', '!=', 'waiting')
                                  ->orderBy('tanggal', 'desc')
                                  ->get();
            
            // Apply status filter if selected
            if ($this->statusFilter) {
                $logbookData = $logbookData->where('status', $this->statusFilter);
            }
            
            // Get user and magang data
            $userData = [
                'nama' => $magang->user->name,
                'institusi' => $magang->pengajuan->institusi ?? '-',
                'nomor_induk' => $magang->user->nomor_induk ?? '-',
                'jenis_magang' => $magang->jenis_magang,
                'tanggal_mulai' => Carbon::parse($magang->tanggal_mulai)->format('d F Y'),
                'tanggal_selesai' => Carbon::parse($magang->tanggal_selesai)->format('d F Y'),
                'pembimbing' => $magang->pembimbingPertama->name ?? '-',
            ];
            
            // Prepare data for the PDF
            $data = [
                'userData' => $userData,
                'logbook' => $logbookData,
                'tanggal_cetak' => Carbon::now()->locale('id')->translatedFormat('d F Y'),
            ];
            
            // Generate PDF
            $pdf = Pdf::loadView('pdf.logbook-report', $data);
            
            $this->isDownloading = false;
            
            // Return the PDF for download
            return response()->streamDownload(function() use ($pdf) {
                echo $pdf->output();
            }, 'laporan-logbook-' . Str::slug($magang->user->name) . '.pdf');
            
        } catch (\Exception $e) {
            $this->isDownloading = false;
            session()->flash('error', 'Gagal mengunduh laporan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $query = Logbook::where('magang_id', $this->magang)
            ->where('status', '!=', 'waiting')
            ->orderBy('tanggal', 'desc');
        
        if ($this->search) {
            $search = strtolower($this->search);

            // Mapping hari dan bulan dalam bahasa Indonesia ke bahasa Inggris
            $indo_days = [
                'minggu' => 'Sunday',
                'senin' => 'Monday',
                'selasa' => 'Tuesday',
                'rabu' => 'Wednesday',
                'kamis' => 'Thursday',
                'jumat' => 'Friday',
                'sabtu' => 'Saturday',
            ];

            $indo_months = [
                'januari' => 'January',
                'februari' => 'February',
                'maret' => 'March',
                'april' => 'April',
                'mei' => 'May',
                'juni' => 'June',
                'juli' => 'July',
                'agustus' => 'August',
                'september' => 'September',
                'oktober' => 'October',
                'november' => 'November',
                'desember' => 'December',
            ];

            $english_day = $indo_days[$search] ?? null;
            $english_month = $indo_months[$search] ?? null;

            $query->where(function ($q) use ($search, $english_day, $english_month) {
                $q->where('status', 'like', '%' . $search . '%')
                  ->orWhereHas('pembimbing', function ($q) use ($search) { $q->where('name', 'like', '%' . $search . '%'); })
                  ->orWhereRaw("DAY(tanggal) LIKE ?", ["%$search%"])
                  ->orWhereRaw("YEAR(tanggal) LIKE ?", ["%$search%"]);

                if ($english_day) {
                    $q->orWhereRaw("DAYNAME(tanggal) = ?", [$english_day]);
                }

                if ($english_month) {
                    $q->orWhereRaw("MONTHNAME(tanggal) = ?", [$english_month]);
                }
            });
        }

        // Apply status filter if selected
        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        $logbook = $query->paginate(3);

        return view('livewire.daftar-logbook-bimbingan', [
            'logbook' => $logbook
        ]);
    }
}
