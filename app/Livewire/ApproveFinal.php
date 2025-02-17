<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Pegawai;

class ApproveFinal extends Component
{
    public $pengajuan;
    public $pembimbingList;
    public $pembimbing1 = null;
    public $pembimbing2 = null;
    public $showTerimaModal = false;
    public $showTolakModal = false;

    public function mount($pengajuan)
    {
        $this->pengajuan = $pengajuan;
        $this->pembimbingList = Pegawai::where('fungsi_bagian', $pengajuan->bidang_tujuan)
            ->get();
    }

    // Method untuk mendapatkan daftar pembimbing yang tersedia untuk pembimbing 2
    public function getPembimbing2Options()
    {
        return $this->pembimbingList->filter(function ($pembimbing) {
            return $pembimbing->id != $this->pembimbing1;
        });
    }

    // Tambahkan method untuk menangani persetujuan
    public function terimaPengajuan()
    {
        // Logika untuk menerima pengajuan
        // ...
        $this->showTerimaModal = false;
    }

    // Tambahkan method untuk menangani penolakan
    public function tolakPengajuan()
    {
        // Logika untuk menolak pengajuan
        // ...
        $this->showTolakModal = false;
    }

    public function setShowTerimaModal($value)
    {
        $this->showTerimaModal = $value;
        if ($value) {
            $this->showTolakModal = false;
        }
    }

    public function setShowTolakModal($value)
    {
        $this->showTolakModal = $value;
        if ($value) {
            $this->showTerimaModal = false;
        }
    }

    public function render()
    {
        return view('livewire.approve-final', [
            'pembimbing2Options' => $this->getPembimbing2Options()
        ]);
    }
}
