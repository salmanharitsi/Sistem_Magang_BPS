<?php

namespace App\Livewire;

use Livewire\Attributes\Validate;
use Livewire\Component;
use App\Models\Presensi;
use App\Models\Logbook;

class InputNilai extends Component
{

    #[Validate]
    public $magang;
    public $nilaiPresensi;
    public $jumlahPresensi;
    public $totalPointPresensi;
    
    public $nilaiLogbook;
    public $jumlahLogbook;
    public $logbookTerisi;

    public $showSubmitModal = false;
    public $showFinalizationModal = false;
    
    public $nilaiCustoms = [
        ['indikator' => '', 'deskripsi' => '', 'nilai' => null]
    ];
    public $totalNilai;

    public function rules()
    {
        return [
            'nilaiPresensi' => 'required|numeric|min:0|max:100',
            'nilaiLogbook' => 'required|numeric|min:0|max:100',
            'nilaiCustoms.*.indikator' => 'required|string|min:3',
            'nilaiCustoms.*.deskripsi' => 'required|string',
            'nilaiCustoms.*.nilai' => 'required|numeric|min:0|max:100',
        ];
    }

    public function messages()
    {
        return [
            'nilaiPresensi.required' => 'Nilai presensi tidak boleh kosong',
            'nilaiPresensi.numeric' => 'Nilai presensi harus berupa angka',
            'nilaiPresensi.min' => 'Nilai presensi minimal adalah 0',
            'nilaiPresensi.max' => 'Nilai presensi maksimal adalah 100',
            
            'nilaiLogbook.required' => 'Nilai logbook tidak boleh kosong',
            'nilaiLogbook.numeric' => 'Nilai logbook harus berupa angka',
            'nilaiLogbook.min' => 'Nilai logbook minimal adalah 0',
            'nilaiLogbook.max' => 'Nilai logbook maksimal adalah 100',

            'nilaiCustoms.*.indikator.required' => 'Indikator tidak boleh kosong',
            'nilaiCustoms.*.indikator.string' => 'Indikator harus berupa teks',
            'nilaiCustoms.*.indikator.min' => 'Indikator minimal 3 karakter',

            'nilaiCustoms.*.deskripsi.required' => 'Deskripsi tidak boleh kosong',
            'nilaiCustoms.*.deskripsi.string' => 'Deskripsi harus berupa teks',

            'nilaiCustoms.*.nilai.required' => 'Nilai tidak boleh kosong',
            'nilaiCustoms.*.nilai.numeric' => 'Nilai harus berupa angka',
            'nilaiCustoms.*.nilai.min' => 'Nilai minimal adalah 0',
            'nilaiCustoms.*.nilai.max' => 'Nilai maksimal adalah 100',
        ];
    }

    public function mount($magang)
    {
        $this->magang = $magang;
        
        // Selalu hitung nilai kalkulasi terlebih dahulu
        $this->hitungNilaiPresensi();
        $this->hitungNilaiLogbook();
        
        // Cek apakah sudah ada data nilai yang tersimpan dan load jika ada
        if ($this->magang->nilai_presensi !== null && 
            $this->magang->nilai_logbook !== null && 
            $this->magang->nilai_lainnya !== null) {
            // Load data yang tersimpan, tapi tetap pertahankan nilai kalkulasi jika user belum mengubahnya
            $this->loadSavedData();
        } else {
            // Jika belum ada data tersimpan, gunakan nilai dari kalkulasi
            // Nilai presensi dan logbook sudah di-set dari fungsi hitung di atas
            
            // Set nilai custom default atau load jika ada
            if ($this->magang->nilai_lainnya) {
                $this->nilaiCustoms = json_decode($this->magang->nilai_lainnya, true);
            } else {
                $this->nilaiCustoms = [['indikator' => '', 'deskripsi' => '', 'nilai' => null]];
            }
        }
        
        $this->hitungTotalNilai();
    }

    // Load data yang tersimpan
    public function loadSavedData()
    {
        $this->nilaiPresensi = (int) $this->magang->nilai_presensi;
        $this->nilaiLogbook = (int) $this->magang->nilai_logbook;
        
        if ($this->magang->nilai_lainnya) {
            $this->nilaiCustoms = json_decode($this->magang->nilai_lainnya, true);
        } else {
            $this->nilaiCustoms = [['indikator' => '', 'deskripsi' => '', 'nilai' => null]];
        }
    }

    // Fungsi hitung nilai presensi (untuk kalkulasi awal)
    public function hitungNilaiPresensi()
    {
        $presensi = Presensi::where('magang_id', $this->magang->id)
            ->where('status', '!=', 'waiting')
            ->get();

        $this->jumlahPresensi = $presensi->count();
        $this->totalPointPresensi = $presensi->sum('point');
        
        if ($this->jumlahPresensi > 0) {
            $this->nilaiPresensi = (int) round($this->totalPointPresensi / $this->jumlahPresensi);
        } else {
            $this->nilaiPresensi = 0;
        }
        
        // Pastikan nilai dalam range 0-100
        $this->nilaiPresensi = min(max($this->nilaiPresensi, 0), 100);
    }

    // Fungsi hitung nilai logbook (untuk kalkulasi awal)
    public function hitungNilaiLogbook()
    {
        $logbooks = Logbook::where('magang_id', $this->magang->id)
            ->where('status', '!=', 'waiting')
            ->get();

        $this->jumlahLogbook = $logbooks->count();
        
        if ($this->jumlahLogbook > 0) {
            $this->logbookTerisi = $logbooks
                ->where('status', 'mengisi')
                ->where('status_review', 'diterima')
                ->count();
            $persentase = ($this->logbookTerisi / $this->jumlahLogbook) * 100;
            $this->nilaiLogbook = (int) round($persentase);
        } else {
            $this->logbookTerisi = 0;
            $this->nilaiLogbook = 0;
        }
        
        // Pastikan nilai dalam range 0-100
        $this->nilaiLogbook = min(max($this->nilaiLogbook, 0), 100);
    }

    // Fungsi hitung total nilai (diupdate)
    public function hitungTotalNilai()
    {
        // Pastikan nilai presensi dan logbook adalah integer
        $nilaiPresensiInt = is_numeric($this->nilaiPresensi) ? (int) $this->nilaiPresensi : 0;
        $nilaiLogbookInt = is_numeric($this->nilaiLogbook) ? (int) $this->nilaiLogbook : 0;
        
        // Hitung komponen nilai
        $nilaiPresensi = $nilaiPresensiInt * 0.7; // 70%
        $nilaiLogbook = $nilaiLogbookInt * 0.2;  // 20%
        
        // Hitung nilai custom (10%)
        $nilaiCustom = 0;
        if (!empty($this->nilaiCustoms)) {
            $jumlahIndikator = count($this->nilaiCustoms);
            $totalNilaiCustom = collect($this->nilaiCustoms)->sum(function ($item) {
                return is_numeric($item['nilai']) ? (int) $item['nilai'] : 0;
            });            
            $nilaiCustom = ($jumlahIndikator > 0) ? ($totalNilaiCustom / $jumlahIndikator) * 0.1 : 0;
        }
        
        $this->totalNilai = round($nilaiPresensi + $nilaiLogbook + $nilaiCustom);
    }

    // Tambah indikator custom
    public function addIndicator()
    {
        if (count($this->nilaiCustoms) < 5) {
            $this->nilaiCustoms[] = ['indikator' => '', 'deskripsi' => '', 'nilai' => null];
        }
    }

    // Hapus indikator custom
    public function removeIndicator($index)
    {
        if (count($this->nilaiCustoms) > 1) {
            unset($this->nilaiCustoms[$index]);
            $this->nilaiCustoms = array_values($this->nilaiCustoms);
            $this->hitungTotalNilai();
        }
    }

    public function updatedNilaiPresensi($value)
    {
        if ($value === '' || $value === null) {
            $this->nilaiPresensi = 0;
        } else {
            $this->nilaiPresensi = is_numeric($value) ? min(max((int) $value, 0), 100) : 0;
        }
        $this->hitungTotalNilai();
    }

    public function updatedNilaiLogbook($value)
    {
        if ($value === '' || $value === null) {
            $this->nilaiLogbook = 0;
        } else {
            $this->nilaiLogbook = is_numeric($value) ? min(max((int) $value, 0), 100) : 0;
        }
        $this->hitungTotalNilai();
    }

    public function updatedNilaiCustoms($value, $key)
    {
        // Ambil index dan field dari key, misalnya "0.nilai"
        [$index, $field] = explode('.', $key);

        if ($field === 'nilai') {
            // Jika nilainya bukan angka atau kosong, tetap null untuk validasi required
            if ($value === '' || $value === null) {
                $this->nilaiCustoms[$index]['nilai'] = null;
            } else {
                // Jika nilainya numerik, konversi dan batasi maksimal 100
                $nilai = is_numeric($value) ? (int) $value : null;
                $this->nilaiCustoms[$index]['nilai'] = $nilai !== null ? min($nilai, 100) : null;
            }

            // Hitung ulang total nilai setelah konversi
            $this->hitungTotalNilai();
        }
    }

    // Validasi sebelum menampilkan modal konfirmasi
    public function confirmSubmit()
    {
        // Validasi terlebih dahulu sebelum menampilkan modal
        $this->validate();
        
        // Jika validasi berhasil, tampilkan modal konfirmasi
        $this->showSubmitModal = true;
    }

    // Konfirmasi finalisasi
    public function confirmFinalization()
    {
        $this->showFinalizationModal = true;
    }

    public function submitNilai()
    {
        // Validasi lagi untuk memastikan data valid saat submit
        $this->validate();

        // Format indikator dan deskripsi sebelum disimpan
        $formattedCustoms = array_map(function($item) {
            return [
                'indikator' => ucwords($item['indikator']),
                'deskripsi' => ucfirst($item['deskripsi']),
                'nilai' => $item['nilai']
            ];
        }, $this->nilaiCustoms);

        // Update data pada model magang
        $this->magang->update([
            'nilai_presensi' => $this->nilaiPresensi,
            'nilai_logbook' => $this->nilaiLogbook,
            'nilai_lainnya' => json_encode($formattedCustoms),
            'nilai_magang' => $this->totalNilai,
        ]);

        // Tutup modal
        $this->showSubmitModal = false;

        return redirect('/daftar-bimbingan/' . $this->magang->id)->with([
            'success' => [
                "title" => "Nilai berhasil disimpan",
            ]
        ]);
    }

    // Finalisasi nilai
    public function finalizeNilai()
    {
        // Update status final menjadi 'final'
        $this->magang->update([
            'status_final' => 'final'
        ]);

        // Tutup modal
        $this->showFinalizationModal = false;

        return redirect('/daftar-bimbingan/' . $this->magang->id)->with([
            'success' => [
                "title" => "Nilai berhasil difinalisasi",
            ]
        ]);
    }

    // Update otomatis saat nilai berubah
    public function updated()
    {
        $this->hitungTotalNilai();
    }

    public function render()
    {
        return view('livewire.input-nilai', [
            'nilaiPresensi' => $this->nilaiPresensi,
            'jumlahPresensi' => $this->jumlahPresensi,
            'totalPointPresensi' => $this->totalPointPresensi,
            'nilaiLogbook' => $this->nilaiLogbook,
            'jumlahLogbook' => $this->jumlahLogbook,
            'logbookTerisi' => $this->logbookTerisi,
            'totalNilai' => $this->totalNilai ?? 0,
            'jumlahIndikatorCustom' => count($this->nilaiCustoms)
        ]);
    }
}