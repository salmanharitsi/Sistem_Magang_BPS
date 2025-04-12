<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Presensi;
use App\Models\Magang;
use Illuminate\Support\Facades\Auth;

class ShowGrafikPresensi extends Component
{
    public $hadir = 0;
    public $izin = 0;
    public $tidakHadir = 0;
    public $todayPresensi;

    public function mount()
    {
        // Dapatkan user yang sedang login
        $user = Auth::user();
        
        // Cari magang aktif user
        $magang = Magang::where('user_id', $user->id)
                        ->where('status_magang', 'active')
                        ->first();
        
        if ($magang) {
            // Hitung jumlah presensi berdasarkan status
            $this->hadir = Presensi::where('magang_id', $magang->id)
                                ->where('status', 'hadir')
                                ->count();
            
            $this->izin = Presensi::where('magang_id', $magang->id)
                              ->where('status', 'izin')
                              ->count();
            
            $this->tidakHadir = Presensi::where('magang_id', $magang->id)
                                    ->where('status', 'tidak-hadir')
                                    ->count();

            $this->todayPresensi = Presensi::where('magang_id', $magang->id)
                                    ->whereDate('tanggal', now()->toDateString())
                                    ->first();
            // Jika ada presensi hari ini, konversi tanggal ke Carbon
            if ($this->todayPresensi) {
                $this->todayPresensi->tanggal = Carbon::parse($this->todayPresensi->tanggal);
            }
        }
    }

    public function render()
    {
        return view('livewire.show-grafik-presensi', [
            'hadir' => $this->hadir,
            'izin' => $this->izin,
            'tidakHadir' => $this->tidakHadir,
        ]);
    }
}