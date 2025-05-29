<?php

namespace App\Livewire;

use App\Models\Logbook;
use App\Models\Magang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class ShowDaftarLogbook extends Component
{
    use WithPagination;

    public $search;
    public $showModal = false;
    public $selectedData = [];
    public $statusFilter = '';
    public $mangId; // Property to store the magang ID from URL

    public function mount()
    {
        // Get magang ID from URL if available
        $currentUrl = Request::url();
        if (Str::contains($currentUrl, 'magang-saya/')) {
            $parts = explode('magang-saya/', $currentUrl);
            if (count($parts) > 1) {
                $this->mangId = $parts[1];
            }
        }
    }

    public function updating($key): void
    {
        if (in_array($key, ['search', 'statusFilter'])) {
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
                'pembimbing_id' => $logbook->pembimbing->name ?? null
            ];
            $this->showModal = true;
        }
    }

    public function render()
    {
        $user = Auth::user();
        $query = Logbook::query();

        // If we're on a specific magang detail page
        if ($this->mangId) {
            // Get the specific magang by ID from URL
            $magang = Magang::where('id', $this->mangId)
                            ->where('user_id', $user->id)
                            ->first();
            
            if ($magang) {
                $query->where('magang_id', $magang->id)
                      ->where('status', '!=', 'waiting')
                      ->orderBy('tanggal', 'desc');
            } else {
                // If no magang found with this ID, return empty results
                $query->whereNull('magang_id');
            }
        } else {
            // We're on the dashboard - show data for latest active magang
            $magang = Magang::where('user_id', $user->id)
                            ->where('status_magang', 'active')
                            ->latest()
                            ->first();
            
            if ($magang) {
                $query->where('magang_id', $magang->id)
                      ->where('status', '!=', 'waiting')
                      ->orderBy('tanggal', 'desc');
            } else {
                // If no active magang found, return empty results
                $query->whereNull('magang_id');
            }
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

        // Apply status filter if selected
        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        $logbook = $query->latest()->paginate(3);

        return view('livewire.show-daftar-logbook', [
            'logbook' => $logbook,
            'magang' => $magang ?? null
        ]);
    }
}