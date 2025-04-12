<?php

namespace App\Livewire;

use Livewire\Attributes\Validate;
use Livewire\Component;

class LaporIzin extends Component
{
    #[Validate]
    public $lampiran;
    public $keterangan_izin;
    public $presensi;

    public function rules()
    {
        return [
            'lampiran' => 'nullable|url',
            'keterangan_izin' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'lampiran' => [
                "url" => 'Lampiran harus berupa URL'
            ],
            'keterangan_izin' => [
                "required" => 'Keterangan izin harus diisi'
            ]
        ];
    }

    public function mount($presensi)
    {
        $this->presensi = $presensi;
    }

    public function submit_izin()
    {
        // Validasi input
        $this->validate();

        // Update data presensi menjadi izin
        $this->presensi->update([
            'status' => 'izin',
            'point' => 75,
            'keterangan_izin' => $this->keterangan_izin,
            'lampiran' => $this->lampiran,
        ]);

        // Redirect ke halaman daftar presensi (opsional)
        return redirect('/presensi')->with([
            'success' => [
                "title" => "Izin berhasil dikirim",
            ],
        ]);
    }

    public function render()
    {
        return view('livewire.lapor-izin', [
            'presensi' => $this->presensi
        ]);
    }
}
