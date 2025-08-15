<?php

namespace App\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Validate;
use Livewire\Component;
use App\Models\FungsiBagian;
use App\Models\FungsiBagianJurusan;
use Livewire\WithPagination;

class EditFungsiBagian extends Component
{
    use WithPagination;

    #[Validate]

    public $search = '';
    public $fungsiId;
    public $title;
    public $description;
    public $jurusanInput;
    public $showModal = false;
    public $isEdit = false;
    public $showDeleteModal = false;
    public $deleteId;
    public $deleteTitle;

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'jurusanInput' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'title' => [
                "required" => 'Fungsi bagian tidak boleh kosong',
                "max" => 'Fungsi bagian maksimal 255 karakter'
            ],
            'description' => [
                "required" => 'Deskripsi fungsi bagian tidak boleh kosong',
            ],
            'jurusanInput' => [
                "required" => 'Jurusan tidak boleh kosong',
            ],
        
        ];
    }

    public function updating($key): void
    {
        if ($key === 'search') {
            $this->resetPage();
        }
    }

    public function render()
    {
        $query = FungsiBagian::orderBy('created_at', 'desc');

        if ($this->search) {
            $query->where(function (Builder $builder) {
                $builder->where('title', 'like', '%' . $this->search . '%');
            });
        }

        $fungsiBagian = $query->paginate(5);

        return view('livewire.edit-fungsi-bagian', ['fungsiBagian' => $fungsiBagian]);
    }

    public function create()
    {
        $this->resetModal();
        $this->isEdit = false;
        $this->showModal = true;
    }


    public function store()
    {
        $this->validate();

        $fungsiBagian = FungsiBagian::create([
            'title' => ucwords(strtolower($this->title)),
            'description' => ucfirst(strtolower($this->description)),
        ]);

        // Memproses input jurusan
        $jurusanArray = array_map('trim', explode(',', $this->jurusanInput));
        
        // Filter array untuk menghapus elemen kosong
        $jurusanArray = array_filter($jurusanArray, function($jurusan) {
            return !empty($jurusan); 
        });

        foreach ($jurusanArray as $jurusan) {
            FungsiBagianJurusan::create([
                'fungsi_bagian_id' => $fungsiBagian->id,
                'jurusan' => ucwords(strtolower($jurusan)),
            ]);
        }

        $this->resetModal();

        return redirect('/edit-home?selected=fungsi-bagian')->with([
            'success' => [
                "title" => "Fungsi Bagian berhasil ditambahkan!",
            ]
        ]);
    }

    public function edit($id)
    {
        $fungsiBagian = FungsiBagian::findOrFail($id);
        $this->fungsiId = $fungsiBagian->id;
        $this->title = $fungsiBagian->title;
        $this->description = $fungsiBagian->description;
        $this->jurusanInput = $fungsiBagian->jurusan->pluck('jurusan')->implode(', ');
        $this->isEdit = true;
        $this->showModal = true;
    }

    public function update()
    {
        $this->validate();

        $fungsiBagian = FungsiBagian::findOrFail($this->fungsiId);
        
        // Persiapkan data baru
        $newTitle = ucwords(strtolower($this->title));
        $newDescription = ucfirst(strtolower($this->description));
        
        // Persiapkan jurusan baru
        $jurusanArray = array_map('trim', explode(',', $this->jurusanInput));
        $jurusanArray = array_filter($jurusanArray, function($jurusan) {
            return !empty($jurusan);
        });
        $newJurusan = array_map(function($jurusan) {
            return ucwords(strtolower($jurusan));
        }, $jurusanArray);
        
        // Ambil jurusan lama
        $oldJurusan = $fungsiBagian->jurusan->pluck('jurusan')->toArray();
        
        // Cek apakah ada perubahan
        if ($fungsiBagian->title === $newTitle &&
            $fungsiBagian->description === $newDescription &&
            empty(array_diff($newJurusan, $oldJurusan)) &&
            empty(array_diff($oldJurusan, $newJurusan))) {
            
            return redirect('/edit-home?selected=fungsi-bagian')->with([
                'warning' => [
                    "title" => "Tidak ada perubahan!",
                ]
            ]);
        }
        
        // Lakukan update jika ada perubahan
        $fungsiBagian->update([
            'title' => $newTitle,
            'description' => $newDescription,
        ]);

        // Hapus jurusan lama
        $fungsiBagian->jurusan()->delete();

        // Tambah jurusan baru
        foreach ($newJurusan as $jurusan) {
            FungsiBagianJurusan::create([
                'fungsi_bagian_id' => $fungsiBagian->id,
                'jurusan' => $jurusan,
            ]);
        }

        $this->resetModal();

        return redirect('/edit-home?selected=fungsi-bagian')->with([
            'success' => [
                "title" => "Fungsi Bagian berhasil diperbarui!",
            ]
        ]);
    }

    public function resetModal()
    {
        $this->fungsiId = null;
        $this->title = '';
        $this->description = '';
        $this->jurusanInput = '';
        $this->showModal = false;
        $this->isEdit = false;

        // Reset error bag
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function confirmDelete($id)
    {
        $fungsiBagian = FungsiBagian::find($id);
        $this->deleteId = $id;
        $this->deleteTitle = $fungsiBagian->title; // Simpan title
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        FungsiBagianJurusan::where('fungsi_bagian_id', $this->deleteId)->delete();
        
        FungsiBagian::find($this->deleteId)->delete();
        
        $this->showDeleteModal = false;
        $this->deleteId = null;

        return redirect('/edit-home?selected=fungsi-bagian')->with([
            'success' => [
                "title" => "Fungsi Bagian berhasil dihapus!",
            ]
        ]);
    }
}
