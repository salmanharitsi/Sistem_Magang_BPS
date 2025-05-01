<?php

namespace App\Livewire;

use Livewire\Component;

class DetailNilaiPeserta extends Component
{
    public $magang;

    public function mount($magang)
    {
        $this->magang = $magang;
    }

    public function render()
    {
        return view('livewire.detail-nilai-peserta');
    }
}
