@extends('layouts.app')

@section('title', 'Lolos Seleksi Program - SIMAGANG')

@section('content')
    @php
        use Carbon\Carbon;
        Carbon::setLocale('id');
    @endphp

    <div class="w-full">
        <!-- Header -->
        <div class="w-full h-44 rounded-lg bg-gradient-to-r from-purple-500 to-purple-600 relative overflow-hidden mb-6">
            <img class="absolute inset-0 w-full h-full object-cover opacity-20" src="{{ asset('assets/images/usernormal/bg-dash.svg') }}" alt="">
            <div class="relative z-10 flex h-full w-full px-6 items-center justify-between text-white">
                <div>
                    <h1 class="text-2xl md:text-3xl font-medium">Hasil Seleksi Program</h1>
                    <p class="text-sm md:text-base opacity-90 mt-2">Tahap 3: Cek status hasil seleksi program magang kamu</p>
                </div>
                <div class="hidden md:block">
                    <div class="w-20 h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <i class="ti ti-clipboard-check text-4xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Progress Indicator -->
        <div class="card rounded-lg bg-white p-5 mb-6 dark:bg-[#14181b] transition-all duration-200">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold">Progress Tahapan</h3>
                <span class="text-sm text-gray-500">3 dari 4</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="flex-1 h-2 bg-purple-200 rounded-full overflow-hidden">
                    <div class="h-full bg-purple-600 rounded-full" style="width: 75%"></div>
                </div>
                <span class="text-sm font-medium text-purple-600">75%</span>
            </div>
        </div>

        <!-- Previous Steps Completed -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div class="card rounded-lg bg-white p-4 dark:bg-[#14181b] transition-all duration-200">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                        <i class="ti ti-check text-white"></i>
                    </div>
                    <span class="text-green-700 font-medium">Tahap 1: Profil Lengkap</span>
                </div>
            </div>
            <div class="card rounded-lg bg-white p-4 dark:bg-[#14181b] transition-all duration-200">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                        <i class="ti ti-check text-white"></i>
                    </div>
                    <span class="text-green-700 font-medium">Tahap 2: Pengajuan Terkirim</span>
                </div>
            </div>
        </div>

        <!-- Status Result -->
        @if ($latest_pengajuan)
            @if ($latest_pengajuan->status_pengajuan === 'waiting')
                <div class="card rounded-lg bg-white p-6 mb-6 dark:bg-[#14181b] transition-all duration-200">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="ti ti-clock text-amber-600 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Menunggu Hasil Seleksi</h3>
                        <p class="text-gray-600 mb-4">Pengajuan magang kamu sedang dalam proses review</p>
                        <div class="bg-amber-50 border border-amber-200 rounded-lg p-4">
                            <p class="text-sm text-amber-700">
                                <strong>Jenis Magang:</strong> {{ $latest_pengajuan->jenis_magang }}<br>
                                <strong>Periode:</strong> {{ Carbon::parse($latest_pengajuan->tanggal_mulai)->translatedFormat('j F Y') }} - {{ Carbon::parse($latest_pengajuan->tanggal_selesai)->translatedFormat('j F Y') }}
                            </p>
                        </div>
                    </div>
                </div>

            @elseif ($latest_pengajuan->status_pengajuan === 'accept-first')
                <div class="card rounded-lg bg-white p-6 mb-6 dark:bg-[#14181b] transition-all duration-200">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="ti ti-circle-check text-green-600 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2 text-green-700">Selamat! Kamu Diterima 🎉</h3>
                        <p class="text-gray-600 mb-4">Pengajuan magang kamu telah disetujui</p>
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                            <p class="text-sm text-green-700">
                                <strong>Jenis Magang:</strong> {{ $latest_pengajuan->jenis_magang }}<br>
                                <strong>Periode:</strong> {{ Carbon::parse($latest_pengajuan->tanggal_mulai)->translatedFormat('j F Y') }} - {{ Carbon::parse($latest_pengajuan->tanggal_selesai)->translatedFormat('j F Y') }}
                            </p>
                        </div>
                        @if($step4_completed)
                            <div class="flex gap-3 justify-center">
                                <a href="/dashboard/upload-surat" class="pjax-link bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-all duration-200">
                                    <span class="text-sm">Lihat Status Surat</span>
                                </a>
                            </div>
                        @else
                            <div class="flex gap-3 justify-center">
                                <a href="/dashboard/upload-surat" class="pjax-link bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-all duration-200">
                                    <span class="text-sm">Upload Surat Pengantar</span>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

            @elseif (in_array($latest_pengajuan->status_pengajuan, ['reject-admin', 'reject-final', 'reject-time', 'reject-days']))
                <div class="card rounded-lg bg-white p-6 mb-6 dark:bg-[#14181b] transition-all duration-200">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="ti ti-circle-x text-red-600 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2 text-red-700">Pengajuan Ditolak</h3>
                        <p class="text-gray-600 mb-4">
                            @if($latest_pengajuan->status_pengajuan === 'reject-time')
                                Pengajuan ditolak karena melewati tenggat upload surat pengantar
                            @elseif($latest_pengajuan->status_pengajuan === 'reject-days')
                                Masa pendaftaran melewati tanggal mulai magang
                            @else
                                Pengajuan tidak memenuhi persyaratan yang ditentukan
                            @endif
                        </p>
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                            <p class="text-sm text-red-700">
                                <strong>Jenis Magang:</strong> {{ $latest_pengajuan->jenis_magang }}<br>
                                <strong>Periode:</strong> {{ Carbon::parse($latest_pengajuan->tanggal_mulai)->translatedFormat('j F Y') }} - {{ Carbon::parse($latest_pengajuan->tanggal_selesai)->translatedFormat('j F Y') }}
                            </p>
                        </div>
                        <div class="flex gap-3 justify-center">
                            <a href="/pengajuan" class="pjax-link border border-gray-300 px-4 py-2 rounded-lg hover:bg-gray-50 transition-all duration-200">
                                <span class="text-sm">Lihat Detail</span>
                            </a>
                            <form action="{{ route('usernormal.pengajuan-ulang', $latest_pengajuan->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition-all duration-200">
                                    <span class="text-sm">Ajukan Kembali</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        @else
            <div class="card rounded-lg bg-white p-6 mb-6 dark:bg-[#14181b] transition-all duration-200">
                <div class="text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="ti ti-file-off text-gray-400 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Belum Ada Pengajuan</h3>
                    <p class="text-gray-600 mb-4">Kamu belum mengajukan program magang</p>
                    <a href="/dashboard/ajukan-program" class="pjax-link bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-all duration-200">
                        <span class="text-sm">Ajukan Program</span>
                    </a>
                </div>
            </div>
        @endif

        <!-- Information Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="card rounded-lg bg-white p-5 dark:bg-[#14181b] transition-all duration-200">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="ti ti-info-circle text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-2">Informasi Penting</h4>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>• Hasil seleksi akan diberitahu via email</li>
                            <li>• Cek aplikasi secara berkala</li>
                            <li>• Siapkan surat pengantar jika diterima</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card rounded-lg bg-white p-5 dark:bg-[#14181b] transition-all duration-200">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="ti ti-mail text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-2">Notifikasi</h4>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>• Email konfirmasi telah dikirim</li>
                            <li>• Update status tersedia di aplikasi</li>
                            <li>• Hubungi admin jika ada pertanyaan</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <div class="card rounded-lg bg-white p-5 dark:bg-[#14181b] transition-all duration-200">
            <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                <div class="text-center md:text-left">
                    <h3 class="text-lg font-semibold">Langkah Selanjutnya</h3>
                    <p class="text-sm text-gray-600 mt-1">
                        @if($latest_pengajuan && $latest_pengajuan->status_pengajuan === 'accept-first')
                            @if($step4_completed)
                                Surat pengantar sudah diupload, tunggu konfirmasi selanjutnya
                            @else
                                Upload surat pengantar untuk melanjutkan proses magang
                            @endif
                        @elseif($latest_pengajuan && $latest_pengajuan->status_pengajuan === 'waiting')
                            Tunggu hasil seleksi dari admin
                        @else
                            Perbaiki pengajuan atau ajukan program magang baru
                        @endif
                    </p>
                </div>
                <div class="flex gap-3">
                    <a href="/dashboard/ajukan-program" class="pjax-link px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-all duration-200">
                        <span class="text-sm">Kembali</span>
                    </a>
                    @if($latest_pengajuan && $latest_pengajuan->status_pengajuan === 'accept-first' && !$step4_completed)
                        <a href="/dashboard/upload-surat" class="pjax-link bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition-all duration-200">
                            <span class="text-sm">Upload Surat</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection