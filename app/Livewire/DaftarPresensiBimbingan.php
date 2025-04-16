<?php

namespace App\Livewire;

use App\Models\Magang;
use App\Models\Presensi;
use Livewire\Component;
use Livewire\WithPagination;

class DaftarPresensiBimbingan extends Component
{
    use WithPagination; // Penting untuk pagination Livewire
    
    public $magang; // ID magang yang dikirim dari view
    
    // Hapus property $presensi karena kita tidak menyimpan paginator di property

    public function mount($magang)
    {
        $this->magang = $magang;
        Magang::findOrFail($this->magang); // Validasi magang
    }

    public function render()
    {
        // Langsung return query paginate di view data
        $presensi = Presensi::where('magang_id', $this->magang)
            ->where('status', '!=', 'waiting')
            ->orderBy('tanggal', 'desc')
            ->paginate(5);
        
        return view('livewire.daftar-presensi-bimbingan', [
            'presensi' => $presensi // Langsung passing hasil query
        ]);
    }
}