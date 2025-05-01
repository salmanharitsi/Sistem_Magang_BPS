<?php

namespace App\Livewire;

use App\Jobs\KirimNotifikasiEmailJob;
use App\Jobs\UpdatePengajuanOverLimit;
use App\Mail\NotifPengajuanAdmin;
use App\Mail\NotifPengajuanPeserta;
use App\Mail\UserNormalMail;
use App\Models\FungsiBagian;
use App\Models\Pengajuan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Carbon\Carbon;

class PengajuanMagang extends Component
{
    #[Validate]
    public $jenis_magang,
        $bidang_tujuan,
        $tanggal_mulai,
        $tanggal_selesai,
        $penanggung_jawab_name,
        $penanggung_jawab_jabatan,
        $penanggung_jawab_email,
        $penanggung_jawab_nomor_hp;

    public $listFungsiBagian = [];

    public function mount()
    {
        $this->jenis_magang = '';
        $this->bidang_tujuan = '';
        $this->listFungsiBagian = FungsiBagian::where('title', '!=', 'Pimpinan')->orderBy('title')->get();
    }

    public function rules()
    {
        return [
            'jenis_magang' => 'required',
            'bidang_tujuan' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required|after:tanggal_mulai',
            'penanggung_jawab_name' => 'required',
            'penanggung_jawab_jabatan' => 'required',
            'penanggung_jawab_email' => 'required|email',
            'penanggung_jawab_nomor_hp' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'jenis_magang' => [
                "required" => 'Jenis magang tidak boleh kosong',
            ],
            'bidang_tujuan' => [
                "required" => 'Bidang tujuan tidak boleh kosong',
            ],
            'tanggal_mulai' => [
                "required" => 'Tanggal mulai magang tidak boleh kosong',
            ],
            'tanggal_selesai' => [
                "required" => 'Tanggal selesai magang tidak boleh kosong',
                "after" => 'Tanggal selesai magang harus setelah tanggal mulai'
            ],
            'penanggung_jawab_name' => [
                "required" => 'Nama penanggung jawab tidak boleh kosong',
            ],
            'penanggung_jawab_jabatan' => [
                "required" => 'Jabatan penanggung jawab tidak boleh kosong',
            ],
            'penanggung_jawab_email' => [
                "required" => 'Email penanggung jawab tidak boleh kosong',
                "email" => 'Email penanggung jawab tidak valid',
            ],
            'penanggung_jawab_nomor_hp' => [
                "required" => 'Nomor HP penanggung jawab tidak boleh kosong',
            ]
        ];
    }

    public function updatedTanggalMulai($value)
    {
        if ($value) {
            $tanggal = Carbon::parse($value);
            if ($tanggal->isWeekend()) {
                $this->addError('tanggal_mulai', 'Tanggal mulai tidak boleh di akhir pekan (Sabtu/Minggu).');
            } else {
                $this->resetErrorBag('tanggal_mulai');
            }
        }
    }

    public function updatedTanggalSelesai($value)
    {
        if ($value) {
            $tanggal = Carbon::parse($value);
            if ($tanggal->isWeekend()) {
                $this->addError('tanggal_selesai', 'Tanggal selesai tidak boleh di akhir pekan (Sabtu/Minggu).');
            } else {
                $this->resetErrorBag('tanggal_selesai');
            }
        }
    }

    public function create_pengajuan()
    {
        try {
            $validatedData = $this->validate();

            // Validasi tanggal mulai
            $tanggalMulai = Carbon::parse($validatedData['tanggal_mulai']);
            if ($tanggalMulai->isWeekend()) {
                return $this->addError('tanggal_mulai', 'Tanggal mulai tidak boleh di akhir pekan (Sabtu/Minggu).');
            }

            // Validasi tanggal selesai
            $tanggalSelesai = Carbon::parse($validatedData['tanggal_selesai']);
            if ($tanggalSelesai->isWeekend()) {
                return $this->addError('tanggal_selesai', 'Tanggal selesai tidak boleh di akhir pekan (Sabtu/Minggu).');
            }

            $user = Auth::user();

            $pengajuan = new Pengajuan();
            $pengajuan->user_id = $user->id;
            $pengajuan->jenis_magang = $validatedData['jenis_magang'];
            $pengajuan->bidang_tujuan = $validatedData['bidang_tujuan'];
            $pengajuan->tanggal_mulai = $validatedData['tanggal_mulai'];
            $pengajuan->tanggal_selesai = $validatedData['tanggal_selesai'];

            $pengajuan->penanggung_jawab_name = $validatedData['penanggung_jawab_name'];
            $pengajuan->penanggung_jawab_jabatan = $validatedData['penanggung_jawab_jabatan'];
            $pengajuan->penanggung_jawab_email = $validatedData['penanggung_jawab_email'];
            $pengajuan->penanggung_jawab_nomor_hp = $validatedData['penanggung_jawab_nomor_hp'];

            // Data akademik
            $pengajuan->institusi = $user->institusi;
            $pengajuan->jurusan = $user->jurusan;
            $pengajuan->nomor_induk = $user->nomor_induk;

            // Data pribadi
            $pengajuan->foto_profil = $user->foto_profil;
            $pengajuan->name = $user->name;
            $pengajuan->email = $user->email;
            $pengajuan->nomor_hp = $user->nomor_hp;
            $pengajuan->tentang_saya = $user->tentang_saya;
            $pengajuan->jenis_kelamin = $user->jenis_kelamin;
            $pengajuan->tempat_lahir = $user->tempat_lahir;
            $pengajuan->tanggal_lahir = $user->tanggal_lahir;
            $pengajuan->alamat = $user->alamat;

            $pengajuan->kartu_penduduk = $user->kartu_penduduk;
            $pengajuan->original_filename_ktp = $user->original_filename_ktp;
            $pengajuan->kartu_tanda = $user->kartu_tanda;
            $pengajuan->original_filename_kartu = $user->original_filename_kartu;

            $pengajuan->save();

            $user->status_magang = 'masa-daftar';
            $user->save();

            \Log::info('Mengirim email ke peserta: ' . $user->email);
            Mail::to($user->email)->send(new NotifPengajuanPeserta($pengajuan, $user));

            \Log::info('Email berhasil dikirim ke: ' . $user->email);
            \Log::info('Mengirim email ke admin');
            Mail::to('luxurialev@gmail.com')->send(new NotifPengajuanAdmin($pengajuan, $user));

            UpdatePengajuanOverLimit::dispatch($pengajuan)->delay(now()->addDay());

            return redirect('/dashboard')->with([
                'success' => [
                    "title" => "Berhasil mengajukan magang"
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim email: ' . $e->getMessage());
            \Log::error('Error dalam pengajuan: ' . $e->getMessage());
            return redirect('/dashboard')->with([
                'error' => [
                    "title" => "Terjadi kesalahan"
                ]
            ]);
        }
    }

    public function render()
    {
        return view('livewire.pengajuan-magang');
    }
}
