<?php

namespace App\Livewire;

use App\Models\Pegawai;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
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
    public $showEditModal = false;
    public $editingPegawaiId;

    #[Validate]
    public $name, $email, $password, $confirm_password, $nomor_induk, $fungsi_bagian, $role_temp;

    public function create()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function hasPimpinanUser()
    {
        return Pegawai::where('role_temp', 'pimpinan')->exists();
    }

    public function rules()
    {
        $rules = [
            'name' => 'required|min:5',
            'email' => 'required|email|unique:pegawai,email',
            'password' => 'required|min:8|regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/',
            'confirm_password' => 'required_with:password|same:password',
            'nomor_induk' => 'required|min:15|unique:pegawai,nomor_induk',
            'fungsi_bagian' => 'required',
        ];

        if (!$this->hasPimpinanUser())
        {
            $rules['role_temp'] = 'required|in:regular,admin,pimpinan';
        } else {
            $rules['role_temp'] = 'required|in:regular,admin';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name' => [
                "required" => 'Nama tidak boleh kosong',
                "min" => 'Nama minimal 5 karakter',
            ],
            'email' => [
                "required" => 'Email tidak boleh kosong',
                "email" => 'Email tidak valid',
                "unique" => 'Email sudah terdaftar',
            ],
            'password' => [
                "required" => 'Password tidak boleh kosong',
                "min" => 'Password minimal 8 karakter',
                "regex" => 'Password harus mengandung huruf dan angka',
            ],
            'confirm_password' => [
                "required_with" => 'Konfirmasi password tidak boleh kosong jika password diisi',
                "same" => 'Password tidak sesuai',
            ],
            'nomor_induk' => [
                "required" => 'Nomor induk tidak boleh kosong',
                "min" => 'Nomor induk minimal 15 karakter',
                "unique" => 'Nomor induk sudah terdaftar',
            ],
            'fungsi_bagian' => [
                "required" => 'Fungsi bagian tidak boleh kosong',
            ],
            'role_temp' => [
                "required" => 'Role tidak boleh kosong',
                "in" => 'Role tidak valid',
            ],
        ];
    }

    public function resetForm()
    {
        $this->reset(['name', 'email', 'password', 'nomor_induk', 'fungsi_bagian', 'role_temp']);
    }

    public function store()
    {
        $validatedData = $this->validate();

        Pegawai::create([
            'name' => ucwords(strtolower(trim($validatedData['name']))),
            'email' => $validatedData['email'],
            'password' => $validatedData['password'],
            'nomor_induk' => $validatedData['nomor_induk'],
            'fungsi_bagian' => $validatedData['fungsi_bagian'],
            'role_temp' => $validatedData['role_temp'],
            'remember_token' => Str::random(50),
        ]);

        $this->showModal = false;

        return redirect('/daftar-pegawai')->with([
            'success' => [
                "title" => "Berhasil menambahkan data pegawai!",
            ]
        ]);
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

    public function applyFilters()
    {
        $this->resetPage();
    }

    public function closeModal()
    {
        $this->showModal = false;

        // Reset error bag
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function edit($id)
    {
        $this->editingPegawaiId = $id;
        $pegawai = Pegawai::find($id);

        $this->name = $pegawai->name;
        $this->email = $pegawai->email;
        $this->nomor_induk = $pegawai->nomor_induk;
        $this->role_temp = $pegawai->role_temp;

        $this->showEditModal = true;

        // Add debugging
        logger('Edit modal triggered for ID: ' . $id);
        logger('showEditModal status: ' . $this->showEditModal);
    }

    public function update()
    {
        $rules = [
            'name' => 'required|min:5',
            'email' => 'required|email|unique:pegawai,email,' . $this->editingPegawaiId,
            'nomor_induk' => 'required|min:15|unique:pegawai,nomor_induk,' . $this->editingPegawaiId,
            'role_temp' => 'required|in:regular,admin',
        ];

        if ($this->password) {
            $rules['password'] = 'min:8|regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/';
            $rules['confirm_password'] = 'required_with:password|same:password';
        }

        $validatedData = $this->validate($rules);

        $pegawai = Pegawai::find($this->editingPegawaiId);
        $updateData = [
            'name' => ucwords(strtolower(trim($validatedData['name']))),
            'email' => $validatedData['email'],
            'nomor_induk' => $validatedData['nomor_induk'],
            'role_temp' => $validatedData['role_temp'],
        ];

        if ($this->password) {
            $updateData['password'] = $validatedData['password'];
        }

        $pegawai->update($updateData);

        $this->showEditModal = false;
        $this->resetForm();

        return redirect('/daftar-pegawai')->with([
            'success' => [
                "title" => "Berhasil mengubah data pegawai!",
            ]
        ]);
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->resetForm();
        $this->resetErrorBag();
        $this->resetValidation();
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
            'pegawai' => $pegawai,
            'hasPimpinanUser' => $this->hasPimpinanUser()
        ]);
    }
}
