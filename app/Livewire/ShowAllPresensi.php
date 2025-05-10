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
    public $hariKe = null;
    public $statusMasuk; 
    public $statusKeluar;

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

            // Hitung hari ke- untuk tanggal yang dipilih
            // Di dalam method mount()
            if ($this->selectedDate) {
                $selectedDate = Carbon::parse($this->selectedDate);
                if (!$selectedDate->isWeekend()) {
                    $this->calculateHariKe($selectedDate);
                    $this->checkAttendanceStatus();
                }
            }

            // Hitung index slide berdasarkan bulan saat ini
            $this->calculateCurrentSlide();
        }
    }

    protected function checkAttendanceStatus()
    {
        if (!$this->selectedPresensi) {
            return;
        }

        // Cek status masuk
        if ($this->selectedPresensi->jam_masuk) {
            $jamMasuk = Carbon::parse($this->selectedPresensi->jam_masuk);
            $aturanJamMasuk = Carbon::today()->setTimeFromTimeString($this->selectedPresensi->aturan_jam_masuk);

            $selisihMenit = $aturanJamMasuk->diffInMinutes($jamMasuk, false);


            if ($selisihMenit <= 0) {
                $this->statusMasuk = ['label' => 'Tepat Waktu', 'color' => 'green'];
            } elseif ($selisihMenit > 0 && $selisihMenit <= 30) {
                $this->statusMasuk = ['label' => 'Telat Masuk 1', 'color' => 'yellow'];
            } elseif ($selisihMenit > 30 && $selisihMenit <= 60) {
                $this->statusMasuk = ['label' => 'Telat Masuk 2', 'color' => 'orange'];
            } elseif ($selisihMenit > 60) {
                $this->statusMasuk = ['label' => 'Telat Masuk 3', 'color' => 'red'];
            }
        }

        // Cek status keluar
        if ($this->selectedPresensi->jam_keluar) {
            $jamKeluar = Carbon::parse($this->selectedPresensi->jam_keluar);
            $aturanJamKeluar = Carbon::today()->setTimeFromTimeString($this->selectedPresensi->aturan_jam_keluar);

            $selisihMenit = $aturanJamKeluar->diffInMinutes($jamKeluar, false);


            if ($selisihMenit >= 0) {
                $this->statusKeluar = ['label' => 'Tepat Waktu', 'color' => 'green'];
            } elseif ($selisihMenit < 0 && $selisihMenit >= -30) {
                $this->statusKeluar = ['label' => 'Cepat Pulang 1', 'color' => 'yellow'];
            } elseif ($selisihMenit < -30 && $selisihMenit >= -60) {
                $this->statusKeluar = ['label' => 'Cepat Pulang 2', 'color' => 'orange'];
            } elseif ($selisihMenit < -60) {
                $this->statusKeluar = ['label' => 'Cepat Pulang 3', 'color' => 'red'];
            }
        }
    }

    protected function calculateCurrentSlide()
    {
        $currentMonth = Carbon::now()->month; // Ambil bulan saat ini (1-12)
        $currentYear = Carbon::now()->year; // Ambil tahun saat ini

        // Kelompokkan data presensi berdasarkan bulan dan tahun
        $groupedPresensi = $this->presensiData->groupBy(function ($item) {
            return Carbon::parse($item->tanggal)->format('F Y');
        });

        // Hitung index slide berdasarkan bulan saat ini
        $this->currentSlide = 0;
        foreach ($groupedPresensi as $month => $presensiGroup) {
            $monthYear = Carbon::parse($presensiGroup->first()->tanggal);
            if ($monthYear->month == $currentMonth && $monthYear->year == $currentYear) {
                break;
            }
            $this->currentSlide++;
        }

        // Jika tidak ada data untuk bulan saat ini, arahkan ke slide terakhir
        if ($this->currentSlide >= count($groupedPresensi)) {
            $this->currentSlide = count($groupedPresensi) - 1;
        }
    }

    public function selectPresensi($tanggal)
    {
        $today = Carbon::today()->toDateString();
        $tanggalCarbon = Carbon::parse($tanggal);

        // Jika hari Sabtu atau Minggu, set selectedPresensi ke null
        if ($tanggalCarbon->isWeekend()) {
            $this->selectedPresensi = null;
            $this->selectedDate = $tanggal;
            $this->hariKe = null;
            return;
        }

        $this->selectedDate = $tanggal;
        $this->selectedPresensi = $this->presensiData->where('tanggal', $tanggal)->first();

        // Hitung hari kerja
        $this->calculateHariKe($tanggalCarbon);
        $this->checkAttendanceStatus();

        // Jika tanggal yang dipilih adalah hari ini, refresh halaman
        if ($tanggal == Carbon::today()->toDateString()) {
            return redirect()->to(request()->header('Referer'));
        }

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

            $this->checkAttendanceStatus();
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

    public function render()
    {
        return view('livewire.show-all-presensi', [
            'presensiData' => $this->presensiData,
            'selectedPresensi' => $this->selectedPresensi,
            'selectedDate' => $this->selectedDate,
            'currentSlide' => $this->currentSlide, 
            'hariKe' => $this->hariKe,
            'statusMasuk' => $this->statusMasuk, 
            'statusKeluar' => $this->statusKeluar, 
        ]);
    }
}