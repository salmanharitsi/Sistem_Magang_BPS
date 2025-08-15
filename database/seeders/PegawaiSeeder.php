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
                "email" => "admin@gmail.com",
                "password" => "bps2025",
                "nomor_induk" => "147107822341122",
                "role_temp" => "admin"
            ],

            // ================
            // Akun Pembimbing
            // ================
            [
                "name" => "Afdi Rizal, S.ST., M.T.",
                "fungsi_bagian" => "Fungsi IPDS",
                "email" => "pembimbingipds1@gmail.com",
                "password" => "bps2025",
                "nomor_induk" => "147107822341123",
                "role_temp" => "regular"
            ],
            [
                "name" => "Dadang Sunandar, S.ST., M.T.",
                "fungsi_bagian" => "Fungsi IPDS",
                "email" => "pembimbingipds2@gmail.com",
                "password" => "bps2025",
                "nomor_induk" => "147107822341124",
                "role_temp" => "regular"
            ],
            [
                "name" => "Yoga Adinata, S.ST., M.T.",
                "fungsi_bagian" => "Fungsi IPDS",
                "email" => "pembimbingipds3@gmail.com",
                "password" => "bps2025",
                "nomor_induk" => "1471078223411241",
                "role_temp" => "regular"
            ],
            [
                "name" => "Khaerul Anas, S.ST., M.T.",
                "fungsi_bagian" => "Fungsi IPDS",
                "email" => "pembimbingipds4@gmail.com",
                "password" => "bps2025",
                "nomor_induk" => "1471078223411242",
                "role_temp" => "regular"
            ],
            [
                "name" => "Agus Wardiman, S.E.",
                "fungsi_bagian" => "Fungsi IPDS",
                "email" => "pembimbingipds5@gmail.com",
                "password" => "bps2025",
                "nomor_induk" => "1471078223411243",
                "role_temp" => "regular"
            ],
            [
                "name" => "Rahmat Wahid, S.Si.",
                "fungsi_bagian" => "Fungsi IPDS",
                "email" => "pembimbingipds6@gmail.com",
                "password" => "bps2025",
                "nomor_induk" => "1471078223411244",
                "role_temp" => "regular"
            ],
            [
                "name" => "Oldestia Vianny, S.ST., M.Si.",
                "fungsi_bagian" => "Fungsi Nerwilis",
                "email" => "pembimbingnerwilis@gmail.com",
                "password" => "bps2025",
                "nomor_induk" => "147107822341126",
                "role_temp" => "regular"
            ],
            [
                "name" => "Rahmi Renzya, S.ST.",
                "fungsi_bagian" => "Fungsi Nerwilis",
                "email" => "pembimbingnerwilis2@gmail.com",
                "password" => "bps2025",
                "nomor_induk" => "1471078223411262",
                "role_temp" => "regular"
            ],
            [
                "name" => "Dr. FITRI HARIYANTI, S.ST., M.M.",
                "fungsi_bagian" => "Fungsi Statistik Distribusi",
                "email" => "pembimbingdistribusi@gmail.com",
                "password" => "bps2025",
                "nomor_induk" => "147107822341127",
                "role_temp" => "regular"
            ],
            [
                "name" => "Muji Basuki, S.ST., M.Si.",
                "fungsi_bagian" => "Fungsi Statistik Produksi",
                "email" => "pembimbingproduksi@gmail.com",
                "password" => "bps2025",
                "nomor_induk" => "147107822341128",
                "role_temp" => "regular"
            ],
            [
                "name" => "MEITA KOMALASARI, S.ST., M.Si.",
                "fungsi_bagian" => "Fungsi Statistik Sosial",
                "email" => "pembimbingsosial@gmail.com",
                "password" => "bps2025",
                "nomor_induk" => "147107822341129",
                "role_temp" => "regular"
            ],
            [
                "name" => "Asep Riyadi, S.Si, M.M",
                "fungsi_bagian" => 'Pimpinan',
                "email" => "pimpinan@gmail.com",
                "password" => "bps2025",
                "nomor_induk" => "149107822341009",
                "role_temp" => "pimpinan"
            ],
            [
                "name" => "ACHMAD SOBARI, S.ST., S.E., M.Si.",
                "fungsi_bagian" => 'Fungsi Nerwilis',
                "email" => "ketuanerwilis@gmail.com",
                "password" => "bps2025",
                "nomor_induk" => "1490207822343009",
                "role_temp" => "ketua_tim"
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

            // Pegawai::create($data);
        }
    }
}