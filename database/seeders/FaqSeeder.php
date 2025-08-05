<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'question' => 'Berapa lama magang di BPS Provinsi Riau?',
                'answer' => 'Magang berlangsung selama 1 sampai 3 bulan tergantung kebijakan dan kebutuhan.',
            ],
            [
                'question' => 'Bisakah untuk konversi mata kuliah?',
                'answer' => 'Ya, magang di BPS Provinsi Riau ini dapat dikonversikan menjadi mata kuliah, sesuai dengan kebijakan masing-masing perguruan tinggi. Mahasiswa disarankan untuk berkoordinasi dengan pihak kampus, seperti dosen pembimbing akademik atau bagian akademik, guna memastikan bahwa kegiatan magang yang dilakukan memenuhi syarat konversi, baik dari segi durasi, jenis kegiatan, maupun dokumen pendukung yang diperlukan.',
            ],
            [
                'question' => 'Apa saja benefit magang di BPS Provinsi Riau?',
                'answer' => 'Peserta magang di BPS Provinsi Riau akan mendapatkan sertifikat sebagai bukti partisipasi, pengalaman kerja di lingkungan instansi pemerintah, serta ilmu dan wawasan yang bermanfaat.',
            ],
            [
                'question' => 'Apakah penempatan ditentukan langsung oleh BPS?',
                'answer' => 'Tidak, penempatan tidak ditentukan langsung oleh BPS. Calon peserta magang memilih sendiri unit penempatannya saat mengajukan permohonan. Namun, BPS Provinsi Riau dapat melakukan penyesuaian atau pemindahan penempatan sesuai dengan kebutuhan instansi dan pertimbangan tertentu.',
            ]
        ];

        foreach ($data as $faq) {
            Faq::create($faq);
        }
    }
}
