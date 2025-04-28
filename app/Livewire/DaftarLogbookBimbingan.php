<?php

namespace App\Livewire;

use App\Models\Logbook;
use App\Models\Magang;
use Livewire\Component;
use Livewire\WithPagination;

class DaftarLogbookBimbingan extends Component
{
    use WithPagination; 
    
    public $magang; 
    public $search;
    public $statusFilter = '';

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

    public function render()
    {
        $query = Logbook::where('magang_id', $this->magang)
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

        $logbook = $query->paginate(3);

        return view('livewire.daftar-logbook-bimbingan', [
            'logbook' => $logbook
        ]);
    }
}
