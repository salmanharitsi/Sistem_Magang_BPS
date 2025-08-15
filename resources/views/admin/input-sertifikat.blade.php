@extends('layouts.admin')

@section('title', 'Pemberian Sertifikat')

@section('content')

    <div class="grid grid-cols-1 lg:grid-cols-4 lg:gap-x-6 gap-x-0 lg:gap-y-6 gap-y-6">

        <div class="col-span-4 grid grid-cols-1 lg:grid-cols-2 lg:gap-x-6 gap-x-0 lg:gap-y-6 gap-y-6">
            <div class="col-span-1 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
                <div class="flex h-full items-center">
                    <h4 class="text-gray-900 font-semibold text-2xl dark:text-white">
                        Pemberian Sertifikat
                    </h4>
                </div>
            </div>

            <div class="col-span-1 card h-fit rounded-lg bg-white p-5 dark:bg-[#14181b] transition-all duration-200">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div class="flex items-center gap-3">
                        @if (!empty($magang->user->foto_profil))
                            <img id="profile-image" src="{{ Storage::url($magang->user->foto_profil) }}"
                                alt="Preview Foto Profil"
                                class="w-[50px] h-[50px] object-cover rounded-full outline outline-blue-600 cursor-pointer"
                                onclick="openPreview('{{ Storage::url($magang->user->foto_profil) }}')">
                        @else
                            <h1
                                class="flex w-[71px] h-[71px] items-center justify-center text-xl text-white bg-blue-600 rounded-full">
                                {{ strtoupper(substr($magang->user->name, 0, 1)) }}
                            </h1>
                        @endif
                        <div>
                            <div>
                                <h5 class="font-semibold text-xl">{{ $magang->user->name }}</h5>
                            </div>
                            <p class="text-xs text-gray-500">{{ $magang->jenis_magang }}</p>
                        </div>
                    </div>
                    <a href="/daftar-bimbingan/{{ $magang->id }}"
                        class="pjax-link text-sm flex items-center justify-center bg-blue-600 w-full md:w-fit border border-transparent px-3 py-1 rounded-lg text-white hover:bg-blue-100 hover:border hover:border-blue-600 hover:text-blue-600 transition-all duration-200">
                        <i class="ti ti-eye mr-2"></i>
                        Lihat Data Magang
                    </a>
                </div>
            </div>
        </div>

        <div class="col-span-4">
            @livewire('input-sertifikat', ['magang' => $magang->id])
        </div>

    </div>

@endsection
