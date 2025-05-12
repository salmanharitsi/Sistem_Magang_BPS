<?php

namespace Database\Seeders;

use App\Models\Pegawai;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pegawai = [
            // ==============
            // Akun Admin
            // ==============
            [
                "name" => "Amrizal, SST., M.M.",
                "fungsi_bagian" => "Bagian Umum",
                "email" => "amrizal@bps.go.id",
                "password" => "bps2025",
                "nomor_induk" => "147107839341130",
                "role_temp" => "admin"
            ],

            // ================
            // Akun Pembimbing 
            // ================
            [
                "name" => "Afdi Rizal, S.ST., M.T.",
                "fungsi_bagian" => "Pengolahan dan Teknologi Informasi",
                "email" => "afdi@bps.go.id",
                "password" => "bps2025",
                "nomor_induk" => "147808552341123",
                "role_temp" => "regular"
            ],
            [
                "name" => "Yoga Adinata, S.ST., M.T.",
                "fungsi_bagian" => "Pengolahan dan Teknologi Informasi",
                "email" => "adinata@bps.go.id",
                "password" => "bps2025",
                "nomor_induk" => "148704042341125",
                "role_temp" => "regular"
            ],
            [
                "name" => "Khaerul Anas, S.ST., M.T.",
                "fungsi_bagian" => "Pengolahan dan Teknologi Informasi",
                "email" => "khaerulanas@bps.go.id",
                "password" => "bps2025",
                "nomor_induk" => "148807822340526",
                "role_temp" => "regular"
            ],
            [
                "name" => "Agus Wardiman, S.E.",
                "fungsi_bagian" => "Humas dan Unit Kerja Kepala",
                "email" => "agus.wardiman@bps.go.id",
                "password" => "bps2025",
                "nomor_induk" => "148507942341127",
                "role_temp" => "regular"
            ],
            [
                "name" => "Rahmat Wahid, S.Si.",
                "fungsi_bagian" => "Humas dan Unit Kerja Kepala",
                "email" => "rwahid@bps.go.id",
                "password" => "bps2025",
                "nomor_induk" => "147607845959128",
                "role_temp" => "regular"
            ],
            [
                "name" => "Oldestia Vianny, S.ST., M.Si.",
                "fungsi_bagian" => "Neraca Wilayah dan Analisis Statistik",
                "email" => "oldestia@bps.go.id",
                "password" => "bps2025",
                "nomor_induk" => "1469074592341129",
                "role_temp" => "regular"
            ],
            [
                "name" => "Rahmi Renzya, S.ST.",
                "fungsi_bagian" => "Neraca Wilayah dan Analisis Statistik",
                "email" => "renyza@bps.go.id",
                "password" => "bps2025",
                "nomor_induk" => "149637422341133",
                "role_temp" => "regular"
            ],

            // ================
            // Akun Ketua Tim
            // ================

            [
                "name" => "Dadang Sunandar, S.ST., M.T.",
                "fungsi_bagian" => "Pengolahan dan Teknologi Informasi",
                "email" => "dadangsunandar@bps.go.id",
                "password" => "bps2025",
                "nomor_induk" => "147107822341124",
                "role_temp" => "ketua_tim"
            ],
            [
                "name" => "Ajid Hajiji, S.ST., M.Si.",
                "fungsi_bagian" => "Bagian Umum",
                "email" => "ajid.hajiji@bps.go.id",
                "password" => "bps2025",
                "nomor_induk" => "149207822341139",
                "role_temp" => "ketua_tim"
            ],
            [
                "name" => "Marthasari Julita Tambunan, S.ST., M.M.",
                "fungsi_bagian" => "Administrasi",
                "email" => "marthasari_jt@bps.go.id",
                "password" => "bps2025",
                "nomor_induk" => "148907822340324",
                "role_temp" => "ketua_tim"
            ],
            [
                "name" => "Muji Basuki, S.ST., M.Si.",
                "fungsi_bagian" => "Statistik Produksi",
                "email" => "mudji@bps.go.id",
                "password" => "bps2025",
                "nomor_induk" => "1495078452590324",
                "role_temp" => "ketua_tim"
            ],
            [
                "name" => "Meita Komalasari, S.ST., M.Si.",
                "fungsi_bagian" => "Statistik Sosial",
                "email" => "meita@bps.go.id",
                "password" => "bps2025",
                "nomor_induk" => "149307822590324",
                "role_temp" => "ketua_tim"
            ],
            [
                "name" => "Dr. Fitri Hariyanti, S.ST., M.M.",
                "fungsi_bagian" => "Statistik Distribusi",
                "email" => "fhariyanti@bps.go.id",
                "password" => "bps2025",
                "nomor_induk" => "149907820850324",
                "role_temp" => "ketua_tim"
            ],
            [
                "name" => "Achmad Sobari, S.ST., S.E., M.Si.",
                "fungsi_bagian" => "Neraca Wilayah dan Analisis Statistik",
                "email" => "achmad.sobari@bps.go.id",
                "password" => "bps2025",
                "nomor_induk" => "149607820850324",
                "role_temp" => "ketua_tim"
            ],
            [
                "name" => "Agung Gumilar Triyanto, S.ST., M.Si.",
                "fungsi_bagian" => "Diseminasi dan Layanan Statistik",
                "email" => "gumilar@bps.go.id",
                "password" => "bps2025",
                "nomor_induk" => "1497078200485824",
                "role_temp" => "ketua_tim"
            ],
            [
                "name" => "Emilia Dharmayanthi, S.ST., M.Si.",
                "fungsi_bagian" => "Pembinaan Statistik Sektoral",
                "email" => "emiliad@bps.go.id",
                "password" => "bps2025",
                "nomor_induk" => "147107822341132",
                "role_temp" => "ketua_tim"
            ],
            [
                "name" => "Irfarial, S.E.",
                "fungsi_bagian" => "Humas dan Unit Kerja Kepala",
                "email" => "ifrar@bps.go.id",
                "password" => "bps2025",
                "nomor_induk" => "1489078209485024",
                "role_temp" => "ketua_tim"
            ],
            
            // ================
            // Akun Pimpinan
            // ================
            [
                "name" => "Asep Riyadi",
                "fungsi_bagian" => "Pimpinan",
                "email" => "asepriyadi@bps.go.id",
                "password" => "bps2025",
                "nomor_induk" => "148807445341009",
                "role_temp" => "pimpinan"
            ],
        ];

        foreach ($pegawai as $data) {
            Pegawai::create([
                "name" => $data['name'],
                "fungsi_bagian" => $data['fungsi_bagian'],
                "email" => $data['email'],
                "password" => $data['password'],
                "nomor_induk" => $data['nomor_induk'],
                "role_temp" => $data['role_temp'],
                "remember_token" => Str::random(50),
            ]);
        }
    }
}