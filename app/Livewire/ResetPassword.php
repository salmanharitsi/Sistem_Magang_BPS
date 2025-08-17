<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ResetPassword extends Component
{
    #[Validate]
    public $password;
    public $confirm_password;
    public $token;

    public function mount($token)
    {
        $this->token = $token;
    }

    public function rules()
    {
        return [
            'password' => 'required|min:8|regex:/^(?=.[a-zA-Z])(?=.\d).+$/',
            'confirm_password' => 'required_with:password|same:password',
        ];
    }

    public function messages()
    {
        return [
            'password' => [
                "required" => 'Password tidak boleh kosong',
                "min" => 'Password minimal 8 karakter',
                "regex" => 'Password harus mengandung huruf dan angka'
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
        
        // Find token in password_reset_tokens table
        $tokenData = DB::table('password_reset_tokens')
                      ->where('token', $this->token)
                      ->first();
        
        if (!$tokenData) {
            abort(403, 'Invalid token');
        }

        // Find user by email
        $user = User::where('email', $tokenData->email)->first();
        if (!$user) {
            abort(403, 'User not found');
        }

        // Update user password
        $user->password = Hash::make($this->password);
        $user->save();

        // Delete the token after successful password reset
        DB::table('password_reset_tokens')->where('token', $this->token)->delete();

        return redirect('/login')->with([
            'success' => [
                "title" => "Password berhasil diperbarui",
            ]
        ]);
    }
}