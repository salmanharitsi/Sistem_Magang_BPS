<?php

namespace App\Livewire;

use App\Models\Magang;
use Livewire\Attributes\Validate;
use Livewire\Component;

class UploadLaporanAkhir extends Component
{
    #[Validate]
    public $magang_id, 
    $laporan_magang, 
    $projek_magang;

    public function mount($magangId)
    {
        $this->magang_id = $magangId;
    }

    public function rules()
    {
        return [
            'laporan_magang' => 'required|url',
            'projek_magang' => 'nullable|url',
        ];
    }

    public function messages()
    {
        return [
            'laporan_magang' => [
                "required" => 'Laporan magang tidak boleh kosong',
                "url" => 'Laporan magang harus berupa URL'
            ],
            'projek_magang' => [
                "url" => 'Projek magang harus berupa URL'
            ]
        ];
    }

    public function upload_laporan_akhir()
    {
        // Validasi input
        $this->validate();

        try {
            $magang = Magang::findOrFail($this->magang_id);

            // Update data
            $magang->update([
                'laporan_magang' => $this->laporan_magang,
                'projek_magang' => $this->projek_magang ?? null,
            ]);

            return redirect('/dashboard')->with([
                'success' => [
                    "title" => "Dokumen berhasil disubmit!",
                ]
            ]);
        } catch (\Exception $e) {
            return redirect('/dashboard')->with([
                'error' => [
                    "title" => "Terjadi kesalahan saat mengupload dokumen!",
                ]
            ]);
        }
    }

    public function render()
    {
        return view('livewire.upload-laporan-akhir');
    }
}
