<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Presensi;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ShowAllPresensi extends Component
{
    public $presensiData = [];
    public $selectedPresensi;
    public $selectedDate;
    public $currentSlide = 0;

    protected $listeners = [
        'updateCurrentSlide' => 'setCurrentSlide',
    ];

    public function setCurrentSlide($index)
    {
        $this->currentSlide = $index;
    }

    public function mount()
    {
        $user = Auth::user();

        // Ambil data magang terbaru milik user (jika ada)
        $magang = $user->magang()->latest()->first();

        if ($magang) {
            // Ambil data presensi berdasarkan magang_id
            $this->presensiData = Presensi::where('magang_id', $magang->id)
                ->orderBy('tanggal', 'asc')
                ->get();

            // Set default selectedPresensi ke tanggal saat ini jika tersedia
            $today = Carbon::today()->toDateString();
            $this->selectedPresensi = $this->presensiData->where('tanggal', $today)->first();
            $this->selectedDate = $this->selectedPresensi ? $today : null;
        }
    }

    public function selectPresensi($tanggal)
    {
        $today = Carbon::today()->toDateString();

        // Cek jika tanggal lebih besar dari hari ini, maka tidak bisa diklik
        if ($tanggal > $today) {
            return;
        }

        $user = Auth::user();
        $magang = $user->magang()->latest()->first();

        if ($magang) {
            // Ambil detail presensi berdasarkan tanggal dan user yang login
            $this->selectedDate = $tanggal;
            $this->selectedPresensi = Presensi::where('tanggal', $tanggal)
                ->where('magang_id', $magang->id)
                ->first();
        }
    }

    public function render()
    {
        return view('livewire.show-all-presensi', [
            'presensiData' => $this->presensiData,
            'selectedPresensi' => $this->selectedPresensi,
            'selectedDate' => $this->selectedDate,
        ]);
    }
}