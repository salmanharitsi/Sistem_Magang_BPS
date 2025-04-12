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
    public $filterFungsiBagian = '';
    public $filterRole = '';

    public function updating($key): void
    {
        if ($key === 'search') {
            $this->resetPage();
        }
    }

    public function updatingFilterFungsiBagian()
    {
        $this->resetPage();
    }
    
    public function updatingFilterRole()
    {
        $this->resetPage();
    }
    
    public function resetFilters()
    {
        $this->reset(['filterFungsiBagian', 'filterRole']);
        $this->resetPage();
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

        if ($this->filterFungsiBagian) {
            $query->where('fungsi_bagian', $this->filterFungsiBagian);
        }
        
        if ($this->filterRole) {
            $query->where('role_temp', $this->filterRole);
        }

        $pegawai = $query->paginate(5);

        return view('livewire.show-daftar-pegawai', [
            'pegawai' => $pegawai
        ]);
    }
}