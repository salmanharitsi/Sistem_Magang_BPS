<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserNormalController
{
    public function get_dashboard()
    {
        if (request()->pjax()) {
            return false;
        }
        return view('usernormal.dashboard');
    }

    public function get_status_pengajuan()
    {
        if (request()->pjax()) {
            return false;
        }
        return view('usernormal.pengajuan');
    }

}
