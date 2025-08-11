@extends('layouts.app')

@section('title', 'Lengkapi Profil - SIMAGANG')

@section('content')
    @php
        use Carbon\Carbon;
        Carbon::setLocale('id');
    @endphp

    <div class="w-full">
        <!-- Header -->
        <div class="w-full h-44 rounded-lg bg-gradient-to-r from-blue-500 to-blue-600 relative overflow-hidden mb-6">
            <img class="absolute inset-0 w-full h-full object-cover opacity-20" src="{{ asset('assets/images/usernormal/bg-dash.svg') }}" alt="">
            <div class="relative z-10 flex h-full w-full px-6 items-center justify-between text-white">
                <div>
                    <h1 class="text-2xl md:text-3xl font-medium">Lengkapi Profil</h1>
                    <p class="text-sm md:text-base opacity-90 mt-2">Tahap 1: Lengkapi data pribadi dan dokumen untuk melanjutkan proses magang</p>
                </div>
                <div class="hidden md:block">
                    <div class="w-20 h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <i class="ti ti-user text-4xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Progress Indicator -->
        <div class="card rounded-lg bg-white p-5 mb-6 dark:bg-[#14181b] transition-all duration-200">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold">Progress Tahapan</h3>
                <span class="text-sm text-gray-500">1 dari 4</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="flex-1 h-2 bg-blue-200 rounded-full overflow-hidden">
                    <div class="h-full bg-blue-600 rounded-full" style="width: 25%"></div>
                </div>
                <span class="text-sm font-medium text-blue-600">25%</span>
            </div>
        </div>

        <!-- Status Check -->
        @if ($step1_completed)
            <div class="card rounded-lg bg-white p-5 mb-6 dark:bg-[#14181b] transition-all duration-200">
                <div class="w-full h-fit flex gap-3 items-start lg:items-center p-3 bg-green-100 rounded-lg border text-green-700 border-green-700">
                    <i class="ti ti-circle-check text-lg"></i>
                    <div class="flex-1">
                        <p class="text-sm font-medium">Profil sudah lengkap!</p>
                        <p class="text-xs mt-1">Kamu sudah dapat melanjutkan ke tahap berikutnya</p>
                    </div>
                    <a href="/dashboard/ajukan-program" class="pjax-link bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-all duration-200">
                        <span class="text-sm">Lanjut ke Tahap 2</span>
                    </a>
                </div>
            </div>
        @else
            <div class="card rounded-lg bg-white p-5 mb-6 dark:bg-[#14181b] transition-all duration-200">
                <div class="w-full h-fit flex gap-3 items-start lg:items-center p-3 bg-amber-100 rounded-lg border text-amber-700 border-amber-700">
                    <i class="ti ti-alert-circle text-lg"></i>
                    <div class="flex-1">
                        <p class="text-sm font-medium">Profil belum lengkap</p>
                        <p class="text-xs mt-1">Lengkapi data berikut untuk melanjutkan ke tahap selanjutnya</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Checklist Requirements -->
        <div class="card rounded-lg bg-white p-5 mb-6 dark:bg-[#14181b] transition-all duration-200">
            <h3 class="text-lg font-semibold mb-4">Yang Perlu Dilengkapi</h3>
            <div class="space-y-3">
                @php
                    $user = Auth::user();
                    $requirements = [
                        'foto_profil' => ['Foto Profil', 'ti-camera', $user->foto_profil != null],
                        'tentang_saya' => ['Tentang Saya', 'ti-info-circle', $user->tentang_saya != null],
                        'jenis_kelamin' => ['Jenis Kelamin', 'ti-users', $user->jenis_kelamin != null],
                        'tempat_lahir' => ['Tempat Lahir', 'ti-map-pin', $user->tempat_lahir != null],
                        'tanggal_lahir' => ['Tanggal Lahir', 'ti-calendar', $user->tanggal_lahir != null],
                        'alamat' => ['Alamat', 'ti-home', $user->alamat != null]
                    ];
                @endphp

                @foreach($requirements as $field => $data)
                    <div class="flex items-center gap-3 p-3 rounded-lg {{ $data[2] ? 'bg-green-50' : 'bg-gray-50' }}">
                        <div class="w-8 h-8 rounded-full {{ $data[2] ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center">
                            <i class="ti {{ $data[2] ? 'ti-check text-white' : $data[1] . ' text-gray-500' }}"></i>
                        </div>
                        <span class="flex-1 {{ $data[2] ? 'text-green-700 font-medium' : 'text-gray-700' }}">{{ $data[0] }}</span>
                        @if($data[2])
                            <span class="text-xs text-green-600 bg-green-100 px-2 py-1 rounded-full">Selesai</span>
                        @else
                            <span class="text-xs text-amber-600 bg-amber-100 px-2 py-1 rounded-full">Belum</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Action Button -->
        <div class="card rounded-lg bg-white p-5 dark:bg-[#14181b] transition-all duration-200">
            <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                <div class="text-center md:text-left">
                    <h3 class="text-lg font-semibold">Siap untuk melengkapi profil?</h3>
                    <p class="text-sm text-gray-600 mt-1">Klik tombol di bawah untuk menuju halaman profil dan lengkapi semua data yang diperlukan</p>
                </div>
                <div class="flex gap-3">
                    <a href="/dashboard" class="pjax-link px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-all duration-200">
                        <span class="text-sm">Kembali</span>
                    </a>
                    <a href="/profil" class="pjax-link bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-all duration-200">
                        <span class="text-sm">Lengkapi Profil</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection