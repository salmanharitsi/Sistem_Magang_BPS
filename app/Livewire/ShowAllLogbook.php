<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Logbook;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ShowAllLogbook extends Component
{
    public $logbookData = [];
    public $selectedLogbook;
    public $selectedDate;
    public $currentSlide = 0;
    public $hariKe = null;

    #[Validate]
    public $deskripsi;
    public $lampiran;

    protected $listeners = [
        'updateCurrentSlide' => 'setCurrentSlide',
    ];

    public function rules()
    {
        return [
            'deskripsi' => 'required',
            'lampiran' => 'required|url',
        ];
    }

    public function messages()
    {
        return [
            'deskripsi' => [
                "required" => 'Kegiatan tidak boleh kosong'
            ],
            'lampiran' => [
                "required" => 'Lampiran tidak boleh kosong',
                "url" => 'Lampiran harus berupa URL'
            ]
        ];
    }

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

        if ($this->selectedDate) {
            $selectedDate = Carbon::parse($this->selectedDate);
            if (!$selectedDate->isWeekend()) {
                $this->calculateHariKe($selectedDate);
            }
        }

        // Hitung index slide berdasarkan bulan saat ini
        $this->calculateCurrentSlide();
    }

    protected function calculateCurrentSlide()
    {
        $currentMonth = Carbon::now()->month; // Ambil bulan saat ini (1-12)
        $currentYear = Carbon::now()->year; // Ambil tahun saat ini

        // Kelompokkan data presensi berdasarkan bulan dan tahun
        $groupedLogbook = $this->logbookData->groupBy(function ($item) {
            return Carbon::parse($item->tanggal)->format('F Y');
        });

        // Hitung index slide berdasarkan bulan saat ini
        $this->currentSlide = 0;
        foreach ($groupedLogbook as $month => $logbookGroup) {
            $monthYear = Carbon::parse($logbookGroup->first()->tanggal);
            if ($monthYear->month == $currentMonth && $monthYear->year == $currentYear) {
                break;
            }
            $this->currentSlide++;
        }

        // Jika tidak ada data untuk bulan saat ini, arahkan ke slide terakhir
        if ($this->currentSlide >= count($groupedLogbook)) {
            $this->currentSlide = count($groupedLogbook) - 1;
        }
    }

    public function selectLogbook($tanggal)
    {
        $today = Carbon::today()->toDateString();
        $now = Carbon::now();
        $cutoffTime = Carbon::today()->setHour(17)->setMinute(0)->setSecond(0);
        $tanggalCarbon = Carbon::parse($tanggal);

        // Cek jika tanggal lebih besar dari hari ini, maka tidak bisa diklik
        if ($tanggal > $today) {
            return;
        }

        if ($tanggalCarbon->isWeekend()) {
            $this->selectedLogbook = null;
            $this->selectedDate = $tanggal;
            $this->hariKe = null;
            return;
        }

        $user = Auth::user();
        $magang = $user->magang()->latest()->first();

        // Hitung hari kerja
        $this->calculateHariKe($tanggalCarbon);

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

    protected function calculateHariKe(Carbon $tanggal)
    {
        $user = Auth::user();
        $magang = $user->magang()->latest()->first();
        
        if (!$magang) {
            $this->hariKe = null;
            return;
        }

        $tanggalMulai = Carbon::parse($magang->tanggal_mulai);
        $hariKe = 0;
        
        // Iterasi dari tanggal mulai sampai tanggal yang dipilih
        while ($tanggalMulai <= $tanggal) {
            // Hanya hitung jika bukan weekend
            if (!$tanggalMulai->isWeekend()) {
                $hariKe++;
            }
            $tanggalMulai->addDay();
        }
        
        $this->hariKe = $hariKe;
    }

    public function store() {
        $this->validate();

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
        return redirect('/logbook')->with([
            'success' => [
                "title" => "Berhasil mengisi logbook",
            ]
        ]);
    }

    public function render()
    {
        return view('livewire.show-all-logbook', [
            'logbookData' => $this->logbookData,
            'selectedLogbook' => $this->selectedLogbook,
            'selectedDate' => $this->selectedDate,
            'currentSlide' => $this->currentSlide, 
            'hariKe' => $this->hariKe,
        ]);
    }
}
