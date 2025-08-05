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
                ->whereNotNull('pembimbing_id')
                ->where(function ($query) {
                    $query->where('status', 'mengisi')
                        ->where('status_review', 'diterima');
                })
                ->count();
            $this->tidakMengisi = Logbook::where('magang_id', $this->magang)
                ->whereNotNull('pembimbing_id')
                ->where(function ($query) {
                    $query->where('status', 'tidak-mengisi')
                        ->orWhere('status_review', 'ditolak');
                })
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
