<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;

class DetailNilaiPeserta extends Component
{
    public $magang;

    public function mount($magang)
    {
        $this->magang = $magang;
    }

    public function downloadSertifikat()
    {
        if ($this->magang->sertifikat_magang) {
            return Storage::disk('public')->download(
                $this->magang->sertifikat_magang,
                'sertifikat-' . Str::slug($this->magang->user->name) . '.pdf'
            );
        }
    }

    public function render()
    {
        return view('livewire.detail-nilai-peserta');
    }
}
