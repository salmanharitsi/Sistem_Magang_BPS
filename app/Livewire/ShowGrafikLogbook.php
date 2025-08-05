<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Logbook;
use Carbon\Carbon;
use App\Models\Magang;
use Illuminate\Support\Facades\Auth;


class ShowGrafikLogbook extends Component
{

    public $mengisi = 0;
    public $tidakMengisi = 0;
    public $todayLogbook;
    

    public function mount()
    {

        // Dapatkan user yang sedang login
        $user = Auth::user();

        // Cari magang aktif user
        $magang = Magang::where('user_id', $user->id)
                ->where('status_magang', 'active')
                ->orderBy('created_at', 'desc')
                ->first();

        if ($magang) {
            // Hitung jumlah logbook berdasarkan status
            $this->mengisi = Logbook::where('magang_id', $magang->id)
                ->whereNotNull('pembimbing_id')
                ->where(function ($query) {
                    $query->where('status', 'mengisi')
                          ->where('status_review', 'diterima');
                })
                ->count();
            $this->tidakMengisi = Logbook::where('magang_id', $magang->id)
                ->whereNotNull('pembimbing_id')
                ->where(function ($query) {
                    $query->where('status', 'tidak-mengisi')
                          ->orWhere('status_review', 'ditolak');
                })
                ->count();
            

            // Ambil logbook hari ini
            $this->todayLogbook = Logbook::where('magang_id', $magang->id)
                ->whereDate('tanggal', now()->toDateString())
                ->first();

            if ($this->todayLogbook) {
                // Jika ada logbook hari ini, konversi tanggal ke Carbon
                $this->todayLogbook->tanggal = Carbon::parse($this->todayLogbook->tanggal);
            }
        }

    }

    public function render()
    {
        return view('livewire.show-grafik-logbook', [
            'mengisi' => $this->mengisi,
            'tidakMengisi' => $this->tidakMengisi,
        ]);
    }
}
