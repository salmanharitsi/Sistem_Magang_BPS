<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Fasilitas;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Storage;

class FasilitasMagang extends Component
{
    use WithPagination, WithFileUploads;

    #[Validate]
    public $fasilitasId, $judul, $image, $image_path;
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
        $query = Fasilitas::orderBy('created_at', 'desc');

        if ($this->search) {
            $query->where('judul', 'like', '%' . $this->search . '%');
        }

        $fasilitas = $query->paginate(5);

        return view('livewire.fasilitas-magang', ['fasilitas' => $fasilitas]);
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

        $imagePath = $this->image->store('fasilitas', 'public');

        Fasilitas::create([
            'judul' => ucfirst(strtolower($this->judul)),
            'image_path' => $imagePath,
        ]);

        $this->resetModal();

        return redirect('/edit-home?selected=fasilitas')->with([
            'success' => [
                "title" => "Fasilitas berhasil ditambahkan!",
            ]
        ]);
    }

    public function edit($id)
    {
        $fasilitas = Fasilitas::findOrFail($id);
        $this->fasilitasId = $fasilitas->id;
        $this->judul = $fasilitas->judul;
        $this->image_path = $fasilitas->image_path;
        $this->isEdit = true;
        $this->showModal = true;
    }

    public function update()
    {
        $this->validate();

        $fasilitas = Fasilitas::find($this->fasilitasId);

        $newJudul = ucfirst(strtolower($this->judul));
        $newImagePath = $fasilitas->image_path;

        if ($this->image) {
            // Hapus gambar lama
            if ($fasilitas->image_path && Storage::disk('public')->exists($fasilitas->image_path)) {
                Storage::disk('public')->delete($fasilitas->image_path);
            }
            $newImagePath = $this->image->store('fasilitas', 'public');
        }

        if ($fasilitas->judul === $newJudul && $fasilitas->image_path === $newImagePath) {
            return redirect('/edit-home?selected=fasilitas')->with([
                'warning' => [
                    "title" => "Tidak ada perubahan!",
                ]
            ]);
        }

        $fasilitas->update([
            'judul' => $newJudul,
            'image_path' => $newImagePath,
        ]);

        $this->resetModal();

        return redirect('/edit-home?selected=fasilitas')->with([
            'success' => [
                "title" => "Fasilitas berhasil diperbarui!",
            ]
        ]);
    }

    public function resetModal()
    {
        $this->fasilitasId = null;
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
        $fasilitas = Fasilitas::find($id);
        $this->deleteId = $id;
        $this->deleteTitle = $fasilitas->judul;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        $fasilitas = Fasilitas::find($this->deleteId);
        if ($fasilitas->image_path && Storage::disk('public')->exists($fasilitas->image_path)) {
            Storage::disk('public')->delete($fasilitas->image_path);
        }
        $fasilitas->delete();

        $this->showDeleteModal = false;
        $this->deleteId = null;

        return redirect('/edit-home?selected=fasilitas')->with([
            'success' => [
                "title" => "Fasilitas berhasil dihapus!",
            ]
        ]);
    }
}
