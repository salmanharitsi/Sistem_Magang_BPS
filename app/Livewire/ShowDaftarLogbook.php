<?php

namespace App\Livewire;

use App\Models\Logbook;
use App\Models\Magang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ShowDaftarLogbook extends Component
{
    use WithPagination;

    public $search;
    public $showModal = false;
    public $selectedData = [];
    public $statusFilter = '';
    public $mangId; // Property to store the magang ID from URL
    public $isDownloading = false;

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

    public function downloadLogbookPdf()
    {
        $this->isDownloading = true;
        
        try {
            $user = Auth::user();
            $query = Logbook::query();
            
            // Determine which magang to use
            if ($this->mangId) {
                $magang = Magang::where('id', $this->mangId)
                                ->where('user_id', $user->id)
                                ->first();
            } else {
                $magang = Magang::where('user_id', $user->id)
                                ->where('status_magang', 'active')
                                ->latest()
                                ->first();
            }
            
            if (!$magang) {
                session()->flash('error', 'Data magang tidak ditemukan.');
                $this->isDownloading = false;
                return;
            }
            
            // Get all presensi data for this magang (not just the paginated ones)
            $logbookData = Logbook::where('magang_id', $magang->id)
                                  ->where('status', '!=', 'waiting')
                                  ->orderBy('tanggal', 'desc')
                                  ->get();
            
            // Apply status filter if selected
            if ($this->statusFilter) {
                $logbookData = $logbookData->where('status', $this->statusFilter);
            }
            
            // Get user and magang data
            $userData = [
                'nama' => $user->name,
                'institusi' => $magang->pengajuan->institusi ?? '-',
                'nomor_induk' => $user->nomor_induk ?? '-',
                'jenis_magang' => $magang->jenis_magang,
                'tanggal_mulai' => Carbon::parse($magang->tanggal_mulai)->format('d F Y'),
                'tanggal_selesai' => Carbon::parse($magang->tanggal_selesai)->format('d F Y'),
                'pembimbing' => $magang->pembimbingPertama->name ?? '-',
            ];
            
            // Prepare data for the PDF
            $data = [
                'userData' => $userData,
                'logbook' => $logbookData,
                'tanggal_cetak' => Carbon::now()->locale('id')->translatedFormat('d F Y'),
            ];
            
            // Generate PDF
            $pdf = Pdf::loadView('pdf.logbook-report', $data);
            
            $this->isDownloading = false;
            
            // Return the PDF for download
            return response()->streamDownload(function() use ($pdf) {
                echo $pdf->output();
            }, 'laporan-logbook-' . Str::slug($user->name) . '.pdf');
            
        } catch (\Exception $e) {
            $this->isDownloading = false;
            session()->flash('error', 'Gagal mengunduh laporan: ' . $e->getMessage());
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