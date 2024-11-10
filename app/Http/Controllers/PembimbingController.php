<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PembimbingController
{
    public function get_dashboard_pembimbing()
    {
        if (request()->pjax()) {
            return false;
        }
        return view('pembimbing.dashboard');
    }
}
