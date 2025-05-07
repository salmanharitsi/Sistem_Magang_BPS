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
                "name" => "Lionel Messi",
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
                "fungsi_bagian" => "Pengolahan dan Teknologi Informasi",
                "email" => "afdi@bps.go.id",
                "password" => "bps2025",
                "nomor_induk" => "147107822341123",
                "role_temp" => "regular"
            ],
            [
                "name" => "Dadang Sunandar, S.ST., M.T.",
                "fungsi_bagian" => "Pengolahan dan Teknologi Informasi",
                "email" => "dadangsunandar@bps.go.id",
                "password" => "bps2025",
                "nomor_induk" => "147107822341124",
                "role_temp" => "regular"
            ],
            [
                "name" => "Yoga Adinata, S.ST., M.T.",
                "fungsi_bagian" => "Pengolahan dan Teknologi Informasi",
                "email" => "adinata@bps.go.id",
                "password" => "bps2025",
                "nomor_induk" => "147107822341125",
                "role_temp" => "regular"
            ],
            [
                "name" => "Khaerul Anas, S.ST., M.T.",
                "fungsi_bagian" => "Pengolahan dan Teknologi Informasi",
                "email" => "khaerulanas@bps.go.id",
                "password" => "bps2025",
                "nomor_induk" => "147107822341126",
                "role_temp" => "regular"
            ],
            [
                "name" => "Agus Wardiman, S.E.",
                "fungsi_bagian" => "Humas dan Unit Kerja Kepala",
                "email" => "agus.wardiman@bps.go.id",
                "password" => "bps2025",
                "nomor_induk" => "147107822341127",
                "role_temp" => "regular"
            ],
            [
                "name" => "Rahmat Wahid, S.Si.",
                "fungsi_bagian" => "Humas dan Unit Kerja Kepala",
                "email" => "rwahid@bps.go.id",
                "password" => "bps2025",
                "nomor_induk" => "147107822341128",
                "role_temp" => "regular"
            ],
            [
                "name" => "Oldestia Vianny, S.ST., M.Si.",
                "fungsi_bagian" => "Neraca Wilayah dan Analisis Statistik",
                "email" => "oldestia@bps.go.id",
                "password" => "bps2025",
                "nomor_induk" => "147107822341129",
                "role_temp" => "regular"
            ],
            [
                "name" => "Amrizal, SST., M.M.",
                "fungsi_bagian" => "Bagian Umum",
                "email" => "amrizal@bps.go.id",
                "password" => "bps2025",
                "nomor_induk" => "147107822341130",
                "role_temp" => "admin"
            ],
            [
                "name" => "Muji Basuki, S.ST., M.Si.",
                "fungsi_bagian" => "Statistik Produksi",
                "email" => "mudji@bps.go.id",
                "password" => "bps2025",
                "nomor_induk" => "147107822341131",
                "role_temp" => "regular"
            ],
            [
                "name" => "Emilia Dharmayanthi, S.ST., M.Si.",
                "fungsi_bagian" => "Pembinaan Statistik Sektoral",
                "email" => "emiliad@bps.go.id",
                "password" => "bps2025",
                "nomor_induk" => "147107822341132",
                "role_temp" => "regular"
            ],
            [
                "name" => "Rahmi Renzya, S.ST.",
                "fungsi_bagian" => "Neraca Wilayah dan Analisis Statistik",
                "email" => "renyza@bps.go.id",
                "password" => "bps2025",
                "nomor_induk" => "147107822341133",
                "role_temp" => "regular"
            ],
            
            // ================
            // Akun Pimpinan
            // ================
            [
                "name" => "Dr. Gianluci, M.M.",
                "fungsi_bagian" => "Pimpinan",
                "email" => "pimpinan@bps.go.id",
                "password" => "bps2025",
                "nomor_induk" => "149107822341009",
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