<?php

namespace App\Livewire;

use App\Models\Magang;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ShowDaftarMagang extends Component
{
    use WithPagination;

    public $search;
    public $statusFilter = '';

    public function updating($key): void
    {
        if (in_array($key, ['search', 'statusFilter'])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        // Build the base query
        $query = Magang::with('pembimbingPertama', 'pembimbingKedua')
            ->orderBy('created_at', 'desc');

        // Apply search filter if search term is provided
        if ($this->search) {
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

        // Paginate the results
        $magang = $query->paginate(5);

        return view('livewire.show-daftar-magang', [
            'magang' => $magang
        ]);
    }
}