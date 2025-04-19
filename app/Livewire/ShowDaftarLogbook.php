<?php

namespace App\Livewire;

use App\Models\Logbook;
use App\Models\Magang;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ShowDaftarLogbook extends Component
{
    use WithPagination;

    public $search;
    public $showModal = false;
    public $selectedData = [];


    public function updating($key): void
    {
        if ($key === 'search') {
            $this->resetPage();
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedData = [];
    }

    public function showDetail($id)
    {
        $logbook = Logbook::with('magang.user')->find($id);

        if ($logbook) {
            $this->originalStatus = $logbook->status;
            $this->selectedData = [
                'id' => $logbook->id,
                'nama' => $logbook->magang->user->name,
                'jenis_magang' => $logbook->magang->jenis_magang,
                'tanggal' => $logbook->tanggal,
                'deskripsi' => $logbook->deskripsi,
                'lampiran' => $logbook->lampiran,
                'status' => $logbook->status,
                'komentar' => $logbook->komentar,
                'updated_at' => $logbook->updated_at,
                'pembimbing_id' => $logbook->pembimbing_id
            ];
            $this->showModal = true;
        }
    }

    public function render()
    {

        $user = Auth::user();

        // Get the user's latest active magang
        $magang = Magang::where('user_id', $user->id)
                        ->where('status_magang', 'active')
                        ->latest()
                        ->first();

        $query = Logbook::query();

        if ($magang) {
            $query->where('magang_id', $magang->id)
                  ->where('status', '!=', 'waiting')
                  ->orderBy('tanggal', 'desc');
        } else {
            // If no active magang found, return empty results
            $query->whereNull('magang_id');
        }

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

        $logbook = $query->latest()->paginate(5);

        return view('livewire.show-daftar-logbook', [
            'logbook' => $logbook,
            'magang'=> $magang
        ]);
    }
}
