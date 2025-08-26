<?php

namespace App\Livewire;

use App\Mail\OTPMail;
use App\Models\OTP;
use App\Models\User;
use App\Models\Institusi;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class Registrasi extends Component
{
    use WithFileUploads;

    #[Validate]
    public $name,
        $email,
        $nomor_induk,
        $institusi_id,
        $jurusan,
        $nomor_hp,
        $kartu_tanda,
        $password,
        $confirm_password;

    public function rules()
    {
        return [
            'name' => 'required|min:5',
            'email' => 'required|email|unique:users',
            'nomor_induk' => 'required|min:5|unique:users',
            'institusi_id' => 'required|exists:institusi,id',
            'jurusan' => 'required',
            'kartu_tanda' => 'required|max:2048',
            'nomor_hp' => 'required',
            'password' => 'required|min:8|regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/',
            'confirm_password' => 'required_with:password|same:password',
        ];
    }

    public function updated($propertyName)
    {
        // Real-time validation
        if (in_array($propertyName, ['name', 'email', 'nomor_induk', 'password', 'confirm_password'])) {
            $this->validateOnly($propertyName);
        }
    }

    public function create_user()
    {
        $validatedData = $this->validate();

        // Store uploaded file
        $imagePath = $this->kartu_tanda->store('kartu_tanda', 'public');
        $originalFilename = $this->kartu_tanda->getClientOriginalName();

        // Generate OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Create OTP record
        $otpRecord = OTP::create([
            'email' => $validatedData['email'],
            'otp_code' => $otp,
            'verified' => false,
            'registration_data' => [
                'name' => ucwords(strtolower(trim($validatedData['name']))),
                'nomor_induk' => $validatedData['nomor_induk'],
                'institusi_id' => $validatedData['institusi_id'],
                'jurusan' => ucwords(strtolower(trim($validatedData['jurusan']))),
                'kartu_tanda' => $imagePath,
                'original_filename_kartu' => $originalFilename,
                'nomor_hp' => $validatedData['nomor_hp'],
                'password' => Hash::make($validatedData['password']),
            ]
        ]);

        // Send OTP email
        Mail::to($validatedData['email'])->send(new OTPMail($otpRecord->id, $otp));

        return redirect()->route('verify.otp', ['id' => $otpRecord->id])->with([
            'success' => [
                "title" => "Registrasi Berhasil!"
            ]
        ]);
    }

    public function messages()
    {
        return [
            'name' => [
                "required" => 'Nama tidak boleh kosong',
                "min" => 'Nama minimal 5 karakter',
            ],
            'email' => [
                "required" => 'Email tidak boleh kosong',
                "email" => 'Gunakan email yang valid',
                "unique" => 'Email ini sudah terdaftar',
            ],
            'nomor_induk' => [
                "required" => 'Nomor induk tidak boleh kosong',
                "min" => 'Nomor induk minimal 5 karakter',
                "unique" => 'Nomor induk ini sudah terdaftar',
            ],
            'institusi_id' => [
                "required" => 'Institusi tidak boleh kosong',
                "exists" => 'Institusi tidak valid',
            ],
            'jurusan' => [
                "required" => 'Jurusan tidak boleh kosong',
            ],
            'kartu_tanda' => [
                "required" => 'Kartu tanda siswa/mahasiswa tidak boleh kosong',
                "max" => 'File tidak boleh lebih dari 2mb'
            ],
            'nomor_hp' => [
                "required" => 'Nomor HP tidak boleh kosong',
            ],
            'password' => [
                "required" => 'Password tidak boleh kosong',
                "min" => 'Password minimal 8 karakter',
                "regex" => 'Password harus mengandung huruf dan angka'
            ],
            'confirm_password' => [
                "required_with" => 'Konfirmasi password tidak boleh kosong jika password diisi',
                "same" => 'Password tidak sesuai'
            ]
        ];
    }


    public function render()
    {
        return view('livewire.registrasi', [
            'institusiList' => Institusi::where('status', 'approved')->orderBy('nama')->get()
        ]);
    }
}