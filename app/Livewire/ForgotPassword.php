<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Mail\ForgotPasswordMail;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ForgotPassword extends Component
{
    #[Validate]
    public $email;

    public function rules()
    {
        return [
            'email' => 'required|email',
        ];
    }

    public function messages()
    {
        return [
            'email' => [
                "required" => 'Email tidak boleh kosong',
                "email" => 'Gunakan email yang valid',
            ],
        ];
    }

    public function forgot_password()
    {
        $this->validate();
        
        $count = User::where('email', '=', $this->email)->count();
        if ($count > 0) {
            $user = User::where('email', '=', $this->email)->first();
            
            // Generate a random token
            $token = Str::random(60);
            
            // Store the token in the password_reset_tokens table
            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $user->email],
                [
                    'token' => $token,
                    'created_at' => now()
                ]
            );

            // Send the user an email with the token
            Mail::to($user->email)->send(new ForgotPasswordMail($user, $token));

            return redirect('/forgot-password')->with([
                'success' => [
                    "title" => "Cek kotak email kamu",
                ]
            ]);
        }
        else{
            return redirect('/forgot-password')->with([
                'error' => [
                    "title" => "Email tidak terdaftar!",
                ]
            ]);
        }
    }
}