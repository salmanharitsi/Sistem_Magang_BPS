<?php

namespace App\Livewire;

use App\Models\Magang;
use App\Models\Presensi;
use Livewire\Component;
use Livewire\WithPagination;

class DaftarPresensiBimbingan extends Component
{
    use WithPagination; 
    
    public $magang; 

    public function mount($magang)
    {
        $this->magang = $magang;
        Magang::findOrFail($this->magang); 
    }

    public function render()
    {
        $presensi = Presensi::where('magang_id', $this->magang)
            ->where('status', '!=', 'waiting')
            ->orderBy('tanggal', 'desc')
            ->paginate(5);
        
        return view('livewire.daftar-presensi-bimbingan', [
            'presensi' => $presensi 
        ]);
    }
}