<?php

namespace App\Livewire;

use App\Models\Presensi;
use Livewire\Component;

class KelolaJamKerja extends Component
{
    public $tanggal_mulai;
    public $tanggal_selesai;
    public $jenis_bulan;
    public $presensi_count = null;

    protected $rules = [
        'tanggal_mulai' => 'required|date',
        'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        'jenis_bulan' => 'required|in:biasa,ramadhan',
    ];

    protected $messages = [
        'tanggal_mulai.required' => 'Tanggal mulai tidak boleh kosong',
        'tanggal_mulai.date' => 'Format tanggal mulai tidak valid',
        'tanggal_selesai.required' => 'Tanggal selesai tidak boleh kosong',
        'tanggal_selesai.date' => 'Format tanggal selesai tidak valid',
        'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus sama atau setelah tanggal mulai',
        'jenis_bulan.required' => 'Jenis bulan harus dipilih',
        'jenis_bulan.in' => 'Jenis bulan tidak valid',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
        
        // Check if both dates are filled
        if ($this->tanggal_mulai && $this->tanggal_selesai) {
            $this->checkPresensi();
        }
    }

    protected function checkPresensi()
    {
        $this->presensi_count = Presensi::whereBetween('tanggal', [
            $this->tanggal_mulai,
            $this->tanggal_selesai
        ])->count();
    }

    public function updateJamKerja()
    {
        $this->validate();

        // Determine working hours based on jenis_bulan
        $jam_masuk = $this->jenis_bulan === 'ramadhan' ? '08:00:00' : '07:00:00';
        $jam_pulang = $this->jenis_bulan === 'ramadhan' ? '15:00:00' : '16:00:00';

        // Update presensi records
        $updated = Presensi::whereBetween('tanggal', [
            $this->tanggal_mulai,
            $this->tanggal_selesai
        ])->update([
            'aturan_jam_masuk' => $jam_masuk,
            'aturan_jam_keluar' => $jam_pulang
        ]);

        // Reset the count before redirect
        $this->presensi_count = null;

        if ($updated) {
            return redirect('/jam-kerja')->with([
                'success' => [
                    "title" => "$updated data presensi berhasil diperbarui",
                    "message" => "Jam kerja telah diupdate untuk periode yang dipilih."
                ]
            ]);
        }

        return redirect('/jam-kerja')->with([
            'warning' => [
                "title" => "Tidak ada data yang diupdate",
                "message" => "Tidak ditemukan data presensi pada rentang tanggal tersebut."
            ]
        ]);
    }

    public function render()
    {
        return view('livewire.kelola-jam-kerja');
    }
}