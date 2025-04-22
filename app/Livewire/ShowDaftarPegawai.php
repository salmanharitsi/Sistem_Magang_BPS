<?php

namespace App\Livewire;

use App\Models\Pegawai;
use Livewire\Component;
use App\Models\FungsiBagian;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

class ShowDaftarPegawai extends Component
{
    use WithPagination;

    public $search;
    public $filterFungsiBagian = '';
    public $filterRole = '';
    public $listFungsiBagian = [];
    public $showModal = false;

    public $nama, $email, $password, $nomor_induk, $fungsi_bagian, $role_temp;

    public function create()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function resetForm()
    {
        $this->reset(['nama', 'email', 'password', 'nomor_induk', 'fungsi_bagian', 'role_temp']);
    }

    public function store()
    {
        $this->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pegawai,email',
            'password' => 'required|string|min:6',
            'nomor_induk' => 'required|string|max:50',
            'fungsi_bagian' => 'required|string',
            'role_temp' => 'required|in:regular,admin',
        ]);

        Pegawai::create([
            'name' => $this->nama,
            'email' => $this->email,
            'password' => $this->password, 
            'nomor_induk' => $this->nomor_induk,
            'fungsi_bagian' => $this->fungsi_bagian,
            'role_temp' => $this->role_temp,
        ]);

        session()->flash('message', 'Pegawai berhasil ditambahkan.');
        $this->showModal = false;
    }

    public function mount()
    {
        
        $this->listFungsiBagian = FungsiBagian::orderBy('title')->get();
    }

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
