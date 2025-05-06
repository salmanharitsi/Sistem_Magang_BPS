<?php

namespace App\Livewire;

use App\Models\Magang;
use App\Models\Pegawai;
use App\Models\FungsiBagian;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class KelolaPembimbing extends Component
{
    use WithPagination;

    public $search;
    public $statusFilter = '';
    public $listFungsiBagian = [];
    public $pembimbingList = [];
    public $pembimbingList2 = [];
    public $showEditModal = false;
    
    // Form fields
    public $selectedMagangId;
    public $selectedBidangTujuan;
    public $selectedPembimbing1;
    public $selectedPembimbing2;
    public $bidangTujuanName;

    // Validation rules
    protected $rules = [
        'selectedBidangTujuan' => 'required',
        'selectedPembimbing1' => 'required|exists:pegawai,id',
        'selectedPembimbing2' => 'nullable|different:selectedPembimbing1|exists:pegawai,id',
    ];

    protected $messages = [
        'selectedBidangTujuan.required' => 'Bidang tujuan harus dipilih',
        'selectedPembimbing1.required' => 'Pembimbing pertama harus dipilih',
        'selectedPembimbing1.exists' => 'Pembimbing pertama tidak ditemukan',
        'selectedPembimbing2.different' => 'Pembimbing kedua tidak boleh sama dengan pembimbing pertama',
    ];

    public function updating($key): void
    {
        if (in_array($key, ['search', 'statusFilter'])) {
            $this->resetPage();
        }
    }

    public function mount()
    {
        $this->listFungsiBagian = FungsiBagian::orderBy('title')->get();
    }

    public function updatedSelectedBidangTujuan()
    {
        if (!empty($this->selectedBidangTujuan)) {
            $fungsiBagian = FungsiBagian::find($this->selectedBidangTujuan);
            $this->bidangTujuanName = $fungsiBagian->title;
            
            // Get pegawai with matching fungsi_bagian
            $this->pembimbingList = Pegawai::where('fungsi_bagian', $this->bidangTujuanName)
                ->orderBy('name')
                ->get();
                
            $this->loadPembimbingList2();
            
            // Reset selected pembimbing when bidang changes
            $this->selectedPembimbing1 = '';
            $this->selectedPembimbing2 = '';
        } else {
            $this->pembimbingList = [];
            $this->pembimbingList2 = [];
        }
    }
    
    public function updatedSelectedPembimbing1()
    {
        $this->loadPembimbingList2();
        
        // Reset pembimbing 2 if it's the same as pembimbing 1
        if ($this->selectedPembimbing2 == $this->selectedPembimbing1) {
            $this->selectedPembimbing2 = '';
        }
    }
    
    private function loadPembimbingList2()
    {
        if (!empty($this->selectedBidangTujuan)) {
            $fungsiBagian = FungsiBagian::find($this->selectedBidangTujuan);
            $this->bidangTujuanName = $fungsiBagian->title;
            
            // Filter out the first pembimbing from the second dropdown
            $this->pembimbingList2 = Pegawai::where('fungsi_bagian', $this->bidangTujuanName)
                ->when($this->selectedPembimbing1, function($query) {
                    return $query->where('id', '!=', $this->selectedPembimbing1);
                })
                ->orderBy('name')
                ->get();
        } else {
            $this->pembimbingList2 = [];
        }
    }

    public function confirmEdit($id)
    {
        $magang = Magang::with('pembimbingPertama', 'pembimbingKedua')->find($id);
        
        if ($magang) {
            $this->selectedMagangId = $magang->id;
            
            $fungsiBagian = FungsiBagian::where('title', $magang->bidang_tujuan)->first();
            if ($fungsiBagian) {
                $this->selectedBidangTujuan = $fungsiBagian->id;
                $this->bidangTujuanName = $fungsiBagian->title;
                
                $this->pembimbingList = Pegawai::where('fungsi_bagian', $this->bidangTujuanName)
                    ->orderBy('name')
                    ->get();
                
                    $this->selectedPembimbing1 = $magang->pembimbingPertama?->id;
                    $this->selectedPembimbing2 = $magang->pembimbingKedua?->id;                    
                
                $this->loadPembimbingList2();
            }
        }
        
        $this->showEditModal = true; 
    }
    
    public function updatePembimbing()
    {
        $this->validate();

        $magang = Magang::find($this->selectedMagangId);
        if ($magang) {
            $fungsiBagian = FungsiBagian::find($this->selectedBidangTujuan);

            // Ambil data baru
            $newBidangTujuan = $fungsiBagian->title;
            $newPembimbing1 = $this->selectedPembimbing1;
            $newPembimbing2 = $this->selectedPembimbing2 ?: null;

            // Cek apakah ada perubahan
            if (
                $magang->bidang_tujuan === $newBidangTujuan &&
                $magang->pembimbing_pertama === $newPembimbing1 &&
                $magang->pembimbing_kedua === $newPembimbing2
            ) {
                return redirect('/kelola-pembimbing')->with([
                    'warning' => [
                        'title' => 'Tidak ada perubahan data!',
                    ]
                ]);
            }

            // Lakukan update jika ada perubahan
            $magang->update([
                'bidang_tujuan' => $newBidangTujuan,
                'pembimbing_pertama' => $newPembimbing1,
                'pembimbing_kedua' => $newPembimbing2,
            ]);

            $this->resetModal();

            return redirect('/kelola-pembimbing')->with([
                'success' => [
                    'title' => 'Data berhasil diperbarui',
                ]
            ]);
        }
    }

    public function resetModal()
    {
        $this->resetValidation();
        $this->showEditModal = false;
        $this->selectedMagangId = null;
        $this->selectedBidangTujuan = '';
        $this->selectedPembimbing1 = '';
        $this->selectedPembimbing2 = '';
        $this->pembimbingList = [];
        $this->pembimbingList2 = [];
    }

    public function render()
    {
        // Build the base query
        $query = Magang::with('pembimbingPertama', 'pembimbingKedua', 'user', 'pengajuan')
            ->where('tanggal_selesai', '>', Carbon::now()->subDays(1))
            ->orderBy('created_at', 'desc');

        // Apply search filter if search term is provided
        if ($this->search) {
            $query->where(function (Builder $builder) {
                $builder->where('bidang_tujuan', 'like', '%' . $this->search . '%')
                    ->orWhereHas('user', function (Builder $query) {
                        $query->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('pengajuan', function (Builder $query) {
                        $query->where('institusi', 'like', '%' . $this->search . '%');
                    });
            });
        }

        // Apply status filter if selected
        if ($this->statusFilter) {
            $query->where('bidang_tujuan', $this->statusFilter);
        }

        // Paginate the results
        $magang = $query->paginate(5);

        return view('livewire.kelola-pembimbing', [
            'magang' => $magang
        ]);
    }
}