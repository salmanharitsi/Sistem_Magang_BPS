<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController
{
    public function get_login_page(){
        if (!empty(Auth::check())) {
            return redirect('dashboard');
        }
        return view('auth.login');
    }

    public function get_registrasi_page(){
        if (!empty(Auth::check())) {
            return redirect('dashboard');
        }
        return view('auth.registrasi');
    }
}
