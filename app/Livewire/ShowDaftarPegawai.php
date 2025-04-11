<?php

namespace App\Livewire;

use App\Models\Pegawai;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class ShowDaftarPegawai extends Component
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
        $query = Pegawai::orderBy('created_at', 'desc');

        // Apply search filter if search term is provided
        if ($this->search) {
            $query->where(function (Builder $builder) {
                $builder->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('fungsi_bagian', 'like', '%' . $this->search . '%');
            });
        }

        $pegawai = $query->paginate(5);

        return view('livewire.show-daftar-pegawai', [
            'pegawai' => $pegawai
        ]);
    }
}
