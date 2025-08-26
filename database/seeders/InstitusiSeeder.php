<?php

namespace Database\Seeders;

use App\Models\Institusi;
use Illuminate\Database\Seeder;

class InstitusiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $institusiList = [
            // Universitas & Institut
            ['nama' => 'Universitas Riau (UNRI)', 'alamat' => 'Kampus Bina Widya, Jl. HR. Soebrantas KM 12,5, Simpang Baru, Kec. Binawidya, Kota Pekanbaru, Riau 28293'],
            ['nama' => 'Universitas Islam Negeri Sultan Syarif Kasim (UIN Suska) Riau', 'alamat' => 'Jl. H.R. Soebrantas No.155, Tuah Madani, Kec. Tuah Madani, Kota Pekanbaru, Riau 28293'],
            ['nama' => 'Universitas Islam Riau (UIR)', 'alamat' => 'Jl. Kaharuddin Nasution No.113, Simpang Tiga, Kec. Bukit Raya, Kota Pekanbaru, Riau 28284'],
            ['nama' => 'Universitas Muhammadiyah Riau (UMRI)', 'alamat' => 'Jl. Tuanku Tambusai, Delima, Kec. Binawidya, Kota Pekanbaru, Riau 28292'],
            ['nama' => 'Universitas Lancang Kuning (UNILAK)', 'alamat' => 'Jl. Yos Sudarso No.KM. 8, Umban Sari, Kec. Rumbai, Kota Pekanbaru, Riau 28266'],
            ['nama' => 'Universitas Abdurrab', 'alamat' => 'Jl. Riau Ujung No.73, Tampan, Kec. Payung Sekaki, Kota Pekanbaru, Riau 28292'],
            ['nama' => 'Universitas Terbuka Pekanbaru', 'alamat' => 'Jl. Arifin Ahmad No.111, Sidomulyo Tim., Kec. Marpoyan Damai, Kota Pekanbaru, Riau 28125'],
            ['nama' => 'Universitas Hang Tuah Pekanbaru', 'alamat' => 'Jl. Mustafa Sari No.5, Tengkerang Sel., Kec. Bukit Raya, Kota Pekanbaru, Riau 28282'],
            ['nama' => 'Institut Bisnis dan Teknologi Pelita Indonesia', 'alamat' => 'Jl. Jend. Ahmad Yani No.86-88, Sago, Kec. Senapelan, Kota Pekanbaru, Riau 28151'],
            ['nama' => 'Institut Kesehatan dan Teknologi Al Insyirah (IKTA)', 'alamat' => 'Jl. Parit Indah No.38, Tengkerang Labuai, Kec. Bukit Raya, Kota Pekanbaru, Riau'],
            ['nama' => 'Institut Az Zuhra', 'alamat' => 'Jl. Melati No.16, Binawidya, Kec. Binawidya, Kota Pekanbaru, Riau 28293'],

            // Politeknik
            ['nama' => 'Politeknik Caltex Riau (PCR)', 'alamat' => 'Jl. Umban Sari No.1, Umban Sari, Kec. Rumbai, Kota Pekanbaru, Riau 28265'],
            ['nama' => 'Politeknik Kesehatan Kemenkes Riau (Poltekkes Riau)', 'alamat' => 'Jl. Melur No.103, Harjosari, Kec. Sukajadi, Kota Pekanbaru, Riau 28156'],
            ['nama' => 'Politeknik Negeri Pekanbaru', 'alamat' => 'Alamat tidak ditemukan'],
            ['nama' => 'Politeknik Persada Bunda', 'alamat' => 'Jl. Diponegoro No.42, Cinta Raja, Kec. Sail, Kota Pekanbaru, Riau 28127'],

            // SMA
            ['nama' => 'SMA Negeri 1 Pekanbaru', 'alamat' => 'Jl. Sultan Syarif Kasim No.159, Rintis, Kec. Lima Puluh, Kota Pekanbaru, Riau 28141'],
            ['nama' => 'SMA Negeri 2 Pekanbaru', 'alamat' => 'Jl. Nusa Indah, Labuh Baru Timur, Kec. Payung Sekaki, Kota Pekanbaru, Riau 28125'],
            ['nama' => 'SMA Negeri 3 Pekanbaru', 'alamat' => 'Jl. Yos Sudarso No.100 A, Umban Sari, Kec. Rumbai, Kota Pekanbaru, Riau 28265'],
            ['nama' => 'SMA Negeri 4 Pekanbaru', 'alamat' => 'Jl. Adisucipto No.67, Maharatu, Kec. Marpoyan Damai, Kota Pekanbaru, Riau 28125'],
            ['nama' => 'SMA Negeri 5 Pekanbaru', 'alamat' => 'Jl. Bawal No.43, Wonorejo, Kec. Marpoyan Damai, Kota Pekanbaru, Riau 28125'],
            ['nama' => 'SMA Negeri 6 Pekanbaru', 'alamat' => 'Jl. Air Dingin, Simpang Tiga, Kec. Bukit Raya, Kota Pekanbaru, Riau 28284'],
            ['nama' => 'SMA Negeri 7 Pekanbaru', 'alamat' => 'Jl. Kapur, Pematang Kapau, Kec. Tenayan Raya, Kota Pekanbaru, Riau 28289'],
            ['nama' => 'SMA Negeri 8 Pekanbaru', 'alamat' => 'Jl. Abdul Muis No.12, Cinta Raja, Kec. Sail, Kota Pekanbaru, Riau 28127'],
            ['nama' => 'SMA Negeri 9 Pekanbaru', 'alamat' => 'Jl. Semeru No.10, Sekip, Kec. Lima Puluh, Kota Pekanbaru, Riau 28155'],
            ['nama' => 'SMA Negeri 10 Pekanbaru', 'alamat' => 'Jl. Bukit Barisan, Tengkerang Timur, Kec. Tenayan Raya, Kota Pekanbaru, Riau 28289'],
            ['nama' => 'SMA Negeri 11 Pekanbaru', 'alamat' => 'Jl. Segar No.40, Rejosari, Kec. Tenayan Raya, Kota Pekanbaru, Riau 28131'],
            ['nama' => 'SMA Negeri 12 Pekanbaru', 'alamat' => 'Jl. Ketitiran, Simpang Baru, Kec. Binawidya, Kota Pekanbaru, Riau 28293'],
            ['nama' => 'SMA Santa Maria Pekanbaru', 'alamat' => 'Jl. Ronggo Warsito, Suka Maju, Kec. Sail, Kota Pekanbaru, Riau 28127'],
            ['nama' => 'SMA Darma Yudha', 'alamat' => 'Jl. SM Amin No.189, Air Hitam, Kec. Payung Sekaki, Kota Pekanbaru, Riau 28292'],
            ['nama' => 'SMA Cendana Pekanbaru', 'alamat' => 'Jl. Komplek Palem PT. Pertamina Hulu Rokan, Lembah Damai, Kec. Rumbai, Kota Pekanbaru, Riau'],
            ['nama' => 'SMA Al-Azhar Syifa Budi Pekanbaru', 'alamat' => 'Jl. Jenderal Sudirman, Suka Mulia, Kec. Sail, Kota Pekanbaru, Riau'],
            ['nama' => 'SMA Babussalam Pekanbaru', 'alamat' => 'Jl. H.R. Soebrantas No.62, Sidomulyo Barat, Kec. Tuah Madani, Kota Pekanbaru, Riau 28294'],
            ['nama' => 'MAN 1 Pekanbaru', 'alamat' => 'Jl. Bandeng No.51 A, Tengkerang Tengah, Kec. Marpoyan Damai, Kota Pekanbaru, Riau'],
            ['nama' => 'MAN 2 Pekanbaru', 'alamat' => 'Jl. Diponegoro No.55, Suka Mulia, Kec. Sail, Kota Pekanbaru, Riau 28127'],

            // SMK
            ['nama' => 'SMK Negeri 1 Pekanbaru', 'alamat' => 'Jl. Jenderal Ahmad Yani, Sago, Kec. Senapelan, Kota Pekanbaru, Riau 28151'],
            ['nama' => 'SMK Negeri 2 Pekanbaru', 'alamat' => 'Jl. Patimura No.12, Cinta Raja, Kec. Sail, Kota Pekanbaru, Riau 28127'],
            ['nama' => 'SMK Negeri 3 Pekanbaru', 'alamat' => 'Jl. Jenderal Sudirman No.24, Suka Maju, Kec. Sail, Kota Pekanbaru, Riau 28127'],
            ['nama' => 'SMK Negeri 4 Pekanbaru', 'alamat' => 'Jl. Purwodadi, Sidomulyo Barat, Kec. Tuah Madani, Kota Pekanbaru, Riau 28294'],
            ['nama' => 'SMK Negeri 5 Pekanbaru', 'alamat' => 'Jl. Yos Sudarso, Sri Meranti, Kec. Rumbai, Kota Pekanbaru, Riau 28261'],
            ['nama' => 'SMK Negeri 6 Pekanbaru', 'alamat' => 'Jl. Sembilang No.28A, Limbungan Baru, Kec. Rumbai, Kota Pekanbaru, Riau 28261'],
            ['nama' => 'SMK Negeri 7 Pekanbaru', 'alamat' => 'Jl. Toman, Sri Meranti, Kec. Rumbai, Kota Pekanbaru, Riau 28261'],
            ['nama' => 'SMKN Pertanian Terpadu Riau', 'alamat' => 'Jl. Dr. Sutomo, Suka Mulia, Kec. Sail, Kota Pekanbaru, Riau 28127'],
            ['nama' => 'SMK Muhammadiyah 1 Pekanbaru', 'alamat' => 'Jl. Cempedak, Pulau Karomah, Kec. Sukajadi, Kota Pekanbaru, Riau 28121'],
            ['nama' => 'SMK Muhammadiyah 2 Pekanbaru', 'alamat' => 'Jl. KH. Ahmad Dahlan No.90, Kp. Melayu, Kec. Sukajadi, Kota Pekanbaru, Riau 28122'],
            ['nama' => 'SMK Farmasi Ikasari Pekanbaru', 'alamat' => 'Jl. Bangau Sakti, Simpang Baru, Kec. Binawidya, Kota Pekanbaru, Riau 28293'],
            ['nama' => 'SMK Kesehatan As-Shofa', 'alamat' => 'Jl. Cipta Karya, Sialang Munggu, Kec. Tuah Madani, Kota Pekanbaru, Riau 28293'],
        ];

        foreach ($institusiList as $data) {
            Institusi::create([
                'nama'   => $data['nama'],
                'alamat' => $data['alamat'],
                'status' => 'approved', // ✅ langsung approved
            ]);
        }
    }
}
