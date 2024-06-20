<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController
{
    public function get_login_page(){
        return view('auth.login');
    }

    public function get_registrasi_page(){
        return view('auth.registrasi');
    }
}
