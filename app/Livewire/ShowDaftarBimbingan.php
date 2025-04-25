<?php

namespace App\Livewire;

use App\Models\Magang;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ShowDaftarBimbingan extends Component
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
        $now = Carbon::now();
        $query = Magang::where(function (Builder $builder) {
            $builder->where('pembimbing_pertama', Auth::guard('pegawai')->id())
                ->orWhere('pembimbing_kedua', Auth::guard('pegawai')->id());
        });

        if ($this->search) {
            $query->where(function (Builder $builder) {
                $builder->where('jenis_magang', 'like', '%' . $this->search . '%')
                    ->orWhereHas('pengajuan', function (Builder $query) {
                        $query->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('institusi', 'like', '%' . $this->search . '%');
                    });
            });
        }

        if ($this->statusFilter) {
            $query->where(function (Builder $builder) use ($now) {
                if ($this->statusFilter === 'soon') {
                    $builder->where('status_magang', 'active')
                           ->whereDate('tanggal_mulai', '>', $now);
                } elseif ($this->statusFilter === 'ongoing') {
                    $builder->where('status_magang', 'active')
                           ->whereDate('tanggal_mulai', '<=', $now)
                           ->whereDate('tanggal_selesai', '>=', $now);
                } elseif ($this->statusFilter === 'ended') {
                    $builder->where('status_magang', 'active')
                           ->whereDate('tanggal_selesai', '<', $now);
                }
            });
        }

        $bimbingan = $query->orderBy('created_at', 'desc')->paginate(5);

        return view('livewire.show-daftar-bimbingan', [
            'bimbingan' => $bimbingan
        ]);
    }
}