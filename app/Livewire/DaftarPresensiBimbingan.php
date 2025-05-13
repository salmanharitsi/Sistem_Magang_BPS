<?php

namespace App\Livewire;

use App\Models\Magang;
use App\Models\Presensi;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class DaftarPresensiBimbingan extends Component
{
    use WithPagination; 
    
    public $magang; 
    public $search;
    public $statusFilter = '';
    public $showModal = false;
    public $selectedData = [];

    public function updating($key): void
    {
        if (in_array($key, ['search', 'statusFilter'])) {
            $this->resetPage();
        }
    }

    public function mount($magang)
    {
        $this->magang = $magang;
        Magang::findOrFail($this->magang); 
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedData = [];
    }

    public function showDetail($id)
    {
        $presensi = Presensi::with(['magang.user', 'pembimbing'])->find($id);

        if ($presensi) {
            $this->selectedData = [
                'id' => $presensi->id,
                'name' => $presensi->magang->user->name,
                'tanggal' => $presensi->tanggal,
                'jenis_magang' => $presensi->magang->jenis_magang,
                'status' => $presensi->status,
                'jam_masuk' => $presensi->jam_masuk,
                'jam_keluar' => $presensi->jam_keluar,
                'foto_masuk' => $presensi->foto_masuk ? 'storage/' . $presensi->foto_masuk : null, // Path ke foto_masuk
                'foto_keluar' => $presensi->foto_keluar ? 'storage/' . $presensi->foto_keluar : null, // Path ke foto_keluar
                'keterangan_izin' => $presensi->keterangan_izin,
                'updated_at' => $presensi->updated_at,
                'point' => $presensi->point,
                'lampiran' => $presensi->lampiran,
                'pembimbing_id' => $presensi->pembimbing->name ?? null,
                'status_review' => $presensi->status_review
            ];
            $this->showModal = true;
        }
    }

    public function render()
    {
        $query = Presensi::where('magang_id', $this->magang)
            ->where('status', '!=', 'waiting')
            ->orderBy('tanggal', 'desc');

        if ($this->search) {
            $search = strtolower($this->search);

            // Mapping hari dan bulan dalam bahasa Indonesia ke bahasa Inggris
            $indo_days = [
                'minggu' => 'Sunday',
                'senin' => 'Monday',
                'selasa' => 'Tuesday',
                'rabu' => 'Wednesday',
                'kamis' => 'Thursday',
                'jumat' => 'Friday',
                'sabtu' => 'Saturday',
            ];

            $indo_months = [
                'januari' => 'January',
                'februari' => 'February',
                'maret' => 'March',
                'april' => 'April',
                'mei' => 'May',
                'juni' => 'June',
                'juli' => 'July',
                'agustus' => 'August',
                'september' => 'September',
                'oktober' => 'October',
                'november' => 'November',
                'desember' => 'December',
            ];

            $english_day = $indo_days[$search] ?? null;
            $english_month = $indo_months[$search] ?? null;

            $query->where(function ($q) use ($search, $english_day, $english_month) {
                $q->where('status', 'like', '%' . $search . '%')
                  ->orWhereHas('pembimbing', function ($q) use ($search) { $q->where('name', 'like', '%' . $search . '%'); })
                  ->orWhereRaw("DAY(tanggal) LIKE ?", ["%$search%"])
                  ->orWhereRaw("YEAR(tanggal) LIKE ?", ["%$search%"]);

                if ($english_day) {
                    $q->orWhereRaw("DAYNAME(tanggal) = ?", [$english_day]);
                }

                if ($english_month) {
                    $q->orWhereRaw("MONTHNAME(tanggal) = ?", [$english_month]);
                }
            });
        }

        // Apply status filter if selected
        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        $presensi = $query->paginate(3);
        
        return view('livewire.daftar-presensi-bimbingan', [
            'presensi' => $presensi 
        ]);
    }
}