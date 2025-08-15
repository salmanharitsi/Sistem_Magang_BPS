<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\FungsiBagian;
use Database\Seeders\KontentFungsiBagianSeeder;
use Illuminate\Http\Request;

class HomeController
{
    public function index() {
        $fungsi_bagian = FungsiBagian::where('title', '!=', 'Pimpinan')->get();

        $faqs = Faq::all();

        return view('home', compact('fungsi_bagian', 'faqs'));
    }

    public function get_user_profil()
    {
        if (request()->pjax()) {
            return false;
        }
        return view('public.profil');
    }

    public function get_user_profil_edit()
    {
        if (request()->pjax()) {
            return false;
        }
        return view('public.profil-edit');
    }

    public function get_ubah_password()
    {
        if (request()->pjax()) {
            return false;
        }
        return view('public.ubah-password');
    }
}
