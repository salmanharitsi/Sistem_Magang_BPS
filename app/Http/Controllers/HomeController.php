<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController
{
    public function index() {
        $fungsi_bagian = [
            [
                'title' => 'Statistik Sosial',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus suscipit iusto, itaque vitae, quas, ex ullam sint voluptate nemo omnis officia magnam sequi cupiditate illum perferendis nam rerum! Sunt, maiores.',
                'jurusan' => ['Teknik Informatika', 'Hukum', 'Teknik Elektro', 'Statistika','Teknik Informatika', 'Hukum', 'Teknik Elektro', 'Statistika']
            ],
            [
                'title' => 'Statistik Produksi',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus suscipit iusto, itaque vitae, quas, ex ullam sint voluptate nemo omnis officia magnam sequi cupiditate illum perferendis nam rerum! Sunt, maiores.',
                'jurusan' => ['Teknik Informatika', 'Teknik Elektro', 'Statistika']
            ],
            [
                'title' => 'Statistik Distribusi',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus suscipit iusto, itaque vitae, quas, ex ullam sint voluptate nemo omnis officia magnam sequi cupiditate illum perferendis nam rerum! Sunt, maiores.',
                'jurusan' => ['Teknik Informatika', 'Teknik Elektro', 'Statistika']
            ],
            [
                'title' => 'Fungsi Nerwilis',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus suscipit iusto, itaque vitae, quas, ex ullam sint voluptate nemo omnis officia magnam sequi cupiditate illum perferendis nam rerum! Sunt, maiores.',
                'jurusan' => ['Teknik Informatika', 'Teknik Elektro', 'Statistika']
            ],
            [
                'title' => 'Fungsi IPDS',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus suscipit iusto, itaque vitae, quas, ex ullam sint voluptate nemo omnis officia magnam sequi cupiditate illum perferendis nam rerum! Sunt, maiores.',
                'jurusan' => ['Teknik Informatika', 'Teknik Elektro', 'Statistika']
            ],
            [
                'title' => 'Bagian Umum',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus suscipit iusto, itaque vitae, quas, ex ullam sint voluptate nemo omnis officia magnam sequi cupiditate illum perferendis nam rerum! Sunt, maiores.',
                'jurusan' => ['Teknik Informatika', 'Teknik Elektro', 'Statistika']
            ]
        ];

        return view('home', compact('fungsi_bagian'));
    }
}
