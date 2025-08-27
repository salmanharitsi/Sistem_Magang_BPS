<?php

namespace App\Livewire;

use App\Models\Feedback;
use Livewire\Component;
use Livewire\WithPagination;

class TestimoniDitampilkan extends Component
{
    use WithPagination;
    
    public $searchDisplayed = '';
    public $showHideModal = false;
    public $selectedId = null;

    public function updating($key): void
    {
        if ($key === 'searchDisplayed') {
            $this->resetPage();
        }
    }

    public function confirmHide($id)
    {
        $this->selectedId = $id;
        $this->showHideModal = true;
    }

    public function toggleDisplay()
    {
        $testimoni = Feedback::find($this->selectedId);
        $testimoni->is_displayed = false;
        $testimoni->save();

        $this->showHideModal = false;
        $this->selectedId = null;

        // Emit event ke komponen lain untuk refresh
        $this->dispatch('testimoni-updated');

        session()->flash('success', [
            'title' => 'Testimoni berhasil disembunyikan!'
        ]);
    }

    protected $listeners = ['testimoni-updated' => '$refresh'];

    public function render()
    {
        $displayedTestimonis = Feedback::where('is_displayed', true)
            ->when($this->searchDisplayed, function($query) {
                $query->where('testimoni', 'like', '%' . $this->searchDisplayed . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5, ['*'], 'displayed');

        return view('livewire.testimoni-ditampilkan', [
            'displayedTestimonis' => $displayedTestimonis
        ]);
    }
}