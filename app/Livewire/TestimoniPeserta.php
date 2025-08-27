<?php

namespace App\Livewire;

use App\Models\Feedback;
use Livewire\Component;
use Livewire\WithPagination;

class TestimoniPeserta extends Component
{
    use WithPagination;
    
    public $search = '';
    public $showConfirmModal = false;
    public $selectedId = null;

    public function updating($key): void
    {
        if ($key === 'search') {
            $this->resetPage();
        }
    }

    public function confirmDisplay($id)
    {
        $this->selectedId = $id;
        $this->showConfirmModal = true;
    }

    public function toggleDisplay()
    {
        $testimoni = Feedback::find($this->selectedId);
        $testimoni->is_displayed = true;
        $testimoni->save();

        $this->showConfirmModal = false;
        $this->selectedId = null;

        // Emit event ke komponen lain untuk refresh
        $this->dispatch('testimoni-updated');

        session()->flash('success', [
            'title' => 'Testimoni berhasil ditampilkan!'
        ]);
    }

    protected $listeners = ['testimoni-updated' => '$refresh'];

    public function render()
    {
        $nonDisplayedTestimonis = Feedback::where('is_displayed', false)
            ->when($this->search, function($query) {
                $query->where('testimoni', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5, ['*'], 'nonDisplayed');

        return view('livewire.testimoni-peserta', [
            'nonDisplayedTestimonis' => $nonDisplayedTestimonis
        ]);
    }
}