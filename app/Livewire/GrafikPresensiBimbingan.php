<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Presensi;
use App\Models\Bimbingan;
use App\Models\Magang;

class GrafikPresensiBimbingan extends Component
{
    public $magang; // ID magang yang dikirim dari view
    public $hadir = 0;
    public $izin = 0;
    public $tidakHadir = 0;

    public function mount($magang)
    {
        $this->magang = $magang;
        
        // Validasi jika magang ditemukan
        $magangData = Magang::find($this->magang);
        
        if ($magangData) {
            // Hitung jumlah presensi berdasarkan status
            $this->hadir = Presensi::where('magang_id', $this->magang)
                                  ->where('status', 'hadir')
                                  ->count();
            
            $this->izin = Presensi::where('magang_id', $this->magang)
                                ->where('status', 'izin')
                                ->count();
            
            $this->tidakHadir = Presensi::where('magang_id', $this->magang)
                                      ->where('status', 'tidak-hadir')
                                      ->count();
        }
    }

    public function render()
    {
        return view('livewire.grafik-presensi-bimbingan', [
            'hadir' => $this->hadir,
            'izin' => $this->izin,
            'tidakHadir' => $this->tidakHadir,
        ]);
    }
}