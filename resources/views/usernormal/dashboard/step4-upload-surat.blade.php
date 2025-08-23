@extends('layouts.app')

@section('title', 'Upload Surat Pengantar - SIMAGANG')

@section('content')
    @php
        use Carbon\Carbon;
        Carbon::setLocale('id');
    @endphp

    <div class="w-full">
        <!-- Header -->
        <div class="w-full h-44 rounded-lg bg-gradient-to-r from-indigo-500 to-indigo-600 relative overflow-hidden mb-6">
            <img class="absolute inset-0 w-full h-full object-cover opacity-20" src="{{ asset('assets/images/usernormal/bg-dash.svg') }}" alt="">
            <div class="relative z-10 flex h-full w-full px-6 items-center justify-between text-white">
                <div>
                    <h1 class="text-2xl md:text-3xl font-medium">Upload Surat Pengantar</h1>
                    <p class="text-sm md:text-base opacity-90 mt-2">Tahap 4: Upload surat pengantar dari sekolah/universitas</p>
                </div>
                <div class="hidden md:block">
                    <div class="w-20 h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <i class="ti ti-file-info text-4xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Progress Indicator -->
        <div class="card rounded-lg bg-white p-5 mb-6 dark:bg-[#14181b] transition-all duration-200">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold">Progress Tahapan</h3>
                <span class="text-sm text-gray-500">4 dari 4</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="flex-1 h-2 bg-indigo-200 rounded-full overflow-hidden">
                    <div class="h-full bg-indigo-600 rounded-full" style="width: {{ $step4_completed ? '100%' : '90%' }}"></div>
                </div>
                <span class="text-sm font-medium text-indigo-600">{{ $step4_completed ? '100%' : '90%' }}</span>
            </div>
        </div>

        <!-- Previous Steps Completed -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="card rounded-lg bg-white p-4 dark:bg-[#14181b] transition-all duration-200">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                        <i class="ti ti-check text-white"></i>
                    </div>
                    <span class="text-green-700 font-medium text-sm">Profil Lengkap</span>
                </div>
            </div>
            <div class="card rounded-lg bg-white p-4 dark:bg-[#14181b] transition-all duration-200">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                        <i class="ti ti-check text-white"></i>
                    </div>
                    <span class="text-green-700 font-medium text-sm">Pengajuan Terkirim</span>
                </div>
            </div>
            <div class="card rounded-lg bg-white p-4 dark:bg-[#14181b] transition-all duration-200">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                        <i class="ti ti-check text-white"></i>
                    </div>
                    <span class="text-green-700 font-medium text-sm">Lolos Seleksi</span>
                </div>
            </div>
        </div>

        <!-- Status Check -->
        @if ($step4_completed)
            <div class="card rounded-lg bg-white p-6 mb-6 dark:bg-[#14181b] transition-all duration-200">
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="ti ti-circle-check text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-green-700">Surat Pengantar Sudah Diupload!</h3>
                    <p class="text-gray-600 mb-4">Surat pengantar sedang dalam proses pengecekan admin</p>
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <p class="text-sm text-green-700">
                            Semua tahapan telah selesai. Tunggu konfirmasi final dari admin untuk memulai magang.
                        </p>
                    </div>
                </div>
            </div>
        @else
            <!-- Upload Requirements -->
            <div class="card rounded-lg bg-white p-5 mb-6 dark:bg-[#14181b] transition-all duration-200">
                <div class="flex items-start gap-3 p-4 bg-amber-50 rounded-lg border border-amber-200">
                    <i class="ti ti-alert-circle text-amber-600 text-lg"></i>
                    <div class="flex-1">
                        <h4 class="font-semibold text-amber-800 mb-1">Tenggat Upload</h4>
                        <p class="text-sm text-amber-700">
                            Segera upload surat pengantar sebelum tenggat: 
                            <span class="font-bold">{{ $latest_pengajuan ? Carbon::parse($latest_pengajuan->tenggat)->translatedFormat('j F Y') : 'N/A' }}</span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="card rounded-lg bg-white p-5 mb-6 dark:bg-[#14181b] transition-all duration-200">
                <div class="flex items-start gap-3 p-4 bg-red-50 rounded-lg border border-red-200">
                    <i class="ti ti-alert-triangle text-red-600 text-lg"></i>
                    <div class="flex-1">
                        <h4 class="font-semibold text-red-800 mb-1">Peringatan</h4>
                        <p class="text-sm text-red-700">
                            Tidak mengirim surat pengantar sesuai tenggat akan menyebabkan pengajuan ditolak
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Requirements Checklist -->
        <div class="card rounded-lg bg-white p-5 mb-6 dark:bg-[#14181b] transition-all duration-200">
            <h3 class="text-lg font-semibold mb-4">Persyaratan Surat Pengantar</h3>
            <div class="space-y-3">
                @php
                    $requirements = [
                        ['Surat resmi dari sekolah/universitas', 'ti-school'],
                        ['Format PDF atau JPG/PNG', 'ti-file-text'],
                        ['Ukuran maksimal 5MB', 'ti-file'],
                        ['Surat tertandatangani kepala sekolah/dekan', 'ti-signature'],
                        ['Mencantumkan nama dan data diri peserta', 'ti-user-check'],
                        ['Periode magang sesuai pengajuan', 'ti-calendar-check']
                    ];
                @endphp

                @foreach($requirements as $req)
                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                            <i class="ti {{ $req[1] }} text-blue-600"></i>
                        </div>
                        <span class="text-gray-700">{{ $req[0] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Upload Form Section -->
        @if (!$step4_completed && $latest_pengajuan && $latest_pengajuan->status_pengajuan === 'accept-first')
            <div class="card rounded-lg bg-white p-5 mb-6 dark:bg-[#14181b] transition-all duration-200">
                <h3 class="text-lg font-semibold mb-4">Upload Surat Pengantar</h3>
                <!-- Form upload disini - bisa menggunakan livewire component yang sudah ada -->
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center">
                    <i class="ti ti-upload text-4xl text-gray-400 mb-4"></i>
                    <h4 class="text-lg font-medium mb-2">Drop file atau klik untuk upload</h4>
                    <p class="text-sm text-gray-500 mb-4">Dukung format PDF, JPG, PNG (Max: 5MB)</p>
                    <a href="/dashboard/surat-pengantar" class="pjax-link bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition-all duration-200">
                        <span class="text-sm">Pilih File</span>
                    </a>
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
                        <h4 class="font-semibold mb-2">Tips Upload</h4>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>• Pastikan file dapat dibaca dengan jelas</li>
                            <li>• Scan dengan resolusi minimal 300 DPI</li>
                            <li>• Hindari file yang terpotong atau blur</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card rounded-lg bg-white p-5 dark:bg-[#14181b] transition-all duration-200">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="ti ti-clock text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-2">Proses Selanjutnya</h4>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>• Review dokumen: 1-2 hari kerja</li>
                            <li>• Notifikasi hasil via email</li>
                            <li>• Persiapan mulai magang</li>
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
                        @if($step4_completed)
                            Semua Tahapan Selesai!
                        @else
                            Tahap Terakhir
                        @endif
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">
                        @if($step4_completed)
                            Tunggu konfirmasi final dari admin untuk memulai magang
                        @else
                            Upload surat pengantar untuk menyelesaikan semua persyaratan
                        @endif
                    </p>
                </div>
                <div class="flex gap-3">
                    <a href="/dashboard/lolos-seleksi" class="pjax-link px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-all duration-200">
                        <span class="text-sm">Kembali</span>
                    </a>
                    @if(!$step4_completed && $latest_pengajuan && $latest_pengajuan->status_pengajuan === 'accept-first')
                        <a href="/dashboard/surat-pengantar" class="pjax-link bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition-all duration-200">
                            <span class="text-sm">Upload Sekarang</span>
                        </a>
                    @else
                        <a href="/dashboard" class="pjax-link bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-all duration-200">
                            <span class="text-sm">Kembali ke Dashboard</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection