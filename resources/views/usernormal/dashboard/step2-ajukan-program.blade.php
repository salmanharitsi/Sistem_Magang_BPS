@extends('layouts.app')

@section('title', 'Ajukan Program Magang - SIMAGANG')

@section('content')
    @php
        use Carbon\Carbon;
        Carbon::setLocale('id');
    @endphp

    <div class="w-full">
        <!-- Header -->
        <div class="w-full h-44 rounded-lg bg-gradient-to-r from-green-500 to-green-600 relative overflow-hidden mb-6">
            <img class="absolute inset-0 w-full h-full object-cover opacity-20" src="{{ asset('assets/images/usernormal/bg-dash.svg') }}" alt="">
            <div class="relative z-10 flex h-full w-full px-6 items-center justify-between text-white">
                <div>
                    <h1 class="text-2xl md:text-3xl font-medium">Ajukan Program Magang</h1>
                    <p class="text-sm md:text-base opacity-90 mt-2">Tahap 2: Pilih dan ajukan program magang yang sesuai dengan minat kamu</p>
                </div>
                <div class="hidden md:block">
                    <div class="w-20 h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <i class="ti ti-clipboard-text text-4xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Progress Indicator -->
        <div class="card rounded-lg bg-white p-5 mb-6 dark:bg-[#14181b] transition-all duration-200">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold">Progress Tahapan</h3>
                <span class="text-sm text-gray-500">2 dari 4</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="flex-1 h-2 bg-green-200 rounded-full overflow-hidden">
                    <div class="h-full bg-green-600 rounded-full" style="width: 50%"></div>
                </div>
                <span class="text-sm font-medium text-green-600">50%</span>
            </div>
        </div>

        <!-- Status Check -->
        @if ($step2_completed)
            <div class="card rounded-lg bg-white p-5 mb-6 dark:bg-[#14181b] transition-all duration-200">
                <div class="w-full h-fit flex gap-3 items-start lg:items-center p-3 bg-green-100 rounded-lg border text-green-700 border-green-700">
                    <i class="ti ti-circle-check text-lg"></i>
                    <div class="flex-1">
                        <p class="text-sm font-medium">Pengajuan sudah terkirim!</p>
                        <p class="text-xs mt-1">Menunggu hasil seleksi dari admin</p>
                    </div>
                    <a href="/dashboard/lolos-seleksi" class="pjax-link bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-all duration-200">
                        <span class="text-sm">Lihat Status</span>
                    </a>
                </div>
            </div>
        @elseif (Auth::user()->status_magang == 'tidak-aktif')
            <div class="card rounded-lg bg-white p-5 mb-6 dark:bg-[#14181b] transition-all duration-200">
                <div class="w-full h-fit flex gap-3 items-start lg:items-center p-3 bg-blue-100 rounded-lg border text-blue-700 border-blue-700">
                    <i class="ti ti-info-circle text-lg"></i>
                    <div class="flex-1">
                        <p class="text-sm font-medium">Siap untuk mengajukan program magang</p>
                        <p class="text-xs mt-1">Pilih program magang yang sesuai dengan minat dan jadwal kamu</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Previous Step Completed Indicator -->
        @if ($step1_completed)
            <div class="card rounded-lg bg-white p-5 mb-6 dark:bg-[#14181b] transition-all duration-200">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                        <i class="ti ti-check text-white"></i>
                    </div>
                    <span class="text-green-700 font-medium">Tahap 1: Profil sudah lengkap</span>
                </div>
            </div>
        @endif

        <!-- Pengajuan Form Section -->
        @if (Auth::user()->status_magang == 'tidak-aktif')
            <div class="card rounded-lg bg-white p-5 mb-6 dark:bg-[#14181b] transition-all duration-200">
                <h3 class="text-lg font-semibold mb-4">Form Pengajuan Magang</h3>
                <div class="md:px-[0%] pt-2 md:pt-[2%]">
                    @livewire('pengajuan-magang')
                </div>
            </div>
        @endif

        <!-- Information Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="card rounded-lg bg-white p-5 dark:bg-[#14181b] transition-all duration-200">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="ti ti-info-circle text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-2">Tips Pengajuan</h4>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>• Pastikan tanggal sesuai dengan jadwal kamu</li>
                            <li>• Pilih jenis magang yang sesuai minat</li>
                            <li>• Baca persyaratan dengan teliti</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card rounded-lg bg-white p-5 dark:bg-[#14181b] transition-all duration-200">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                        <i class="ti ti-clock text-amber-600 text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-2">Proses Seleksi</h4>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>• Review pengajuan: 1-3 hari kerja</li>
                            <li>• Notifikasi via email & aplikasi</li>
                            <li>• Siapkan surat pengantar jika diterima</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <div class="card rounded-lg bg-white p-5 dark:bg-[#14181b] transition-all duration-200">
            <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                <div class="text-center md:text-left">
                    <h3 class="text-lg font-semibold">
                        @if($step2_completed)
                            Pengajuan Berhasil Terkirim
                        @else
                            Siap Mengajukan Program Magang?
                        @endif
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">
                        @if($step2_completed)
                            Kamu akan mendapat notifikasi hasil seleksi via email dan aplikasi
                        @else
                            Isi form pengajuan di atas untuk memulai proses magang
                        @endif
                    </p>
                </div>
                <div class="flex gap-3">
                    <a href="/dashboard/lengkapi-profil" class="pjax-link px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-all duration-200">
                        <span class="text-sm">Kembali</span>
                    </a>
                    @if($step2_completed)
                        <a href="/dashboard/lolos-seleksi" class="pjax-link bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-all duration-200">
                            <span class="text-sm">Lihat Status</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection