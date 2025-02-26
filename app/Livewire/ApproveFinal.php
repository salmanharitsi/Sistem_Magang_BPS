<?php

namespace App\Livewire;

use App\Models\Magang;
use App\Models\Pengajuan;
use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Component;
use App\Models\Pegawai;

class ApproveFinal extends Component
{
    #[Validate]
    public $pengajuan;
    public $pembimbingList;
    public $pembimbing1 = null;
    public $pembimbing2 = null;
    public $showTerimaModal = false;
    public $showTolakModal = false;

    public function mount($pengajuan)
    {
        $this->pengajuan = $pengajuan;
        $this->pembimbingList = Pegawai::where('fungsi_bagian', $pengajuan->bidang_tujuan)
            ->get();
    }

    public function rules()
    {
        return [
            'pembimbing1' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'pembimbing1' => ['required' => 'Pembimbing 1 tidak boleh kosong'],
        ];
    }

    // Method untuk mendapatkan daftar pembimbing yang tersedia untuk pembimbing 2
    public function getPembimbing2Options()
    {
        return $this->pembimbingList->filter(function ($pembimbing) {
            return $pembimbing->id != $this->pembimbing1;
        });
    }

    // Tambahkan method untuk menangani persetujuan
    public function terimaPengajuan()
    {
        // $this->showTerimaModal = false;
        $validateData = $this->validate();

        $pengajuan = Pengajuan::find($this->pengajuan->id);
        $user = User::query()->where('id', $this->pengajuan->user_id)->first();

        $magang = new Magang();
        $magang->status_magang = 'active';
        $magang->user_id = $user->id;
        $magang->jenis_magang = $pengajuan->jenis_magang;
        $magang->tanggal_mulai = $pengajuan->tanggal_mulai;
        $magang->tanggal_selesai = $pengajuan->tanggal_selesai;
        $magang->bidang_tujuan = $pengajuan->bidang_tujuan;
        $magang->pembimbing_pertama = $this->pembimbing1;
        $magang->pembimbing_kedua = $this->pembimbing2 ?: null;
        $magang->save();

        $pengajuan->status_pengajuan = 'accept-final';
        $pengajuan->tenggat = null;
        $pengajuan->save();

        $user->status_magang = 'aktif';
        $user->save();

        $this->reset(['showTerimaModal', 'pembimbing1', 'pembimbing2']);

        return redirect(url('/daftar-pengajuan'))->with([
            'success' => [
                'title' => 'Berhasil menerima pengajuan!'
            ]
        ]);
    }

    // Tambahkan method untuk menangani penolakan
    public function tolakPengajuan()
    {
        $pengajuan = Pengajuan::find($this->pengajuan->id);
        $pengajuan->status_pengajuan = "reject-final";
        $pengajuan->komentar = "Terdapat kesalahan pada surat pengantar, silahkan ajukan kembali";
        $pengajuan->save();

        return redirect(url('/daftar-pengajuan'))->with([
            'success' => [
                "title" => "Berhasil menolak pengajuan"
            ]
        ]);
    }

    public function setShowTerimaModal($value)
    {
        $this->showTerimaModal = $value;
        if ($value) {
            $this->showTolakModal = false;
        }
    }

    public function setShowTolakModal($value)
    {
        $this->showTolakModal = $value;
        if ($value) {
            $this->showTerimaModal = false;
        }
    }

    public function render()
    {
        return view('livewire.approve-final', [
            'pembimbing2Options' => $this->getPembimbing2Options()
        ]);
    }
}