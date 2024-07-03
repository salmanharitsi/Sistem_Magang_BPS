@extends('layouts.app')

@section('title', 'User dashboard')

@section('content')
    @php
        use Carbon\Carbon;
    @endphp

    <div class="w-full h-44 rounded-lg bg-blue-500 relative overflow-hidden">
        <img class="absolute inset-0 w-full h-full object-cover" src="{{ asset('assets/images/usernormal/bg-dash.svg') }}"
            alt="">
        <p class="flex h-full w-full px-6 items-center justify-start text-white text-xl md:text-3xl font-normal">Selamat
            datang di<span class="font-medium ml-1 md:ml-2 z-10">SIMAGANG</span></p>
    </div>

    <div class="grid grid-cols-1 mt-6 lg:grid-cols-3 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">
        <div class="col-span-3 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
            <div
                class="w-full h-fit flex gap-3 items-start lg:items-center p-3 bg-amber-100 rounded-lg border text-amber-700 border-amber-700">
                <i class="ti ti-alert-circle text-lg"></i>
                <p class="text-sm">Kamu belum terdaftar program magang</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 mt-6 lg:grid-cols-3 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">
        <div class="col-span-3 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
            <ol class="flex items-center w-full px-[5%] md:px-[15%]">
                <li
                    class="step1-active flex w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-100 after:bg-gray-100 after:inline-block">
                    <span
                        class="flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full lg:h-12 lg:w-12 shrink-0">
                        <i class="ti ti-user text-2xl text-gray-500 "></i>
                    </span>
                </li>
                <li
                    class="step2-active flex w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-100 after:bg-gray-100 after:inline-block">
                    <span
                        class="flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full lg:h-12 lg:w-12 shrink-0">
                        <i class="ti ti-clipboard-text text-2xl text-gray-500"></i>
                    </span>
                </li>
                <li
                    class="step3-active flex w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-100 after:bg-gray-100 after:inline-block">
                    <span
                        class="flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full lg:h-12 lg:w-12 shrink-0">
                        <i class="ti ti-clipboard-check text-2xl text-gray-500"></i>
                    </span>
                </li>
                <li class="step4-active flex items-center w-fit">
                    <span
                        class="flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full lg:h-12 lg:w-12 shrink-0">
                        <i class="ti ti-file-info text-2xl text-gray-500"></i>
                    </span>
                </li>
            </ol>
            @if (Auth::user()->tentang_saya == null ||
                    Auth::user()->jenis_kelamin == null ||
                    Auth::user()->tempat_lahir == null ||
                    Auth::user()->tanggal_lahir == null ||
                    Auth::user()->alamat == null ||
                    Auth::user()->kartu_penduduk == null)
                <div
                    class="w-full h-fit p-3 mt-5 flex flex-col md:flex-row items-start gap-3 md:items-center justify-between bg-blue-100 rounded-lg border text-blue-700 border-blue-700">
                    <div class="flex gap-3 items-start lg:items-center">
                        <i class="ti ti-sparkles text-lg"></i>
                        <p class="text-sm">Lengkapi biodata, data akademik dan dokumen kamu agar bisa melakukan pendaftaran
                            magang</p>
                    </div>
                    <a href="/profil"
                        class="pjax-link bg-blue-600 ml-7 md:ml-0 border border-transparent px-3 py-1 rounded-lg text-white hover:bg-blue-100 hover:border hover:border-blue-600 hover:text-blue-600 transition-all duration-200">
                        <p class="text-sm whitespace-nowrap">Lengkapi data</p>
                    </a>
                </div>
            @endif
            @if (Auth::user()->tentang_saya != null &&
                    Auth::user()->jenis_kelamin != null &&
                    Auth::user()->tempat_lahir != null &&
                    Auth::user()->tanggal_lahir != null &&
                    Auth::user()->alamat != null &&
                    Auth::user()->kartu_penduduk != null &&
                    !Auth::user()->pengajuan()->exists())
                <div class="w-full h-fit mt-9">
                    <h1 class="text-gray-800 text-2xl font-medium">Pengajuan Magang</h1>
                    <div class="md:px-[0%] py-6 md:py-[2%]">
                        @livewire('pengajuan-magang')
                    </div>
                </div>
            @endif
            @if (Auth::user()->pengajuan()->exists())
                <div
                    class="w-full h-fit p-3 mt-5 flex flex-col gap-3 items-center justify-center text-center bg-green-50 rounded-lg text-green-600">
                    <i class="ti ti-circle-check text-4xl md:text-5xl"></i>
                    <p class="text-sm">
                        Pengajuan magang kamu untuk jenis magang
                        <span class="text-green-700 font-semibold">
                            @if (Auth::user()->pengajuan->jenis_magang == 'kp')
                                Kerja Praktik
                            @elseif(Auth::user()->pengajuan->jenis_magang == 'pkl')
                                Praktik Kerja Lapangan
                            @else
                                {{ Auth::user()->pengajuan->jenis_magang }}
                            @endif
                        </span>
                        sudah berhasil terkirim
                    </p>
                    <p class="text-sm">Untuk periode:
                        <span
                            class="text-green-700 font-semibold">{{ Carbon::parse(Auth::user()->pengajuan->tanggal_mulai)->format('j-F-Y') }}</span>
                        sampai dengan
                        <span class="text-green-700 font-semibold">{{ Carbon::parse(Auth::user()->pengajuan->tanggal_selesai)->format('j-F-Y') }}</span>
                    </p>
                    <a href="/pengajuan"
                        class="pjax-link bg-green-600 border border-transparent px-3 py-1 rounded-md text-white hover:bg-green-100 hover:border hover:border-green-600 hover:text-green-600 transition-all duration-200">
                        <p class="text-sm whitespace-nowrap">Cek pengajuan</p>
                    </a>
                </div>
                <div
                    class="w-full h-fit p-3 mt-5 flex flex-col gap-3 md:flex-row items-start lg:items-center bg-green-50 rounded-lg text-green-600">
                    <i class="ti ti-sparkles text-lg"></i>
                    <p class="text-sm">Cek email atau aplikasi secara berkala untuk mengetahui hasil seleksi.
                        Terimakasih sudah
                        mengajukan magang di BPS Provinsi Riau</p>
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (Auth::user()->tentang_saya != null &&
                    Auth::user()->jenis_kelamin != null &&
                    Auth::user()->tempat_lahir != null &&
                    Auth::user()->tanggal_lahir != null &&
                    Auth::user()->alamat != null &&
                    Auth::user()->kartu_penduduk != null &&
                    !Auth::user()->pengajuan()->exists())
                var step1 = document.querySelector('.step1-active');
                if (step1) {
                    var span = step1.querySelector('span');
                    if (span) {
                        span.classList.remove('bg-gray-100');
                        span.classList.add('bg-blue-600');
                    }
                    var icon = step1.querySelector('i');
                    if (icon) {
                        icon.classList.remove('text-gray-500');
                        icon.classList.add('text-white');
                    }
                }
            @endif
            @if (Auth::user()->pengajuan()->exists())
                var step1 = document.querySelector('.step1-active');
                var step2 = document.querySelector('.step2-active');
                if (step1) {
                    step1.classList.remove('after:border-gray-100', 'after:bg-gray-100');
                    step1.classList.add('after:border-blue-600', 'after:bg-blue-600');
                    var span = step1.querySelector('span');
                    if (span) {
                        span.classList.remove('bg-gray-100');
                        span.classList.add('bg-blue-600');
                    }
                    var icon = step1.querySelector('i');
                    if (icon) {
                        icon.classList.remove('text-gray-500');
                        icon.classList.add('text-white');
                    }
                }
                if (step2) {
                    var span = step2.querySelector('span');
                    if (span) {
                        span.classList.remove('bg-gray-100');
                        span.classList.add('bg-blue-600');
                    }
                    var icon = step2.querySelector('i');
                    if (icon) {
                        icon.classList.remove('text-gray-500');
                        icon.classList.add('text-white');
                    }
                }
            @endif
        });
    </script>

@endsection
