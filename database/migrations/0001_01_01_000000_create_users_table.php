<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            //biodata
            $table->string('foto_profil')->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('nomor_hp');
            $table->string('tentang_saya')->nullable()->length(500);
            $table->string('jenis_kelamin')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('alamat')->nullable();
            $table->enum('status_magang', ['aktif', 'masa-daftar', 'tidak-aktif'])->default('tidak-aktif')->nullable();
            //akademik
            $table->string('institusi');
            $table->string('jurusan');
            $table->string('nomor_induk')->unique();
            $table->string('kartu_penduduk')->nullable();
            $table->string('original_filename_ktp')->nullable();
            $table->string('kartu_tanda');
            $table->string('original_filename_kartu')->nullable();
            $table->timestamps();
        });

        Schema::create('pegawai', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('name');
            $table->string('fungsi_bagian');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('nomor_induk')->unique();
            $table->enum('role_temp', ['regular', 'admin'])->default('regular')->nullable();
            $table->timestamps();
        });

        Schema::create('pengajuan', function (Blueprint $table){
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->string('jenis_magang');
            $table->string('bidang_tujuan');
            $table->text('komentar')->nullable();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->date('tenggat')->nullable();
            $table->enum('status_pengajuan', ['waiting', 'reject-time', 'reject-days', 'reject-admin', 'reject-final', 'accept-first', 'accept-final'])->default('waiting');
            $table->string('surat_pengantar')->nullable();
            $table->timestamps();

            //data akademik peserta
            $table->string('institusi');
            $table->string('jurusan');
            $table->string('nomor_induk');

            //data pribadi peserta
            $table->string('foto_profil')->nullable();
            $table->string('name');
            $table->string('email');
            $table->string('nomor_hp');
            $table->string('tentang_saya')->length(500);
            $table->string('jenis_kelamin');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('alamat');

            $table->string('kartu_penduduk');
            $table->string('original_filename_ktp');
            $table->string('kartu_tanda');
            $table->string('original_filename_kartu');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            //data penanggung jawab
            $table->string('penanggung_jawab_name');
            $table->string('penanggung_jawab_jabatan');
            $table->string('penanggung_jawab_email');
            $table->string('penanggung_jawab_nomor_hp');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('magang', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('pengajuan_id')->unique();
            $table->foreign('pengajuan_id')->references('id')->on('pengajuan')->onDelete('cascade');
            $table->enum('status_magang', ['active', 'non-active'])->default('non-active');
            $table->string('user_id');
            $table->string('jenis_magang');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->string('bidang_tujuan');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->uuid('pembimbing_pertama');
            $table->foreign('pembimbing_pertama')->references('id')->on('pegawai')->onDelete('cascade');
            $table->uuid('pembimbing_kedua')->nullable();
            $table->foreign('pembimbing_kedua')->references('id')->on('pegawai')->onDelete('cascade');

            //selesai magang
            $table->string('laporan_magang')->nullable();
            $table->string('projek_magang')->nullable();

            //nilai magang
            $table->integer('nilai_magang')->default(0);

            $table->timestamps();
        });

        Schema::create('presensi', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('magang_id');
            $table->foreign('magang_id')->references('id')->on('magang')->onDelete('cascade');
            $table->uuid('pembimbing_id')->nullable();
            $table->foreign('pembimbing_id')->references('id')->on('pegawai')->onDelete('cascade');
            $table->date('tanggal');
            $table->integer('point_masuk')->default(0);
            $table->integer('point_keluar')->default(0);
            $table->integer('point')->default(0);
            $table->time('aturan_jam_masuk')->nullable();
            $table->time('aturan_jam_keluar')->nullable();
            $table->time('jam_masuk')->nullable();
            $table->time('jam_keluar')->nullable();
            $table->enum('status', ['waiting', 'hadir', 'tidak-hadir', 'izin'])->default('waiting');
            $table->string('foto_masuk')->nullable();
            $table->string('foto_keluar')->nullable();
            $table->text('keterangan_izin')->nullable();
            $table->string('lampiran')->nullable();
            $table->timestamps();
        });

        Schema::create('logbook', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('magang_id');
            $table->foreign('magang_id')->references('id')->on('magang')->onDelete('cascade');
            $table->uuid('pembimbing_id')->nullable();
            $table->foreign('pembimbing_id')->references('id')->on('pegawai')->onDelete('cascade');
            $table->date('tanggal');
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['waiting', 'mengisi', 'tidak-mengisi'])->default('waiting');
            $table->string('lampiran')->nullable();
            $table->string('komentar')->nullable();
            $table->timestamps();
        });

        Schema::create('feedback', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('magang_id')->unique();
            $table->foreign('magang_id')->references('id')->on('magang')->onDelete('cascade');
            
            // Kelompok Aplikasi
            $table->tinyInteger('aplikasi_daya_tarik')->unsigned(); // Attractiveness (1-5)
            $table->tinyInteger('aplikasi_kemudahan')->unsigned(); // Perspicuity (1-5)
            $table->tinyInteger('aplikasi_efisiensi')->unsigned(); // Efficiency (1-5)
            $table->tinyInteger('aplikasi_keandalan')->unsigned(); // Dependability (1-5)
            $table->tinyInteger('aplikasi_stimulasi')->unsigned(); // Stimulation (1-5)
            $table->tinyInteger('aplikasi_originalitas')->unsigned(); // Novelty (1-5)
            
            // Kelompok Magang 
            $table->tinyInteger('magang_fasilitas')->unsigned();
            $table->tinyInteger('magang_metode')->unsigned();
            $table->tinyInteger('magang_materi')->unsigned();
            $table->tinyInteger('magang_pembimbing')->unsigned();
            $table->tinyInteger('magang_relevansi')->unsigned();
            $table->tinyInteger('magang_kepuasan')->unsigned(); // Overall satisfaction
            
            // Kritik & Saran
            $table->text('testimoni');
            $table->text('kritik');
            $table->text('saran');
            
            $table->timestamps();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->uuid('user_id')->nullable()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->uuid('pegawai_id')->nullable()->index();
            $table->foreign('pegawai_id')->references('id')->on('pegawai')->onDelete('cascade');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        //autentikasi
        Schema::create('otps', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('email'); 
            $table->string('otp_code');
            $table->boolean('verified')->default(false);
            $table->timestamp('resend_time')->nullable();
            $table->json('registration_data')->nullable(); // Tambah kolom untuk data registrasi
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('presensi');
        Schema::dropIfExists('logbook');
        Schema::dropIfExists('magang');
        Schema::dropIfExists('pengajuan');
        Schema::dropIfExists('users');
        Schema::dropIfExists('otps');
        Schema::dropIfExists('pegawai');
        Schema::dropIfExists('password_reset_tokens');
    }
};
