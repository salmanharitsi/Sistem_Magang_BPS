<?php

namespace Database\Seeders;

use App\Models\FungsiBagian;
use Illuminate\Database\Seeder;
use App\Models\FungsiBagianJurusan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FungsiBagianSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'title' => 'Fungsi Statistik Produksi',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus suscipit iusto, itaque vitae, quas, ex ullam sint voluptate nemo omnis officia magnam sequi cupiditate illum perferendis nam rerum! Sunt, maiores.',
                'jurusan' => ['Teknik Informatika', 'Teknik Elektro', 'Statistika']
            ],
            [
                'title' => 'Fungsi Statistik Sosial',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus suscipit iusto, itaque vitae, quas, ex ullam sint voluptate nemo omnis officia magnam sequi cupiditate illum perferendis nam rerum! Sunt, maiores.',
                'jurusan' => ['Teknik Informatika', 'Hukum', 'Teknik Elektro', 'Statistika', 'Teknik Informatika', 'Hukum', 'Teknik Elektro', 'Statistika']
            ],
            [
                'title' => 'Fungsi Statistik Distribusi',
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
            ],
            [
                'title' => 'Pimpinan',
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Natus suscipit iusto, itaque vitae, quas, ex ullam sint voluptate nemo omnis officia magnam sequi cupiditate illum perferendis nam rerum! Sunt, maiores.',
                'jurusan' => ['Pimpinan']
            ]
        ];

        foreach ($data as $item) {
            $fungsiBagian = FungsiBagian::create([
                'title' => $item['title'],
                'description' => $item['description'],
            ]);

            foreach ($item['jurusan'] as $jurusan) {
                FungsiBagianJurusan::create([
                    'fungsi_bagian_id' => $fungsiBagian->id,
                    'jurusan' => $jurusan,
                ]);
            }
        }
    }
}
