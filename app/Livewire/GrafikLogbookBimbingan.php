<?php

namespace App\Livewire;

use App\Models\Logbook;
use App\Models\Magang;
use Livewire\Component;

class GrafikLogbookBimbingan extends Component
{
    public $magang;
    public $mengisi = 0;
    public $tidakMengisi = 0;

    public function mount($magang)
    {
        $this->magang = $magang;
        
        // Validasi jika magang ditemukan
        $magangData = Magang::find($this->magang);
        
        if ($magangData) {
            // Hitung jumlah logbook berdasarkan status
            $this->mengisi = Logbook::where('magang_id', $this->magang)
                ->where('status', 'mengisi')
                ->count();
            $this->tidakMengisi = Logbook::where('magang_id', $this->magang)
                ->where('status', 'tidak-mengisi')
                ->count();
        }
    }


    public function render()
    {
        return view('livewire.grafik-logbook-bimbingan', [
            'mengisi' => $this->mengisi,
            'tidakMengisi' => $this->tidakMengisi
        ]);
    }
}
