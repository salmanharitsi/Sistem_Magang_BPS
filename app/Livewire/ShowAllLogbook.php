<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Logbook;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ShowAllLogbook extends Component
{
    public $logbookData = [];
    public $selectedLogbook;
    public $selectedDate;
    public $currentSlide = 0;

    #[\Livewire\Attributes\Rule(['required'])]
    public string $deskripsi = '';
    #[\Livewire\Attributes\Rule(['required'])]
    public string $lampiran = '';

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
        $now = Carbon::now();
        $cutoffTime = Carbon::today()->setHour(17)->setMinute(0)->setSecond(0);

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


                if ($tanggal < $today || ($tanggal == $today && $now->greaterThan($cutoffTime))) {
                    $this->deskripsi = '';
                    $this->lampiran = '';
                }
        }


    }

    public function store() {
        $today = Carbon::today()->toDateString();

        $now = Carbon::now();
        $cutoffTime = Carbon::today()->setHour(17)->setMinute(0)->setSecond(0);

        // Check if it's past 5:00 PM
        if ($this->selectedDate != $today || $now->greaterThan($cutoffTime)) {
            session()->flash('error', [
                'title' => 'Tidak dapat mengisi logbook untuk tanggal ini atau setelah jam 17:00!'
            ]);
            return;
        }
        $this->validate([
            'deskripsi' => 'required',
            'lampiran' => 'required|url'
        ]);

        $user = Auth::user();
        $magang = $user->magang()->latest()->first();

        if (!$magang || !$this->selectedLogbook) {
            return;
        }

        // Update the existing logbook entry instead of creating a new one
        $this->selectedLogbook->update([
            'deskripsi' => $this->deskripsi, // Note: column name is 'kegiatan' in your view
            'lampiran' => $this->lampiran,
            'status' => 'mengisi', // Assuming this is your initial status
            'updated_at' => now()
        ]);

        // Refresh the logbook data
        $this->logbookData = Logbook::where('magang_id', $magang->id)
            ->orderBy('tanggal', 'asc')
            ->get();

        // Update the selected logbook to reflect changes
        $this->selectedLogbook = Logbook::where('tanggal', $this->selectedDate)
            ->where('magang_id', $magang->id)
            ->first();

        // Reset form fields
        $this->deskripsi = '';
        $this->lampiran = '';

        // Show success message
        session()->flash('success', [
            'title' => 'Logbook berhasil ditambah!'
        ]);
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
