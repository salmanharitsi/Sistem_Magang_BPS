<?php

namespace App\Livewire;

use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class LaporIzin extends Component
{
    use WithFileUploads;

    #[Validate]
    public $lampiran;
    public $keterangan_izin;
    public $presensi;

    public function rules()
    {
        return [
            'lampiran' => 'max:2048',
            'keterangan_izin' => 'required'
        ];
    }

    public function hapus_lampiran()
    {
        $this->lampiran = null;
    }

    public function messages()
    {
        return [
            'lampiran' => [
                "max" => 'File tidak boleh lebih dari 2mb'
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

        // Simpan lampiran jika ada
        if ($this->lampiran) {
            $path = $this->lampiran->store('lampiran-izin', 'public');
            $this->presensi->lampiran = $path;
            $originalFilename = $this->lampiran->getClientOriginalName();
        }

        // Update data presensi menjadi izin
        $this->presensi->update([
            'status' => 'izin',
            'point' => 75,
            'keterangan_izin' => $this->keterangan_izin,
            'lampiran' => $this->presensi->lampiran ?? null,
            'original_filename_lampiran' => $originalFilename ?? null
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
