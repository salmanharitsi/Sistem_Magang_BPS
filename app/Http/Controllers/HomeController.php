<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\FungsiBagian;
use App\Models\Galeri;
use App\Models\Fasilitas;
use App\Models\Feedback;
use Database\Seeders\KontentFungsiBagianSeeder;
use Illuminate\Http\Request;

class HomeController
{
    public function index() 
    {
        $fungsi_bagian = FungsiBagian::where('title', '!=', 'Pimpinan')->get();

        $faqs = Faq::all();

        $galeris = Galeri::latest()->take(6)->get();

        $fasilitas = Fasilitas::latest()->take(6)->get();

        $testimonis = Feedback::where('is_displayed', true)
                             ->latest()
                             ->take(6)
                             ->with(['magang.user'])
                             ->get();


        return view('home', compact('fungsi_bagian', 'faqs', 'galeris', 'fasilitas', 'testimonis'));
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
