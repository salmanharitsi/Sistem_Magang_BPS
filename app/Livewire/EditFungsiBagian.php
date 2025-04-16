<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\FungsiBagian;
use App\Models\FungsiBagianJurusan;

class EditFungsiBagian extends Component
{

    public $search = '';
    public $fungsiId;
    public $title;
    public $description;
    public $jurusanInput;
    public $showModal = false;
    public $isEdit = false;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'jurusanInput' => 'required|string',
    ];

    public function render()
    {
        $fungsiBagian = FungsiBagian::where('title', 'like', '%' . $this->search . '%')->get();
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
        'title' => $this->title,
        'description' => $this->description,
    ]);

    $jurusanArray = array_map('trim', explode(',', $this->jurusanInput));

    foreach ($jurusanArray as $jurusan) {
        FungsiBagianJurusan::create([
            'fungsi_bagian_id' => $fungsiBagian->id,
            'jurusan' => $jurusan,
        ]);
    }

    session()->flash('message', 'Fungsi Bagian berhasil ditambahkan.');
    $this->resetModal();
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
    $fungsiBagian->update([
        'title' => $this->title,
        'description' => $this->description,
    ]);

    // Hapus jurusan lama
    $fungsiBagian->jurusan()->delete();

    // Tambah jurusan baru
    $jurusanArray = array_map('trim', explode(',', $this->jurusanInput));
    foreach ($jurusanArray as $jurusan) {
        FungsiBagianJurusan::create([
            'fungsi_bagian_id' => $fungsiBagian->id,
            'jurusan' => $jurusan,
        ]);
    }

    session()->flash('message', 'Fungsi Bagian berhasil diperbarui.');
    $this->resetModal();
    }

    public function resetModal()
    {
        $this->fungsiId = null;
        $this->title = '';
        $this->description = '';
        $this->jurusanInput = '';
        $this->showModal = false;
        $this->isEdit = false;
    }
}
