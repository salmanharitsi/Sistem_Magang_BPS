<?php

namespace App\Livewire;

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

        if (!Hash::check($this->curPassword, $user->password)) {
            return redirect('/ubah-password')->with([
                'error' => [
                    "title" => "Password saat ini salah!",
                ]
            ]);
        }

        $user->password = Hash::make($this->password);
        $user->save();

        return redirect('/ubah-password')->with([
            'success' => [
                "title" => "Password berhasil diperbarui",
            ]
        ]);
    }
    
}
