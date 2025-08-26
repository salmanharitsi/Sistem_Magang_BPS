<?php

namespace App\Livewire;

use App\Models\Galeri;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class EditGaleri extends Component
{
    use WithPagination, WithFileUploads;

    #[Validate]
    public $galeriId, $judul, $image, $image_path;
    public $search = '';
    public $showModal = false;
    public $isEdit = false;
    public $showDeleteModal = false;
    public $deleteId;
    public $deleteTitle;

    public function rules()
    {
        return [
            'judul' => 'required|string|max:255',
            'image' => $this->isEdit ? 'nullable|image|max:2048' : 'required|image|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'judul.required' => 'Judul tidak boleh kosong',
            'image.required' => 'Gambar wajib diunggah',
            'image.image' => 'File harus berupa gambar',
            'image.max' => 'Tidak dapat mengunggah gambar lebih dari 2MB',
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
        $query = Galeri::orderBy('created_at', 'desc');

        if ($this->search) {
            $query->where('judul', 'like', '%' . $this->search . '%');
        }

        $galeris = $query->paginate(5);

        return view('livewire.edit-galeri', ['galeris' => $galeris]);
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

        $imagePath = $this->image->store('galeri', 'public');

        Galeri::create([
            'judul' => ucfirst(strtolower($this->judul)),
            'image_path' => $imagePath,
        ]);

        $this->resetModal();

        return redirect('/edit-home?selected=galeri')->with([
            'success' => [
                "title" => "Galeri berhasil ditambahkan!",
            ]
        ]);
    }

    public function edit($id)
    {
        $galeri = Galeri::findOrFail($id);
        $this->galeriId = $galeri->id;
        $this->judul = $galeri->judul;
        $this->image_path = $galeri->image_path;
        $this->isEdit = true;
        $this->showModal = true;
    }

    public function update()
    {
        $this->validate();

        $galeri = Galeri::find($this->galeriId);

        $newJudul = ucfirst(strtolower($this->judul));
        $newImagePath = $galeri->image_path;

        if ($this->image) {
            // Hapus gambar lama
            if ($galeri->image_path && Storage::disk('public')->exists($galeri->image_path)) {
                Storage::disk('public')->delete($galeri->image_path);
            }
            $newImagePath = $this->image->store('galeri', 'public');
        }

        if ($galeri->judul === $newJudul && $galeri->image_path === $newImagePath) {
            return redirect('/edit-home?selected=galeri')->with([
                'warning' => [
                    "title" => "Tidak ada perubahan!",
                ]
            ]);
        }

        $galeri->update([
            'judul' => $newJudul,
            'image_path' => $newImagePath,
        ]);

        $this->resetModal();

        return redirect('/edit-home?selected=galeri')->with([
            'success' => [
                "title" => "Galeri berhasil diperbarui!",
            ]
        ]);
    }

    public function resetModal()
    {
        $this->galeriId = null;
        $this->judul = '';
        $this->image = null;
        $this->image_path = null;
        $this->showModal = false;
        $this->isEdit = false;
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function confirmDelete($id)
    {
        $galeri = Galeri::find($id);
        $this->deleteId = $id;
        $this->deleteTitle = $galeri->judul;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        $galeri = Galeri::find($this->deleteId);
        if ($galeri->image_path && Storage::disk('public')->exists($galeri->image_path)) {
            Storage::disk('public')->delete($galeri->image_path);
        }
        $galeri->delete();

        $this->showDeleteModal = false;
        $this->deleteId = null;

        return redirect('/edit-home?selected=galeri')->with([
            'success' => [
                "title" => "Galeri berhasil dihapus!",
            ]
        ]);
    }
}
