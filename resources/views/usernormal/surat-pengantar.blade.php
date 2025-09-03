@extends('layouts.app')

@section('title', 'Upload Surat Pengantar')

@section('content')
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
                    <div class="w-full h-fit flex gap-3 items-start lg:items-center p-3 bg-red-100 rounded-lg border text-red-700 border-red-700">
                        <i class="ti ti-alert-triangle text-lg"></i>
                        <p class="text-sm"><span class="font-semibold">Peringatan: </span>Surat pengantar <span class="font-semibold">tidak valid / tidak dapat diakses / tidak jelas</span> menyebabkan pengajuan kamu ditolak</p>
                    </div>
                </div>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">
        <!-- Requirements Checklist -->
        <div class="card rounded-lg bg-white p-5 dark:bg-[#14181b] transition-all duration-200 col-span-3 mt-6">
            <h3 class="text-lg font-semibold mb-4">Persyaratan Surat Pengantar</h3>
            <div class="space-y-3">
                @php
                    $requirements = [
                        ['Surat resmi dari sekolah/universitas', 'ti-school'],
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

        <div class="col-span-3 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200 mt-0 md:mt-6">
            <div>
                @livewire('upload-surat-pengantar')
            </div>
        </div>
    </div>
@endsection
