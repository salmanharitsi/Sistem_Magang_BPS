<?php

namespace App\Livewire;

use App\Models\Pegawai;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Validate;
use Livewire\Component;

class UbahPassword extends Component
{
    #[Validate]

    public $password,
    $confirm_password,
    $curPassword;

    public function rules()
    {
        return [
            'curPassword' => 'required',
            'password' => [
                'required',
                'different:curPassword',
                'min:8',
                'regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/',
            ],
            'confirm_password' => 'required_with:password|same:password',
        ];
    }

    public function messages()
    {
        return [
            'curPassword' => [
                "required" => 'Password saat ini tidak boleh kosong',
            ],
            'password' => [
                "required" => 'Password baru tidak boleh kosong',
                "min" => 'Password minimal 8 karakter',
                "regex" => 'Password harus mengandung huruf dan angka',
                "different" => 'Password baru harus berbeda dari password saat ini'
            ],
            'confirm_password' => [
                "required_with" => 'Konfirmasi password tidak boleh kosong jika password diisi',
                "same" => 'Password tidak sama'
            ]
        ];
    }

    public function reset_password()
    {
        $this->validate();

        $user = Auth::user();
        $pegawai = Auth::guard('pegawai')->user();

        if ($user) {
            if (!Hash::check($this->curPassword, $user->password)) {
                return redirect('/ubah-password')->with([
                    'error' => [
                        "title" => "Password saat ini salah!",
                    ]
                ]);
            }
    
            $user->password = Hash::make($this->password);
            $user->save();
    
            return redirect('/dashboard')->with([
                'success' => [
                    "title" => "Password berhasil diperbarui",
                ]
            ]);
        }

        if ($pegawai) {
            if (!Hash::check($this->curPassword, $pegawai->password)) {
                if ($pegawai->role_temp == 'admin') {
                    return redirect('/ubah-password-admin')->with([
                        'error' => [
                            "title" => "Password saat ini salah!",
                        ]
                    ]);
                } elseif ($pegawai->role_temp == 'regular') {
                    return redirect('/ubah-password-pembimbing')->with([
                        'error' => [
                            "title" => "Password saat ini salah!",
                        ]
                    ]);
                }
            }
    
            $pegawai->password = $this->password;
            $pegawai->save();
    
            if ($pegawai->role_temp == 'admin') {
                return redirect('/dashboard-admin')->with([
                    'success' => [
                        "title" => "Password berhasil diperbarui",
                    ]
                ]);
            } elseif ($pegawai->role_temp == 'regular') {
                return redirect('/dashboard-pembimbing')->with([
                    'success' => [
                        "title" => "Password berhasil diperbarui",
                    ]
                ]);
            }
        }

    }
    
}
