<?php

namespace App\Livewire;

use App\Models\Magang;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ShowDaftarBimbingan extends Component
{
    use WithPagination;

    public $search;

    public function updating($key): void
    {
        if ($key === 'search') {
            $this->resetPage();
        }
    }

    public function render()
    {
        $query = Magang::where(function (Builder $builder) {
            $builder->where('pembimbing_pertama', Auth::guard('pegawai')->id())
                ->orWhere('pembimbing_kedua', Auth::guard('pegawai')->id());
        });

        if ($this->search) {
            $query->where(function (Builder $builder) {
                $builder->where('jenis_magang', 'like', '%' . $this->search . '%')
                    ->orWhereHas('user', function (Builder $query) {
                        $query->where('name', 'like', '%' . $this->search . '%');
                    });
            });
        }

        $bimbingan = $query->orderBy('created_at', 'desc')->paginate(3);

        return view('livewire.show-daftar-bimbingan', [
            'bimbingan' => $bimbingan
        ]);
    }
}
