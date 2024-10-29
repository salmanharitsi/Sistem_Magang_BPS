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

    <div class="grid grid-cols-1 mt-6 lg:grid-cols-3 lg:gap-x-6 gap-x-0 gap-y-6">
        @if (Auth::user()->pengajuan()->where('status_pengajuan', 'accept-first')->exists())
            @php
                $pengajuan = Auth::user()->pengajuan()->where('status_pengajuan', 'accept-first')->first();
            @endphp
                <div class="col-span-3 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
                    <div class="w-full h-fit flex gap-3 items-start lg:items-center p-3 bg-amber-100 rounded-lg border text-amber-700 border-amber-700">
                        <i class="ti ti-alert-circle text-lg"></i>
                        <p class="text-sm">Segera kirim surat pengantar dari sekolah atau universitas, tenggat <span class="font-bold">{{ \Carbon\Carbon::parse($pengajuan->tenggat)->translatedFormat('j F Y') }}</span></p>
                    </div>
                </div>
                <div class="col-span-3 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
                    <div class="w-full h-fit flex gap-3 items-start lg:items-center p-3 bg-red-100 rounded-lg border text-red-700 border-red-700">
                        <i class="ti ti-alert-triangle text-lg"></i>
                        <p class="text-sm">Tidak mengirim surat pengantar sesuai tenggat menyebabkan pengajuan kamu ditolak</p>
                    </div>
                </div>
        @elseif (Auth::user()->pengajuan()->where('status_pengajuan', 'reject-time')->first())
            <div class="col-span-3 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
                <div class="w-full h-fit flex gap-3 items-start lg:items-center p-3 bg-red-100 rounded-lg border text-red-700 border-red-700">
                    <i class="ti ti-alert-triangle text-lg"></i>
                    <p class="text-sm">Kamu melewati tenggat upload surat pengantar!</p>
                </div>
            </div>
        @elseif (Auth::user()->pengajuan()->where('status_pengajuan', 'reject-admin')->first())
            <div class="col-span-3 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
                <div class="w-full h-fit flex gap-3 items-start lg:items-center p-3 bg-red-100 rounded-lg border text-red-700 border-red-700">
                    <i class="ti ti-sparkles text-lg"></i>
                    <p class="text-sm">Baca pesan penolakan pada <span class="font-semibold underline"><a href="/pengajuan" class="pjax-link">detail pengajuan</a></span></p>
                </div>
            </div>    
        @else
            <div class="col-span-3 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
                <div class="w-full h-fit flex gap-3 items-start lg:items-center p-3 bg-amber-100 rounded-lg border text-amber-700 border-amber-700">
                    <i class="ti ti-alert-circle text-lg"></i>
                    <p class="text-sm">Kamu belum terdaftar program magang</p>
                </div>
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 mt-6 lg:grid-cols-3 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">
        <div class="col-span-3 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
            <ol class="flex items-center w-full px-[5%] md:px-[15%]">
                <li
                    class="step1-active flex w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-100 after:bg-gray-100 after:inline-block">
                    <span
                        class="flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full lg:h-12 lg:w-12 shrink-0"
                        data-tooltip-target="tooltip-profil">
                        <i class="ti ti-user text-2xl text-gray-500 "></i>
                    </span>
                    <div id="tooltip-profil" role="tooltip"
                        class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-regular text-gray-600 transition-opacity duration-300 bg-white rounded-lg shadow-lg opacity-0 tooltip dark:bg-gray-700">
                        Melengkapi Profil
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                </li>
                <li
                    class="step2-active flex w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-100 after:bg-gray-100 after:inline-block">
                    <span
                        class="flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full lg:h-12 lg:w-12 shrink-0"
                        data-tooltip-target="tooltip-pengajuan">
                        <i class="ti ti-clipboard-text text-2xl text-gray-500"></i>
                    </span>
                    <div id="tooltip-pengajuan" role="tooltip"
                        class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-regular text-gray-600 transition-opacity duration-300 bg-white rounded-lg shadow-lg opacity-0 tooltip dark:bg-gray-700">
                        Mengajukan Program Magang
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                </li>
                <li
                    class="step3-active flex w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-100 after:bg-gray-100 after:inline-block">
                    <span
                        class="flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full lg:h-12 lg:w-12 shrink-0"
                        data-tooltip-target="tooltip-diterima">
                        <i class="ti ti-clipboard-check text-2xl text-gray-500"></i>
                    </span>
                    <div id="tooltip-diterima" role="tooltip"
                        class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-regular text-gray-600 transition-opacity duration-300 bg-white rounded-lg shadow-lg opacity-0 tooltip dark:bg-gray-700">
                        Lolos Seleksi Program
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                </li>
                <li class="step4-active flex items-center w-fit">
                    <span
                        class="flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full lg:h-12 lg:w-12 shrink-0"
                        data-tooltip-target="tooltip-surat-pengantar">
                        <i class="ti ti-file-info text-2xl text-gray-500"></i>
                    </span>
                    <div id="tooltip-surat-pengantar" role="tooltip"
                        class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-regular text-gray-600 transition-opacity duration-300 bg-white rounded-lg shadow-lg opacity-0 tooltip dark:bg-gray-700">
                        Mengupload Surat Pengantar
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
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
                    Auth::user()->status_magang == 'tidak-aktif')
                <div class="w-full h-fit mt-9">
                    <h1 class="text-gray-800 text-2xl font-medium">Pengajuan Magang</h1>
                    <div class="md:px-[0%] pt-6 md:pt-[2%]">
                        @livewire('pengajuan-magang')
                    </div>
                </div>
            @endif
            @if (Auth::user()->pengajuan()->where('status_pengajuan', 'waiting')->exists())
                @php
                    $pengajuan = Auth::user()->pengajuan()->where('status_pengajuan', 'waiting')->first();
                @endphp
                <div class="w-full h-fit p-3 mt-5 flex flex-col gap-3 items-center justify-center text-center bg-green-100 rounded-lg text-green-600">
                    <i class="ti ti-circle-check text-4xl md:text-5xl"></i>
                    <p class="text-sm">
                        Pengajuan magang kamu untuk jenis magang
                        <span class="text-green-700 font-semibold">
                            {{ $pengajuan->jenis_magang }}
                        </span>
                        sudah berhasil terkirim
                    </p>
                    <p class="text-sm">Untuk periode:
                        <span class="text-green-700 font-semibold">{{ Carbon::parse($pengajuan->tanggal_mulai)->format('j-F-Y') }}</span>
                        sampai dengan
                        <span class="text-green-700 font-semibold">{{ Carbon::parse($pengajuan->tanggal_selesai)->format('j-F-Y') }}</span>
                    </p>
                    <a href="/pengajuan"
                        class="pjax-link bg-green-600 border border-transparent px-3 py-1 rounded-md text-white hover:bg-green-100 hover:border hover:border-green-600 hover:text-green-600 transition-all duration-200">
                        <p class="text-sm whitespace-nowrap">Cek pengajuan</p>
                    </a>
                </div>
                <div class="w-full h-fit p-3 mt-5 flex flex-col gap-3 md:flex-row items-start lg:items-center bg-green-100 rounded-lg text-green-600">
                    <i class="ti ti-sparkles text-lg"></i>
                    <p class="text-sm">Cek email atau aplikasi secara berkala untuk mengetahui hasil seleksi.
                        Terimakasih sudah mengajukan magang di BPS Provinsi Riau</p>
                </div>
            @endif
            @if (Auth::user()->pengajuan()->where('status_pengajuan', 'accept-first')->exists())
                @php
                    // Ambil pengajuan pertama dengan status 'accept-first'
                    $pengajuan = Auth::user()->pengajuan()->where('status_pengajuan', 'accept-first')->first();
                @endphp
                <div class="w-full mt-6 min-h-[323px] rounded-lg bg-green-800 relative rotate-180 overflow-hidden flex items-center justify-center">
                    <img class="absolute inset-0 w-full h-full object-cover" src="{{ asset('assets/images/usernormal/bg-diterima.svg') }}" alt="">
                    <div class="text-center rotate-180">
                        <p class="text-white text-xl md:text-3xl font-semibold">Selamat Kamu diterima 🎉 <span class="font-light">, pada</span></p>
                        <p class="text-sm mt-2 text-white">
                            jenis magang
                            <span class="font-semibold">{{ $pengajuan->jenis_magang }}</span>
                        </p>
                        <p class="text-sm text-white">
                            Untuk periode:
                            <span class="font-semibold">{{ Carbon::parse($pengajuan->tanggal_mulai)->format('j-F-Y') }}</span>
                            sampai dengan
                            <span class="font-semibold">{{ Carbon::parse($pengajuan->tanggal_selesai)->format('j-F-Y') }}</span>
                        </p>
                        <div class="w-full flex items-center justify-center mt-5">
                            <a href=""
                                class="pjax-link w-fit flex justify-center bg-green-600 border border-transparent px-3 py-1 rounded-md text-white hover:bg-green-100 hover:border hover:border-green-600 hover:text-green-600 transition-all duration-200">
                                <p class="text-sm whitespace-nowrap">Upload Surat Pengantar</p>
                            </a>
                        </div>
                    </div>
                </div>
            @endif
            @if (Auth::user()->pengajuan()->where('status_pengajuan', 'reject-time')->exists())
                @php
                    $pengajuan = Auth::user()->pengajuan()->where('status_pengajuan', 'reject-time')->first();
                @endphp
                <div class="w-full h-fit p-3 mt-5 flex flex-col gap-3 items-center justify-center text-center bg-red-100 rounded-lg text-red-600">
                    <i class="ti ti-circle-x text-4xl md:text-5xl"></i>
                    <p class="text-sm">
                        Pengajuan magang kamu untuk jenis magang
                        <span class="text-red-700 font-semibold">
                            {{ $pengajuan->jenis_magang }}
                        </span>
                        ditolak
                    </p>
                    <p class="text-sm">Untuk periode:
                        <span class="text-red-700 font-semibold">{{ Carbon::parse($pengajuan->tanggal_mulai)->format('j-F-Y') }}</span>
                        sampai dengan
                        <span class="text-red-700 font-semibold">{{ Carbon::parse($pengajuan->tanggal_selesai)->format('j-F-Y') }}</span>
                    </p>
                    <form action="{{ route('usernormal.pengajuan-ulang', $pengajuan->id) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="pjax-link bg-red-600 border border-transparent px-3 py-1 rounded-md text-white hover:bg-red-100 hover:border hover:border-red-600 hover:text-red-600 transition-all duration-200">
                            <p class="text-sm whitespace-nowrap">Ajukan kembali</p>
                        </button>
                    </form>
                </div>
            @endif
            @if (Auth::user()->pengajuan()->where('status_pengajuan', 'reject-admin')->exists())
                @php
                    $pengajuan = Auth::user()->pengajuan()->where('status_pengajuan', 'reject-admin')->first();
                @endphp
                <div class="w-full h-fit py-10 mt-5 flex flex-col gap-3 items-center justify-center text-center bg-red-100 rounded-lg text-red-600">
                    <h1 class="text-xl font-semibold rounded-full text-white px-10 py-1.5 bg-gradient-to-r from-[#FF0000] to-[#6C2323]">Maaf Kamu Belum Diterima, <span class="font-normal">Pada</span></h1>
                    <p class="text-sm">
                        jenis magang
                        <span class="text-red-700 font-semibold">
                            {{ $pengajuan->jenis_magang }}
                        </span>
                    </p>
                    <p class="text-sm -mt-2">Untuk periode:
                        <span class="text-red-700 font-semibold">{{ Carbon::parse($pengajuan->tanggal_mulai)->format('j-F-Y') }}</span>
                        sampai dengan
                        <span class="text-red-700 font-semibold">{{ Carbon::parse($pengajuan->tanggal_selesai)->format('j-F-Y') }}</span>
                    </p>
                    <form action="{{ route('usernormal.pengajuan-ulang', $pengajuan->id) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="pjax-link bg-red-600 border border-transparent px-3 py-1 rounded-md text-white hover:bg-red-100 hover:border hover:border-red-600 hover:text-red-600 transition-all duration-200">
                            <p class="text-sm whitespace-nowrap">Ajukan kembali</p>
                        </button>
                    </form>
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
                    Auth::user()->kartu_penduduk != null)
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
            @if (Auth::user()->pengajuan()->where('status_pengajuan', 'accept-first')->exists())
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
        });
    </script>

@endsection
