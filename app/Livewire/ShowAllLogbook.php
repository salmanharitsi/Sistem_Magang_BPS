<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Logbook;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ShowAllLogbook extends Component
{
    public $logbookData = [];
    public $selectedLogbook;
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
            $this->logbookData = Logbook::where('magang_id', $magang->id)
                ->orderBy('tanggal', 'asc')
                ->get();

            // Set default selectedPresensi ke tanggal saat ini jika tersedia
            $today = Carbon::today()->toDateString();
            $this->selectedLogbook = $this->logbookData->where('tanggal', $today)->first();
            $this->selectedDate = $this->selectedLogbook ? $today : null;
        }
    }

    public function selectLogbook($tanggal)
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
            $this->selectedLogbook = Logbook::where('tanggal', $tanggal)
                ->where('magang_id', $magang->id)
                ->first();
        }
    }

    public function render()
    {
        return view('livewire.show-all-logbook', [
            'logbookData' => $this->logbookData,
            'selectedLogbook' => $this->selectedLogbook,
            'selectedDate' => $this->selectedDate,
        ]);
    }
}
