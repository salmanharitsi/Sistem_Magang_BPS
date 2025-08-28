<?php

namespace App\Livewire;

use App\Mail\NotifSuratPengantar;
use Livewire\Component;
use App\Models\Pengajuan;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UploadSuratPengantar extends Component
{
    use WithFileUploads;

    #[Validate]
    public $surat_pengantar;

    public function rules()
    {
        return [
            'surat_pengantar' => 'required|url'
        ];
    }

    public function messages()
    {
        return [
            'surat_pengantar' => [
                "required" => 'Surat pengantar tidak boleh kosong',
                "url" => 'Surat pengantar harus berupa URL'
            ]
        ];
    }

    public function upload_surat_pengantar()
    {
        $this->validate();

        $user = Auth::user();
        $pengajuan = Pengajuan::where('user_id', $user->id)
            ->where('status_pengajuan', 'accept-first')
            ->first();
        $pengajuan->surat_pengantar = $this->surat_pengantar;
        $pengajuan->tenggat = null;
        $pengajuan->save();

        Mail::to('amrizal@bps.go.id')->queue(
            new NotifSuratPengantar($pengajuan, $user)
        );

        return redirect(to: '/dashboard')->with([
            'success' => [
                "title" => "Surat pengantar berhasil diupload"
            ]
        ]);


    }

    public function render()
    {
        return view('livewire.upload-surat-pengantar');
    }
}
