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
                'title' => 'Bagian Umum',
                'description' => 'Mengatur dan melaksanakan penyiapan bahan dan penyusunan rancangan usulan program kerja tahunan BPS; Mengatur dan melaksanakan keikutsertaan dalam program pendidikan dan pelatihan; Mengatur dan melaksanakan penyiapan, penyusunan rencana dan program, serta pengadaan, penyaluran, penyimpanan, inventarisasi, penghapusan, dan pemeliharaan peralatan dan perlengkapan; Mengatur dan melaksanakan kegiatan kepegawaian, pengadaan dan mutasi pegawai, pembinaan pegawai, hukum dan perundang-undangan, organisasi dan tata laksana, kesejahteraan pegawai, serta administrasi jabatan fungsional; Mengatur dan melaksanakan kegiatan surat menyurat, kearsipan, rumah tangga, pemeliharaan gedung, keamanan dan ketertiban lingkungan, serta penggandaan/percetakan.',
                'jurusan' => ['Administrasi', 'Manajemen', 'Hukum']
            ],
            [
                'title' => 'Administrasi',
                'description' => 'Mengatur dan melaksanakan kegiatan keuangan, perbendaharaan, verifikasi dan pembukuan, perjalanan dinas, penggajian, serta pengendalian pelaksanaan anggaran; Membantu Kepala BPS Propinsi dalam melaksanakan pengawasan pelaksanaan kegiatan dan anggaran serta pengelolaan administrasi; Membantu Kepala BPS Propinsi dalam melaksanakan penyiapan bahan untuk penyusunan laporan tahunan akuntabilitas kinerja dan laporan tahunan pelaksanaan program kerja lainnya; Mengatur dan melaksanakan kegiatan pelayanan administrasi lainnya kepada semua satuan organisasi di lingkungan BPS; Mengatur dan melaksanakan urusan administrasi penyelenggaraan berbagai pendidikan dan pelatihan.',
                'jurusan' => ['Akuntansi', 'Keuangan', 'Administrasi']
            ],
            [
                'title' => 'Statistik Sosial',
                'description' => 'Mengatur penyiapan dokumen dan bahan yang diperlukan untuk kegiatan pengumpulan statistik sosial yang mencakup kegiatan statistik kependudukan, kesejahteraan rakyat, ketahanan sosial, dan kegiatan statistik sosial lainnya; Mengatur dan melaksanakan keikutsertaan dalam program pendidikan dan pelatihan dalam kegiatan statistik sosial; Membantu Kepala BPS Propinsi dalam menyiapkan program pelatihan petugas lapangan kegiatan statistik sosial; Mengatur dan melaksanakan pengolahan data statistik sosial; Mengatur dan menyiapkan dokumen dan atau hasil pengolahan statistik sosial; Mengatur dan melaksanakan evaluasi hasil pengolahan statistik sosial; Membantu Kepala BPS Propinsi dalam melaksanakan pembinaan petugas lapangan dalam rangka pengumpulan data statistik sosial.',
                'jurusan' => ['Statistika', 'Sosiologi', 'Kependudukan']
            ],
            [
                'title' => 'Statistik Produksi',
                'description' => 'Mengatur dan menyiapkan dokumen dan bahan yang diperlukan untuk kegiatan pengumpulan statistik produksi yang mencakup kegiatan statistik pertanian, industri, pertambangan, energi, konstruksi, dan kegiatan statistik produksi lainnya; Mengatur dan melaksanakan keikutsertaan dalam program pendidikan dan pelatihan dalam kegiatan statistik produksi; Membantu Kepala BPS Propinsi dalam menyiapkan program pelatihan petugas lapangan; Mengatur dan melaksanakan pengolahan data statistik produksi; Mengatur dan menyiapkan dokumen dan atau hasil pengolahan statistik produksi; Mengatur dan melaksanakan evaluasi hasil kegiatan statistik produksi; Membantu Kepala BPS Propinsi dalam melaksanakan pembinaan petugas lapangan dalam rangka pengumpulan data statistik produksi.',
                'jurusan' => ['Statistika', 'Pertanian', 'Teknik Industri']
            ],
            [
                'title' => 'Statistik Distribusi',
                'description' => 'Mengatur penyiapan dokumen dan bahan yang diperlukan untuk kegiatan pengumpulan statistik distribusi yang mencakup kegiatan statistik harga konsumen dan perdagangan besar, keuangan dan harga produsen, niaga dan jasa, serta kegiatan statistik distribusi lainnya; Mengatur dan melaksanakan keikutsertaan dalam program pendidikan dan pelatihan dalam kegiatan statistik distribusi; Membantu Kepala BPS Propinsi dalam menyiapkan program pelatihan petugas lapangan; Mengatur dan melaksanakan pengolahan data statistik distribusi; Mengatur dan menyiapkan dokumen dan atau hasil pengolahan statistik distribusi; Mengatur dan melaksanakan evaluasi hasil pengolahan statistik distribusi; Membantu Kepala BPS Propinsi dalam melaksanakan pembinaan petugas lapangan dalam rangka pengumpulan data statistik distribusi.',
                'jurusan' => ['Statistika', 'Ekonomi', 'Manajemen']
            ],
            [
                'title' => 'Neraca Wilayah dan Analisis Statistik',
                'description' => 'Mengatur penyiapan dokumen dan bahan yang diperlukan untuk penyusunan neraca wilayah dan analisis statistik yang mencakup penyusunan neraca produksi, neraca konsumsi, analisis dan pengembangan statistik; Mengatur dan melaksanakan keikutsertaan dalam program pendidikan dan pelatihan dalam kegiatan neraca wilayah dan analisis statistik; Mengatur dan melaksanakan pengolahan data neraca produksi dan neraca konsumsi; Mengatur dan melaksanakan penyusunan neraca wilayah dan analisis statistik; Mengatur dan melaksanakan evaluasi hasil pengolahan neraca wilayah dan analisis statistik; Membantu Kepala BPS Propinsi dalam melaksanakan pembinaan petugas pencacah, pengawas, pemeriksa, serta pengumpul data neraca produksi dan neraca konsumsi.',
                'jurusan' => ['Statistika', 'Ekonomi', 'Akuntansi']
            ],
            [
                'title' => 'Diseminasi dan Layanan Statistik',
                'description' => 'Mengatur dan melaksanakan keikutsertaan dalam program pendidikan dan pelatihan dalam kegiatan diseminasi statistik; Mengatur dan melaksanakan kompilasi naskah dari satuan organisasi di lingkungan BPS Propinsi dalam bentuk softcopy untuk dijadikan naskah publikasi siap cetak; Membantu Kepala BPS Propinsi dalam mengatur dan melaksanakan pemantauan serta evaluasi publikasi; Mengatur dan menyusun prosedur penyiapan bahan serta melaksanakan kegiatan pelayanan informasi statistik dan konsultasi statistik; Mengatur pengelolaan bahan pustaka dan dokumen statistik; Mengatur dan melaksanakan penghimpunan tata cara dan hasil kegiatan yang dilakukan di lingkungan Bidang Diseminasi Statistik.',
                'jurusan' => ['Komunikasi', 'Statistika', 'Perpustakaan']
            ],
            [
                'title' => 'Pengolahan dan Teknologi Informasi',
                'description' => 'Melaksanakan penyusunan, pemeliharaan, penyelesaian permasalahan, dan pengembangan sistem jaringan komunikasi data; Mengatur dan melaksanakan keikutsertaan dalam program pendidikan dan pelatihan dalam kegiatan pengolahan dan teknologi informasi; Melaksanakan koordinasi pengelolaan dan pemeliharaan perangkat keras dan perangkat lunak serta menyusun sistem pengelolaan data; Mengatur dan melaksanakan integrasi penggunaan sistem dan program aplikasi pengolahan data statistik; Melaksanakan penyusunan, pemeliharaan, serta pengembangan sistem basis data statistik dan basis data manajemen; Melaksanakan kajian dan evaluasi kebutuhan pengolahan data termasuk bahan komputer; Mengatur dan melaksanakan penyusunan dan pemeliharaan data untuk pemetaan dan kerangka contoh induk.',
                'jurusan' => ['Teknik Informatika', 'Sistem Informasi', 'Statistika']
            ],
            [
                'title' => 'Pembinaan Statistik Sektoral',
                'description' => 'Membantu Kepala BPS Propinsi dalam melaksanakan kegiatan rujukan statistik dasar, statistik sektoral, dan statistik khusus; Mengatur dan melaksanakan penerimaan, pengelolaan, serta pengolahan semua dokumen yang berkaitan dengan rujukan statistik dan penyempurnaan format yang berkaitan dengan rujukan statistik; Mengatur dan melaksanakan penyusunan serta evaluasi meta data untuk rujukan statistik; Mengatur dan melaksanakan kompilasi rancangan teknis survei statistik sektoral instansi pemerintah lain serta membahas dengan satuan organisasi terkait sesuai dengan asas pembakuan dan manfaat; Membantu Kepala BPS Propinsi dalam mengatur dan menyiapkan konsep rekomendasi sebagai bahan pelaksanaan survei statistik sektoral bagi instansi pemerintah lain.',
                'jurusan' => ['Statistika', 'Administrasi Publik', 'Ekonomi']
            ],
            [
                'title' => 'Humas dan Unit Kerja Kepala',
                'description' => 'Mengatur dan melaksanakan penerangan kegiatan statistik dan kehumasan; Menyediakan layanan informasi statistik melalui berbagai media; Mengelola hubungan dengan media, termasuk menyiapkan materi pers, mengatur wawancara, dan menanggapi pemberitaan; Membuat dan mendistribusikan berbagai materi publikasi; Mengelola dan memperbarui konten website dan akun media sosial BPS; Mengorganisir acara-acara seperti konferensi pers, seminar, lokakarya, dan pameran; Memantau pemberitaan media dan umpan balik dari publik; Menyusun dan melaksanakan strategi komunikasi dalam situasi krisis; Bekerja sama dengan bidang atau bagian lain di BPS; Melakukan kegiatan edukasi kepada masyarakat tentang pentingnya statistik.',
                'jurusan' => ['Komunikasi', 'Hubungan Masyarakat', 'Jurnalistik']
            ],
            [
                'title' => 'Pimpinan',
                'description' => 'Pimpinan',
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