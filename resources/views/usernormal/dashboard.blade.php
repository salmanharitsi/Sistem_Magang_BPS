@extends('layouts.app')

@section('title', 'User dashboard')

@section('content')
    @php
        use Carbon\Carbon;
        Carbon::setLocale('id');
    @endphp

    <div class="w-full h-44 rounded-lg bg-blue-500 relative overflow-hidden">
        <img class="absolute inset-0 w-full h-full object-cover" src="{{ asset('assets/images/usernormal/bg-dash.svg') }}"
            alt="">
        <p class="flex h-full w-full px-6 items-center justify-start text-white text-xl md:text-3xl font-normal">Selamat
            datang di<span class="font-medium ml-1 md:ml-2 z-10">SIMAGANG</span></p>
    </div>

    <!-- Quick Status Cards -->
    <div class="grid grid-cols-1 mt-6 lg:grid-cols-3 lg:gap-x-6 gap-x-0 gap-y-6">
        @php
            $latestPengajuan = Auth::user()->pengajuan()->latest('created_at')->first();
            $latestMagang = Auth::user()->magang()->latest('created_at')->first();
        @endphp

        @if (!is_null($latestPengajuan) && Auth::user()->status_magang === 'masa-daftar')
            @if ($latestPengajuan->status_pengajuan === 'accept-first')
                @if (is_null($latestPengajuan->surat_pengantar))
                    <div class="col-span-3 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
                        <div class="w-full h-fit flex gap-3 items-start lg:items-center p-3 bg-amber-100 rounded-lg border text-amber-700 border-amber-700">
                            <i class="ti ti-alert-circle text-lg"></i>
                            <p class="text-sm">Segera kirim surat pengantar dari sekolah atau universitas, tenggat <span class="font-bold">{{ Carbon::parse($latestPengajuan->tenggat)->translatedFormat('j F Y') }}</span></p>
                        </div>
                    </div>
                @else
                    <div class="col-span-3 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
                        <div class="w-full h-fit flex gap-3 items-start lg:items-center p-3 bg-amber-100 rounded-lg border text-amber-700 border-amber-700">
                            <i class="ti ti-alert-circle text-lg"></i>
                            <p class="text-sm">Surat pengantar sedang dalam proses pengecekan</p>
                        </div>
                    </div>
                @endif
            @elseif (in_array($latestPengajuan->status_pengajuan, ['reject-time', 'reject-admin', 'reject-final', 'reject-days']))
                <div class="col-span-3 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
                    <div class="w-full h-fit flex gap-3 items-start lg:items-center p-3 bg-red-100 rounded-lg border text-red-700 border-red-700">
                        <i class="ti ti-alert-triangle text-lg"></i>
                        <p class="text-sm">
                            @if($latestPengajuan->status_pengajuan === 'reject-time')
                                Admin menolak pengajuan kamu karena melewati tenggat upload surat pengantar!
                            @elseif($latestPengajuan->status_pengajuan === 'reject-days')
                                Masa pendaftaran melewati tanggal mulai magang, silahkan ajukan kembali
                            @else
                                Baca pesan penolakan pada <span class="font-semibold underline"><a href="/pengajuan" class="pjax-link">detail pengajuan</a></span>
                            @endif
                        </p>
                    </div>
                </div>
            @elseif ($latestPengajuan->status_pengajuan === 'waiting')
                <div class="col-span-3 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
                    <div class="w-full h-fit flex gap-3 items-start lg:items-center p-3 bg-green-100 rounded-lg border text-green-700 border-green-700">
                        <i class="ti ti-circle-check text-lg"></i>
                        <p class="text-sm">Pengajuan magang kamu sudah terkirim dan sedang diproses</p>
                    </div>
                </div>
            @endif
        @elseif (is_null($latestPengajuan) || Auth::user()->status_magang === 'tidak-aktif')
            <div class="col-span-3 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
                <div class="w-full h-fit flex gap-3 items-start lg:items-center p-3 bg-amber-100 rounded-lg border text-amber-700 border-amber-700">
                    <i class="ti ti-alert-circle text-lg"></i>
                    <p class="text-sm">Kamu belum terdaftar program magang</p>
                </div>
            </div>
        @endif
    </div>

    <!-- Timeline Pendaftaran - PERBAIKAN KONDISI -->
    @php
        $showRegistrationTimeline = false;
        
        // Tampilkan timeline jika:
        // 1. Belum ada pengajuan sama sekali
        // 2. User sedang dalam masa daftar
        // 3. User tidak aktif tapi pernah magang (untuk daftar lagi)
        
        if (is_null($latestPengajuan)) {
            $showRegistrationTimeline = true;
        } elseif (Auth::user()->status_magang === 'masa-daftar') {
            $showRegistrationTimeline = true;
        } elseif (Auth::user()->status_magang === 'tidak-aktif') {
            $showRegistrationTimeline = true;
        }
        
        // Jangan tampilkan jika user sedang aktif magang
        if (Auth::user()->status_magang === 'aktif') {
            $showRegistrationTimeline = false;
        }
    @endphp

    @if($showRegistrationTimeline)
    <div class="mt-6">
        <div class="card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
            <ol class="flex items-center w-full px-[5%] md:px-[15%]">
                <li class="step1-active flex w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-100 after:bg-gray-100 after:inline-block">
                    <span class="flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full lg:h-12 lg:w-12 shrink-0" data-tooltip-target="tooltip-profil">
                        <i class="ti ti-user text-2xl text-gray-500 "></i>
                    </span>
                    <div id="tooltip-profil" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-regular text-gray-600 transition-opacity duration-300 bg-white rounded-lg shadow-lg opacity-0 tooltip dark:bg-gray-700">
                        Melengkapi Profil
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                </li>
                <li class="step2-active flex w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-100 after:bg-gray-100 after:inline-block">
                    <span class="flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full lg:h-12 lg:w-12 shrink-0" data-tooltip-target="tooltip-pengajuan">
                        <i class="ti ti-clipboard-text text-2xl text-gray-500"></i>
                    </span>
                    <div id="tooltip-pengajuan" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-regular text-gray-600 transition-opacity duration-300 bg-white rounded-lg shadow-lg opacity-0 tooltip dark:bg-gray-700">
                        Mengajukan Program Magang
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                </li>
                <li class="step3-active flex w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-100 after:bg-gray-100 after:inline-block">
                    <span class="flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full lg:h-12 lg:w-12 shrink-0" data-tooltip-target="tooltip-diterima">
                        <i class="ti ti-clipboard-check text-2xl text-gray-500"></i>
                    </span>
                    <div id="tooltip-diterima" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-regular text-gray-600 transition-opacity duration-300 bg-white rounded-lg shadow-lg opacity-0 tooltip dark:bg-gray-700">
                        Lolos Seleksi Program
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                </li>
                <li class="step4-active flex items-center w-fit">
                    <span class="flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full lg:h-12 lg:w-12 shrink-0" data-tooltip-target="tooltip-surat-pengantar">
                        <i class="ti ti-file-info text-2xl text-gray-500"></i>
                    </span>
                    <div id="tooltip-surat-pengantar" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-regular text-gray-600 transition-opacity duration-300 bg-white rounded-lg shadow-lg opacity-0 tooltip dark:bg-gray-700">
                        Mengupload Surat Pengantar
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                </li>
            </ol>
        </div>
    </div>
    @endif

    <!-- Progress Overview - Hidden when status is accept-final -->
    @if($showRegistrationTimeline)
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
            <div class="card rounded-lg bg-white p-5 dark:bg-[#14181b] transition-all duration-200">
                <h3 class="text-lg font-semibold mb-4">Progress Tahapan</h3>
                <div class="space-y-3">
                    @php
                        $user = Auth::user();
                        $step1_completed = $user->foto_profil != null && $user->tentang_saya != null && 
                                        $user->jenis_kelamin != null && $user->tempat_lahir != null && 
                                        $user->tanggal_lahir != null && $user->alamat != null;
                        
                        $step2_completed = $user->pengajuan()->exists() && $user->status_magang == 'masa-daftar';
                        
                        $step3_completed = !is_null($latestPengajuan) && 
                                        ($latestPengajuan->status_pengajuan === 'accept-first' || 
                                        $latestPengajuan->status_pengajuan === 'reject-final') && 
                                        $user->status_magang == 'masa-daftar';
                        
                        $step4_completed = !is_null($latestPengajuan) && 
                                        !is_null($latestPengajuan->surat_pengantar) && 
                                        $latestPengajuan->status_pengajuan !== 'reject-days' && 
                                        $user->status_magang == 'masa-daftar';
                    @endphp
                    
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full {{ $step1_completed ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center">
                            <i class="ti {{ $step1_completed ? 'ti-check text-white' : 'ti-user text-gray-500' }}"></i>
                        </div>
                        <span class="{{ $step1_completed ? 'text-green-600' : 'text-gray-500' }}">Lengkapi Profil</span>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full {{ $step2_completed ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center">
                            <i class="ti {{ $step2_completed ? 'ti-check text-white' : 'ti-clipboard-text text-gray-500' }}"></i>
                        </div>
                        <span class="{{ $step2_completed ? 'text-green-600' : 'text-gray-500' }}">Ajukan Program Magang</span>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full {{ $step3_completed ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center">
                            <i class="ti {{ $step3_completed ? 'ti-check text-white' : 'ti-clipboard-check text-gray-500' }}"></i>
                        </div>
                        <span class="{{ $step3_completed ? 'text-green-600' : 'text-gray-500' }}">Lolos Seleksi Program</span>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full {{ $step4_completed ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center">
                            <i class="ti {{ $step4_completed ? 'ti-check text-white' : 'ti-file-info text-gray-500' }}"></i>
                        </div>
                        <span class="{{ $step4_completed ? 'text-green-600' : 'text-gray-500' }}">Upload Surat Pengantar</span>
                    </div>
                </div>
            </div>

            <div class="card rounded-lg bg-white p-5 dark:bg-[#14181b] transition-all duration-200">
                <h3 class="text-lg font-semibold mb-4">Akses Cepat</h3>
                <div class="space-y-3">
                    <a href="/profil-edit?selected=biodata" class="pjax-link block p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-all duration-200">
                        <div class="flex items-center gap-3">
                            <i class="ti ti-user text-blue-600"></i>
                            <div>
                                <p class="font-medium text-gray-800">Lengkapi Profil</p>
                                <p class="text-sm text-gray-600">Isi data pribadi dan dokumen</p>
                            </div>
                        </div>
                    </a>

                    @if($step1_completed)
                    <a href="/dashboard/ajukan-program" class="pjax-link block p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-all duration-200">
                        <div class="flex items-center gap-3">
                            <i class="ti ti-clipboard-text text-green-600"></i>
                            <div>
                                <p class="font-medium text-gray-800">Ajukan Program Magang</p>
                                <p class="text-sm text-gray-600">Daftar program magang yang tersedia</p>
                            </div>
                        </div>
                    </a>
                    @endif

                    @if($step2_completed)
                    <a href="/dashboard/lolos-seleksi" class="pjax-link block p-3 bg-amber-50 rounded-lg hover:bg-amber-100 transition-all duration-200">
                        <div class="flex items-center gap-3">
                            <i class="ti ti-clipboard-check text-amber-600"></i>
                            <div>
                                <p class="font-medium text-gray-800">Hasil Seleksi</p>
                                <p class="text-sm text-gray-600">Cek status pengajuan magang</p>
                            </div>
                        </div>
                    </a>
                    @endif

                    @if($step3_completed)
                    <a href="/dashboard/upload-surat" class="pjax-link block p-3 bg-purple-50 rounded-lg hover:bg-purple-100 transition-all duration-200">
                        <div class="flex items-center gap-3">
                            <i class="ti ti-file-info text-purple-600"></i>
                            <div>
                                <p class="font-medium text-gray-800">Upload Surat Pengantar</p>
                                <p class="text-sm text-gray-600">Upload dokumen surat pengantar</p>
                            </div>
                        </div>
                    </a>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <!-- Timeline Magang Aktif -->
    @if (!is_null($latestMagang) && Carbon::parse($latestMagang->tanggal_mulai)->isPast() && Auth::user()->status_magang === 'aktif')
        <div class="">
            <div class="card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
                <ol class="flex items-center w-full px-[5%] md:px-[15%]">
                    <li class="intern-step1 flex w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-100 after:bg-gray-100 after:inline-block">
                        <span class="flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full lg:h-12 lg:w-12 shrink-0" data-tooltip-target="tooltip-orientasi">
                            <i class="ti ti-flag text-2xl text-gray-500"></i>
                        </span>
                        <div id="tooltip-orientasi" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-regular text-gray-600 transition-opacity duration-300 bg-white rounded-lg shadow-lg opacity-0 tooltip dark:bg-gray-700">
                            Mulai Magang
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                    </li>
                    <li class="intern-step2 flex w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-100 after:bg-gray-100 after:inline-block">
                        <span class="flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full lg:h-12 lg:w-12 shrink-0" data-tooltip-target="tooltip-project">
                            <i class="ti ti-briefcase text-2xl text-gray-500"></i>
                        </span>
                        <div id="tooltip-project" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-regular text-gray-600 transition-opacity duration-300 bg-white rounded-lg shadow-lg opacity-0 tooltip dark:bg-gray-700">
                            Mengumpulkan Laporan Akhir
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                    </li>
                    <li class="intern-step3 flex w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-100 after:bg-gray-100 after:inline-block">
                        <span class="flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full lg:h-12 lg:w-12 shrink-0" data-tooltip-target="tooltip-feedback">
                            <i class="ti ti-calendar-stats text-2xl text-gray-500"></i>
                        </span>
                        <div id="tooltip-feedback" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-regular text-gray-600 transition-opacity duration-300 bg-white rounded-lg shadow-lg opacity-0 tooltip dark:bg-gray-700">
                            Mengisi Feedback
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                    </li>
                    <li class="intern-step4 flex items-center w-fit">
                        <span class="flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full lg:h-12 lg:w-12 shrink-0" data-tooltip-target="tooltip-sertifikat">
                            <i class="ti ti-certificate text-2xl text-gray-500"></i>
                        </span>
                        <div id="tooltip-sertifikat" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-regular text-gray-600 transition-opacity duration-300 bg-white rounded-lg shadow-lg opacity-0 tooltip dark:bg-gray-700">
                            Menerima Sertifikat
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                    </li>
                </ol>
            </div>
        </div>
    @endif

    <!-- Magang Activity Section (if active) -->
    @if (Auth::user()->status_magang === 'aktif' && !is_null($latestMagang))
        @if (Carbon::parse($latestMagang->tanggal_mulai)->isFuture())
            <div class="">
                <div class="card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
                    <div class="w-full h-fit flex gap-3 items-start lg:items-center p-3 bg-blue-100 rounded-lg border text-blue-700 border-blue-700">
                        <i class="ti ti-calendar-time text-lg"></i>
                        <p class="text-sm">Magang kamu akan dimulai pada <span class="font-bold">{{ Carbon::parse($latestMagang->tanggal_mulai)->translatedFormat('j F Y') }}</span></p>
                    </div>
                </div>
            </div>

            <!-- Informasi Magang Section -->
            <div class="col-span-3 grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <!-- Header Informasi -->
                <div class="col-span-2 card rounded-lg bg-white p-5 dark:bg-[#14181b] transition-all duration-200">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                            <i class="ti ti-info-circle text-white text-xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Informasi Penting Magang</h3>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-300">Bacalah informasi berikut dengan teliti untuk mempersiapkan diri sebelum magang dimulai</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 col-span-2">
                    <!-- Dress Code -->
                    <div class="card rounded-lg bg-white p-5 dark:bg-[#14181b] transition-all duration-200">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                                <i class="ti ti-shirt text-green-600 text-lg"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-800 dark:text-white mb-2">Cara Berpakaian</h4>
                                <div class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                                    <div class="flex items-center gap-2">
                                        <div class="w-1 h-1 bg-green-500 rounded-full"></div>
                                        <span>Gunakan pakaian formal atau semi-formal</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-1 h-1 bg-green-500 rounded-full"></div>
                                        <span>Hindari pakaian terlalu ketat atau terbuka</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-1 h-1 bg-green-500 rounded-full"></div>
                                        <span>Warna netral: hitam, navy, abu-abu, putih</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <!-- Jam Kerja -->
                    <div class="card rounded-lg bg-white p-5 dark:bg-[#14181b] transition-all duration-200">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                                <i class="ti ti-clock text-orange-600 text-lg"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-800 dark:text-white mb-2">Jam Kerja</h4>
                                <div class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                                    <div class="flex items-center gap-2">
                                        <div class="w-1 h-1 bg-orange-500 rounded-full"></div>
                                        <span>Senin - Kamis: 07:00 - 16:00</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-1 h-1 bg-orange-500 rounded-full"></div>
                                        <span>Jumat: 07:30 - 16:30</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-1 h-1 bg-orange-500 rounded-full"></div>
                                        <span>Istirahat: 12:00 - 13:00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <!-- Persiapan Dokumen -->
                    <div class="card rounded-lg bg-white p-5 dark:bg-[#14181b] transition-all duration-200">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                                <i class="ti ti-file-description text-purple-600 text-lg"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-800 dark:text-white mb-2">Dokumen yang Dibawa</h4>
                                <div class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                                    <div class="flex items-center gap-2">
                                        <div class="w-1 h-1 bg-purple-500 rounded-full"></div>
                                        <span>KTP/Kartu Identitas</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-1 h-1 bg-purple-500 rounded-full"></div>
                                        <span>Surat pengantar dari sekolah/kampus</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-1 h-1 bg-purple-500 rounded-full"></div>
                                        <span>Alat tulis dan laptop (jika ada)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <!-- Etika dan Sikap -->
                    <div class="card rounded-lg bg-white p-5 dark:bg-[#14181b] transition-all duration-200">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                                <i class="ti ti-users text-blue-600 text-lg"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-800 dark:text-white mb-2">Etika Kerja</h4>
                                <div class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                                    <div class="flex items-center gap-2">
                                        <div class="w-1 h-1 bg-blue-500 rounded-full"></div>
                                        <span>Datang tepat waktu</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-1 h-1 bg-blue-500 rounded-full"></div>
                                        <span>Bersikap sopan dan ramah</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-1 h-1 bg-blue-500 rounded-full"></div>
                                        <span>Aktif bertanya dan belajar</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tips Sukses -->
                <div class="col-span-2 card rounded-lg bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-gray-800 dark:to-gray-700 p-5 border border-emerald-200 dark:border-gray-600">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="ti ti-bulb text-white text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-800 dark:text-white mb-3">Tips Sukses Magang</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="bg-white dark:bg-gray-700 p-3 rounded-lg border border-gray-200 dark:border-gray-600 text-center">
                                    <i class="ti ti-target text-2xl text-emerald-500 mb-2"></i>
                                    <p class="text-xs font-medium text-gray-700 dark:text-gray-300">Tetapkan tujuan yang jelas</p>
                                </div>
                                <div class="bg-white dark:bg-gray-700 p-3 rounded-lg border border-gray-200 dark:border-gray-600 text-center">
                                    <i class="ti ti-network text-2xl text-teal-500 mb-2"></i>
                                    <p class="text-xs font-medium text-gray-700 dark:text-gray-300">Bangun networking yang baik</p>
                                </div>
                                <div class="bg-white dark:bg-gray-700 p-3 rounded-lg border border-gray-200 dark:border-gray-600 text-center">
                                    <i class="ti ti-book text-2xl text-blue-500 mb-2"></i>
                                    <p class="text-xs font-medium text-gray-700 dark:text-gray-300">Catat setiap pembelajaran</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif (Carbon::parse($latestMagang->tanggal_mulai)->isPast() && Carbon::parse($latestMagang->tanggal_selesai)->addDays(1)->isFuture())
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div class="col-span-2 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
                    <div class="w-full h-fit p-3 flex flex-col md:flex-row items-start gap-3 md:items-center justify-between bg-blue-100 rounded-lg border text-blue-700 border-blue-700">
                        <div class="flex gap-3 items-start lg:items-center">
                            <i class="ti ti-browser text-lg"></i>
                            <p class="text-sm">Kamu terdaftar magang <span class="font-semibold">{{ $latestMagang->jenis_magang }}</span></p>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 col-span-2">
                    <div class="col-span-1">
                        @livewire('show-grafik-presensi')
                    </div>
                    <div class="col-span-1">
                        @livewire('show-grafik-logbook')
                    </div>
                </div>
                <div class="col-span-2 card bg-white dark:bg-gray-800 relative rounded-lg overflow-hidden">
                    <div class="text-xl font-semibold text-gray-900 dark:text-white pt-5 pb-4 px-4 border-b border-gray-200">Riwayat
                        Presensi</div>
                    @livewire('show-daftar-presensi')
                </div>
                <div class="col-span-2 card bg-white dark:bg-gray-800 relative rounded-lg overflow-hidden">
                    <div class="text-xl font-semibold text-gray-900 dark:text-white pt-5 pb-4 px-4 border-b border-gray-200">Riwayat
                        Logbook</div>
                    @livewire('show-daftar-logbook')
                </div>
            </div>
        @endif
    @endif

    <!-- Setelah Magang Selesai - Upload Laporan Akhir -->
    @if (Auth::user()->status_magang === 'aktif' && !is_null($latestMagang) && Carbon::parse($latestMagang->tanggal_selesai)->addDays(1)->isPast() && !$latestMagang->laporan_magang)
        <div class="col-span-3 grid grid-cols-1 gap-6 mt-6">
            <div class="col-span-3 card rounded-lg bg-white p-5">
                <div class="w-full h-fit p-3 flex flex-col md:flex-row items-start gap-3 md:items-center justify-between bg-blue-100 rounded-lg border text-blue-700 border-blue-700">
                    <div class="flex gap-3 items-start lg:items-center">
                        <i class="ti ti-sparkles text-lg"></i>
                        <p class="text-sm">Upload projek magang jika kamu memiliki projek yang dikerjakan selama magang</p>
                    </div>
                </div>
            </div>
            <div class="col-span-3 card rounded-lg bg-white p-5">
                <div class="w-full h-fit p-3 flex flex-col md:flex-row items-start gap-3 md:items-center justify-between bg-red-100 rounded-lg border text-red-700 border-red-700">
                    <div class="flex gap-3 items-start lg:items-center">
                        <i class="ti ti-alert-triangle text-lg"></i>
                        <p class="text-sm">Pastikan link yang di submit dapat diakses</p>
                    </div>
                </div>
            </div>
            <div class="col-span-3 card rounded-lg mt-0 bg-white p-5 h-fit dark:bg-[#14181b] transition-all duration-200">
                @livewire('upload-laporan-akhir', ['magangId' => $latestMagang->id])
            </div>
        </div>
    @endif

    <!-- Setelah Laporan Diupload - Form Feedback -->
    @if (Auth::user()->status_magang === 'aktif' && !is_null($latestMagang) && Carbon::parse($latestMagang->tanggal_selesai)->addDays(1)->isPast() && $latestMagang->laporan_magang && !$latestMagang->feedback)
        <div class="col-span-3 grid grid-cols-1 gap-6 mt-6">
            <div class="col-span-3 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
                <div class="w-full h-fit p-3 flex flex-col md:flex-row items-start gap-3 md:items-center justify-between bg-blue-100 rounded-lg border text-blue-700 border-blue-700">
                    <div class="flex gap-3 items-start lg:items-center">
                        <i class="ti ti-browser text-lg"></i>
                        <p class="text-sm">Kamu telah selesai magang <span class="font-semibold">{{ $latestMagang->jenis_magang }}</span></p>
                    </div>
                </div>
            </div>
            <div class="col-span-3 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
                <div class="w-full h-fit flex flex-col md:flex-row items-start gap-3 md:items-center justify-between rounded-lg">
                    <div class="flex gap-3 items-start lg:items-center">
                        <h4 class="text-gray-900 font-semibold text-2xl dark:text-white">
                            Form Feedback Pengalaman Magang
                        </h4>
                    </div>
                </div>
            </div>
            <div class="col-span-3 relative rounded-lg overflow-hidden">
                @livewire('feedback-form', ['magangId' => $latestMagang->id])
            </div>
        </div>
    @endif

    <!-- Setelah Feedback - Tunggu Nilai dan Sertifikat -->
    @if (Auth::user()->status_magang === 'aktif' && !is_null($latestMagang) && Carbon::parse($latestMagang->tanggal_selesai)->addDays(1)->isPast() && $latestMagang->feedback && !$latestMagang->nilai_magang && (!$latestMagang->sertifikat_magang || $latestMagang->status_final === 'waiting' ) && $latestMagang->laporan_magang)
        <div class="col-span-3 card rounded-lg bg-white p-5 mt-6">
            <div class="w-full h-fit p-3 flex flex-col md:flex-row items-start gap-3 md:items-center justify-between bg-blue-100 rounded-lg border text-blue-700 border-blue-700">
                <div class="flex gap-3 items-start lg:items-center">
                    <i class="ti ti-sparkles text-lg"></i>
                    <p class="text-sm">Tunggu pembimbing memberikan nilai magang</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Nilai belumm final -->
    @if (Auth::user()->status_magang === 'aktif' && !is_null($latestMagang) && Carbon::parse($latestMagang->tanggal_selesai)->addDays(1)->isPast() && $latestMagang->feedback && $latestMagang->nilai_magang && (!$latestMagang->sertifikat_magang || $latestMagang->status_final === 'waiting' ) && $latestMagang->laporan_magang && $latestMagang->status_final !== 'final')
        <div class="col-span-3 grid grid-cols-1 gap-6 mt-6">
            
            {{-- Card Message --}}
            <div class="card rounded-lg bg-white p-5">
                <div class="w-full h-fit p-3 flex flex-col md:flex-row items-start gap-3 md:items-center justify-between bg-amber-100 rounded-lg border text-amber-700 border-amber-700">
                    <div class="flex gap-3 items-start lg:items-center">
                        <i class="ti ti-alert-circle text-lg"></i>
                        <p class="text-sm">Apabila ada komplain atau pertanyaan terkait nilai, silakan hubungi pembimbing sebelum proses finalisasi.</p>
                    </div>
                </div>
            </div>

            {{-- Card Nilai Magang --}}
            <div class="relative w-full h-fit flex gap-3 items-center justify-between p-5 bg-blue-100 rounded-lg text-blue-700 overflow-hidden hover:shadow-md transition-all duration-300">
                <div class="flex flex-col gap-3 items-start">
                    <p class="text-2xl font-medium italic">Nilai Magang Kamu</p>
                </div>
                <div class="px-4 z-20">
                    <p class="text-4xl font-bold">{{ $latestMagang->nilai_magang }}</p>
                </div>
                <i class="ti ti-sparkles text-[80px] absolute -bottom-5 -right-1 text-blue-300 z-10"></i>
            </div>

            <div class="">
                @livewire('nilai-sertifikat', ['magang' => $latestMagang])
            </div>
        </div>
    @endif

    <!-- Nilai sudah final -->
    @if (Auth::user()->status_magang === 'aktif' && !is_null($latestMagang) && Carbon::parse($latestMagang->tanggal_selesai)->addDays(1)->isPast() && $latestMagang->feedback && $latestMagang->nilai_magang && (!$latestMagang->sertifikat_magang || $latestMagang->status_final === 'waiting' ) && $latestMagang->laporan_magang && $latestMagang->status_final === 'final')
        <div class="col-span-3 card rounded-lg bg-white p-5 mt-6">
            <div class="w-full h-fit p-3 flex flex-col md:flex-row items-start gap-3 md:items-center justify-between bg-blue-100 rounded-lg border text-blue-700 border-blue-700">
                <div class="flex gap-3 items-start lg:items-center">
                    <i class="ti ti-sparkles text-lg"></i>
                    <p class="text-sm">Nilai sudah final, silahkan tunggu pemberian sertifikat.</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Setelah Dapat Nilai dan Sertifikat -->
    @if (Auth::user()->status_magang === 'aktif' && !is_null($latestMagang) && Carbon::parse($latestMagang->tanggal_selesai)->addDays(1)->isPast() && $latestMagang->feedback && $latestMagang->nilai_magang && $latestMagang->sertifikat_magang)
        <div class="col-span-3 grid grid-cols-1 gap-6 mt-6">
            <div class="card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
                <div class="w-full h-fit p-3 flex flex-col md:flex-row items-start gap-3 md:items-center justify-between bg-amber-100 rounded-lg border text-amber-700 border-amber-700">
                    <div class="flex gap-3 items-start lg:items-center">
                        <i class="ti ti-alert-circle text-lg"></i>
                        <p class="text-sm">Ingin mengajukan program magang lagi?</p>
                    </div>
                    <form action="{{ route('usernormal.ajukan-magang') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="pjax-link bg-amber-600 ml-7 md:ml-0 border border-transparent px-3 py-1 rounded-lg text-white hover:bg-amber-100 hover:border hover:border-amber-600 hover:text-amber-600 transition-all duration-200">
                            <p class="text-sm whitespace-nowrap">Ajukan Program</p>
                        </button>
                    </form>
                </div>
            </div>  

            <div class="card rounded-lg bg-white p-5">
                <div class="w-full h-fit p-3 flex flex-col md:flex-row items-start gap-3 md:items-center justify-between bg-blue-100 rounded-lg border text-blue-700 border-blue-700">
                    <div class="flex gap-3 items-start lg:items-center">
                        <i class="ti ti-sparkles text-lg"></i>
                        <p class="text-sm">Nilai dan sertifikat magang kamu sudah diberikan</p>
                    </div>
                </div>
            </div>

            <div class="relative w-full h-fit flex gap-3 items-center justify-between p-5 bg-blue-100 rounded-lg text-blue-700 overflow-hidden hover:shadow-md transition-all duration-300">
                <div class="flex flex-col gap-3 items-start">
                    <p class="text-2xl font-medium italic">Nilai & Sertifikat Magang Kamu</p>
                    <a href="/nilai-sertifikat/{{ $latestMagang->id }}"
                        class="pjax-link bg-blue-600 border border-transparent px-3 py-1 rounded-md text-white hover:bg-blue-100 hover:border hover:border-blue-600 hover:text-blue-600 transition-all duration-200">
                        <p class="text-xs whitespace-nowrap">
                            Lihat Nilai & Sertifikat
                        </p>
                    </a>
                </div>
                <div class="px-4 z-20">
                    <p class="text-4xl font-bold">{{ $latestMagang->nilai_magang }}</p>
                </div>
                <i class="ti ti-sparkles text-[80px] absolute -bottom-5 -right-1 text-blue-300 z-10"></i>
            </div>
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            //daftar step
            @if (Auth::user()->tentang_saya != null &&
                    Auth::user()->jenis_kelamin != null &&
                    Auth::user()->tempat_lahir != null &&
                    Auth::user()->tanggal_lahir != null &&
                    Auth::user()->alamat != null)
                var step1 = document.querySelector('.step1-active');
                if (step1) {
                    var span = step1.querySelector('span');
                    var div = step1.querySelector('#tooltip-profil');
                    if (span) {
                        span.classList.remove('bg-gray-100');
                        span.classList.add('bg-blue-600');
                        div.classList.remove('bg-white');
                        div.classList.add('bg-blue-600');
                        div.classList.remove('text-gray-600');
                        div.classList.add('text-white');
                    }
                    var icon = step1.querySelector('i');
                    if (icon) {
                        icon.classList.remove('text-gray-500');
                        icon.classList.add('text-white');
                    }
                }
            @endif
            @if (Auth::user()->pengajuan()->exists() && Auth::user()->status_magang == 'masa-daftar')
                var step1 = document.querySelector('.step1-active');
                var step2 = document.querySelector('.step2-active');
                if (step1) {
                    step1.classList.remove('after:border-gray-100', 'after:bg-gray-100');
                    step1.classList.add('after:border-blue-600', 'after:bg-blue-600');
                    var span = step1.querySelector('span');
                    var div = step1.querySelector('#tooltip-profil');
                    if (span) {
                        span.classList.remove('bg-gray-100');
                        span.classList.add('bg-blue-600');
                        div.classList.remove('bg-white');
                        div.classList.add('bg-blue-600');
                        div.classList.remove('text-gray-600');
                        div.classList.add('text-white');
                    }
                    var icon = step1.querySelector('i');
                    if (icon) {
                        icon.classList.remove('text-gray-500');
                        icon.classList.add('text-white');
                    }
                }
                if (step2) {
                    var span = step2.querySelector('span');
                    var div = step2.querySelector('#tooltip-pengajuan');
                    if (span) {
                        span.classList.remove('bg-gray-100');
                        span.classList.add('bg-blue-600');
                        div.classList.remove('bg-white');
                        div.classList.add('bg-blue-600');
                        div.classList.remove('text-gray-600');
                        div.classList.add('text-white');
                    }
                    var icon = step2.querySelector('i');
                    if (icon) {
                        icon.classList.remove('text-gray-500');
                        icon.classList.add('text-white');
                    }
                }
            @endif
            @if (!is_null($latestPengajuan) && ($latestPengajuan->status_pengajuan === 'accept-first' || $latestPengajuan->status_pengajuan === 'reject-final') && Auth::user()->status_magang == 'masa-daftar')
                var step2 = document.querySelector('.step2-active');
                var step3 = document.querySelector('.step3-active');
                if (step2) {
                    step2.classList.remove('after:border-gray-100', 'after:bg-gray-100');
                    step2.classList.add('after:border-blue-600', 'after:bg-blue-600');
                    var span = step2.querySelector('span');
                    var div = step2.querySelector('#tooltip-pengajuan');
                    if (span) {
                        span.classList.remove('bg-gray-100');
                        span.classList.add('bg-blue-600');
                        div.classList.remove('bg-white');
                        div.classList.add('bg-blue-600');
                        div.classList.remove('text-gray-600');
                        div.classList.add('text-white');
                    }
                    var icon = step2.querySelector('i');
                    if (icon) {
                        icon.classList.remove('text-gray-500');
                        icon.classList.add('text-white');
                    }
                }
                if (step3) {
                    var span = step3.querySelector('span');
                    var div = step3.querySelector('#tooltip-diterima');
                    if (span) {
                        span.classList.remove('bg-gray-100');
                        span.classList.add('bg-blue-600');
                        div.classList.remove('bg-white');
                        div.classList.add('bg-blue-600');
                        div.classList.remove('text-gray-600');
                        div.classList.add('text-white');
                    }
                    var icon = step3.querySelector('i');
                    if (icon) {
                        icon.classList.remove('text-gray-500');
                        icon.classList.add('text-white');
                    }
                }
            @endif
            @if(!is_null($latestPengajuan) && !is_null($latestPengajuan->surat_pengantar) && $latestPengajuan->status_pengajuan !== 'reject-days' && Auth::user()->status_magang == 'masa-daftar')
                var step3 = document.querySelector('.step3-active');
                var step4 = document.querySelector('.step4-active');
                if (step3) {
                    step3.classList.remove('after:border-gray-100', 'after:bg-gray-100');
                    step3.classList.add('after:border-blue-600', 'after:bg-blue-600');
                    var span = step3.querySelector('span');
                    var div = step3.querySelector('#tooltip-diterima');
                    if (span) {
                        span.classList.remove('bg-gray-100');
                        span.classList.add('bg-blue-600');
                        div.classList.remove('bg-white');
                        div.classList.add('bg-blue-600');
                        div.classList.remove('text-gray-600');
                        div.classList.add('text-white');
                    }
                    var icon = step3.querySelector('i');
                    if (icon) {
                        icon.classList.remove('text-gray-500');
                        icon.classList.add('text-white');
                    }
                }
                if (step4) {
                    var span = step4.querySelector('span');
                    var div = step4.querySelector('#tooltip-surat-pengantar');
                    if (span) {
                        span.classList.remove('bg-gray-100');
                        span.classList.add('bg-blue-600');
                        div.classList.remove('bg-white');
                        div.classList.add('bg-blue-600');
                        div.classList.remove('text-gray-600');
                        div.classList.add('text-white');
                    }
                    var icon = step4.querySelector('i');
                    if (icon) {
                        icon.classList.remove('text-gray-500');
                        icon.classList.add('text-white');
                    }
                }
            @endif
            //intern step
            @if (!is_null($latestMagang) && $latestMagang->status_magang == 'active'){
                var step1 = document.querySelector('.intern-step1');
                if (step1) {
                    var span = step1.querySelector('span');
                    var div = step1.querySelector('#tooltip-orientasi');
                    if (span) {
                        span.classList.remove('bg-gray-100');
                        span.classList.add('bg-blue-600');
                        div.classList.remove('bg-white');
                        div.classList.add('bg-blue-600');
                        div.classList.remove('text-gray-600');
                        div.classList.add('text-white');
                    }
                    var icon = step1.querySelector('i');
                    if (icon) {
                        icon.classList.remove('text-gray-500');
                        icon.classList.add('text-white');
                    }
                }
            }
            @endif
            @if (!is_null($latestMagang) && $latestMagang->status_magang == 'active' && $latestMagang->laporan_magang){
                var step1 = document.querySelector('.intern-step1');
                var step2 = document.querySelector('.intern-step2');
                if (step1) {
                    step1.classList.remove('after:border-gray-100', 'after:bg-gray-100');
                    step1.classList.add('after:border-blue-600', 'after:bg-blue-600');
                    var span = step1.querySelector('span');
                    var div = step1.querySelector('#tooltip-orientasi');
                    if (span) {
                        span.classList.remove('bg-gray-100');
                        span.classList.add('bg-blue-600');
                        div.classList.remove('bg-white');
                        div.classList.add('bg-blue-600');
                        div.classList.remove('text-gray-600');
                        div.classList.add('text-white');
                    }
                    var icon = step1.querySelector('i');
                    if (icon) {
                        icon.classList.remove('text-gray-500');
                        icon.classList.add('text-white');
                    }
                }
                if (step2) {
                    var span = step2.querySelector('span');
                    var div = step2.querySelector('#tooltip-project');
                    if (span) {
                        span.classList.remove('bg-gray-100');
                        span.classList.add('bg-blue-600');
                        div.classList.remove('bg-white');
                        div.classList.add('bg-blue-600');
                        div.classList.remove('text-gray-600');
                        div.classList.add('text-white');
                    }
                    var icon = step2.querySelector('i');
                    if (icon) {
                        icon.classList.remove('text-gray-500');
                        icon.classList.add('text-white');
                    }
                }
            }
            @endif
            @if (!is_null($latestMagang) && $latestMagang->status_magang == 'active' && $latestMagang->laporan_magang && $latestMagang->feedback)
                var step2 = document.querySelector('.intern-step2');
                var step3 = document.querySelector('.intern-step3');
                if (step2) {
                    step2.classList.remove('after:border-gray-100', 'after:bg-gray-100');
                    step2.classList.add('after:border-blue-600', 'after:bg-blue-600');
                    var span = step2.querySelector('span');
                    var div = step2.querySelector('#tooltip-project');
                    if (span) {
                        span.classList.remove('bg-gray-100');
                        span.classList.add('bg-blue-600');
                        div.classList.remove('bg-white');
                        div.classList.add('bg-blue-600');
                        div.classList.remove('text-gray-600');
                        div.classList.add('text-white');
                    }
                    var icon = step2.querySelector('i');
                    if (icon) {
                        icon.classList.remove('text-gray-500');
                        icon.classList.add('text-white');
                    }
                }
                if (step3) {
                    var span = step3.querySelector('span');
                    var div = step3.querySelector('#tooltip-feedback');
                    if (span) {
                        span.classList.remove('bg-gray-100');
                        span.classList.add('bg-blue-600');
                        div.classList.remove('bg-white');
                        div.classList.add('bg-blue-600');
                        div.classList.remove('text-gray-600');
                        div.classList.add('text-white');
                    }
                    var icon = step3.querySelector('i');
                    if (icon) {
                        icon.classList.remove('text-gray-500');
                        icon.classList.add('text-white');
                    }
                }
            @endif
            @if(!is_null($latestMagang) && $latestMagang->status_magang == 'active' && $latestMagang->laporan_magang && $latestMagang->feedback && $latestMagang->nilai_magang && $latestMagang->sertifikat_magang)
                var step3 = document.querySelector('.intern-step3');
                var step4 = document.querySelector('.intern-step4');
                if (step3) {
                    step3.classList.remove('after:border-gray-100', 'after:bg-gray-100');
                    step3.classList.add('after:border-blue-600', 'after:bg-blue-600');
                    var span = step3.querySelector('span');
                    var div = step3.querySelector('#tooltip-feedback');
                    if (span) {
                        span.classList.remove('bg-gray-100');
                        span.classList.add('bg-blue-600');
                        div.classList.remove('bg-white');
                        div.classList.add('bg-blue-600');
                        div.classList.remove('text-gray-600');
                        div.classList.add('text-white');
                    }
                    var icon = step3.querySelector('i');
                    if (icon) {
                        icon.classList.remove('text-gray-500');
                        icon.classList.add('text-white');
                    }
                }
                if (step4) {
                    var span = step4.querySelector('span');
                    var div = step4.querySelector('#tooltip-sertifikat');
                    if (span) {
                        span.classList.remove('bg-gray-100');
                        span.classList.add('bg-blue-600');
                        div.classList.remove('bg-white');
                        div.classList.add('bg-blue-600');
                        div.classList.remove('text-gray-600');
                        div.classList.add('text-white');
                    }
                    var icon = step4.querySelector('i');
                    if (icon) {
                        icon.classList.remove('text-gray-500');
                        icon.classList.add('text-white');
                    }
                }
            @endif
        });
    </script>
@endsection