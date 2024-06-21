<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Login extends Component
{
    #[Validate]
    public $email, $password;

    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'email' => [
                "required" => 'Email tidak boleh kosong',
                "email" => 'Gunakan email yang valid',
            ],
            'password' => [
                "required" => 'Password tidak boleh kosong',
            ],
        ];
    }

    public function login()
    {
        $this->validate();
        
        if (!User::where('email', $this->email)->exists()) {
            
            return redirect('/login')->with([
                'error' => [
                    "title" => "Email tidak terdaftar!",
                ]
            ]);
        }

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], true)) {
            return redirect()->intended('dashboard')->with([
                'success' => [
                    "title" => "Berhasil masuk",
                ]
            ]);
        } 

        return redirect('/login')->with([
            'error' => [
                "title" => "Email atau password salah!",
            ]
        ]);
    }
}
