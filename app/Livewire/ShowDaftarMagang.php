<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Magang;
use App\Models\Pegawai;
use Livewire\Component;
use App\Models\Pengajuan;
use App\Models\FungsiBagian;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class ShowDaftarMagang extends Component
{
    use WithPagination;

    public $search;
    public $statusFilter = '';
    public $filterFungsiBagian = '';
    public $filterAsalInstansi = '';
    public $filterPembimbing = '';
    public $filterBulanMulai = '';
    public $filterBulanSelesai = '';
    public $listFungsiBagian = [];
    public $listAsalInstansi = [];
    public $listPembimbing = [];
    public $totalMagangAktif = 0; // Added property to store count
    public $isFiltered = false; // Flag to check if any filter is applied
    public $listBulan = [
        '01' => 'Januari',
        '02' => 'Februari',
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember'
    ];

    protected $rules = [
        'filterBulanMulai' => 'nullable|string',
        'filterBulanSelesai' => 'nullable|string|gte:filterBulanMulai',
    ];

    protected $messages = [
        'filterBulanSelesai.gte' => 'Bulan selesai tidak boleh sebelum bulan mulai',
    ];
    

    public function updating($key): void
    {
        if (in_array($key, [
            'search', 
            'statusFilter', 
            'filterFungsiBagian', 
            'filterAsalInstansi', 
            'filterPembimbing',
            'filterBulanMulai',
            'filterBulanSelesai'
        ])) {
            $this->resetPage();
        }
    }
    

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updatingFilterFungsiBagian()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->listFungsiBagian = FungsiBagian::orderBy('title')->get();

        $this->listAsalInstansi = Pengajuan::select('institusi')
            ->distinct()
            ->orderBy('institusi')
            ->pluck('institusi');

        $this->listPembimbing = Pegawai::orderBy('name')->get();
    }

    public function applyFilters()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Reset isFiltered flag
        $this->isFiltered = false;
        
        // Build the base query
        $query = Magang::with('pembimbingPertama', 'pembimbingKedua')
            ->orderBy('created_at', 'desc');

        // Apply search filter if search term is provided
        if ($this->search) {
            $this->isFiltered = true;
            $query->where(function (Builder $builder) {
                $builder->where('jenis_magang', 'like', '%' . $this->search . '%')
                    ->orWhere('bidang_tujuan', 'like', '%' . $this->search . '%')
                    ->orWhereHas('user', function (Builder $query) {
                        $query->where('name', 'like', '%' . $this->search . '%');
                    });
            });
        }

        // Apply status filter if selected
        if ($this->statusFilter) {
            $this->isFiltered = true;
            $query->where(function (Builder $builder) {
                $builder->where('status_magang', 'active');

                if ($this->statusFilter === 'segera-dimulai') {
                    $builder->whereDate('tanggal_mulai', '>', Carbon::now());
                } elseif ($this->statusFilter === 'berlangsung') {
                    $builder->whereDate('tanggal_mulai', '<=', Carbon::now())
                            ->whereDate('tanggal_selesai', '>=', Carbon::now());
                } elseif ($this->statusFilter === 'selesai') {
                    $builder->whereDate('tanggal_selesai', '<', Carbon::now());
                }
            });
        }

        if ($this->filterFungsiBagian) {
            $this->isFiltered = true;
            $query->where('bidang_tujuan', $this->filterFungsiBagian);
        }
        
        if ($this->filterAsalInstansi) {
            $this->isFiltered = true;
            $query->whereHas('pengajuan', function($q) {
                $q->where('institusi', $this->filterAsalInstansi);
            });
        }

        if ($this->filterPembimbing) {
            $this->isFiltered = true;
            $query->where(function($q) {
                $q->where('pembimbing_pertama', $this->filterPembimbing)
                  ->orWhere('pembimbing_kedua', $this->filterPembimbing);
            });
        }

        if ($this->filterBulanMulai && $this->filterBulanSelesai && $this->filterBulanSelesai >= $this->filterBulanMulai) {
            $this->isFiltered = true;
            $query->where(function($q) {
                $q->whereMonth('tanggal_mulai', '>=', $this->filterBulanMulai)
                  ->whereMonth('tanggal_selesai', '<=', $this->filterBulanSelesai);
            });
        } elseif ($this->filterBulanMulai) {
            $this->isFiltered = true;
            $query->whereMonth('tanggal_mulai', $this->filterBulanMulai);
        } elseif ($this->filterBulanSelesai) {
            $this->isFiltered = true;
            $query->whereMonth('tanggal_selesai', $this->filterBulanSelesai);
        }

        // Get total count before pagination
        $this->totalMagangAktif = $query->count();

        // Paginate the results
        $magang = $query->paginate(5);

        return view('livewire.show-daftar-magang', [
            'magang' => $magang
        ]);
    }
}