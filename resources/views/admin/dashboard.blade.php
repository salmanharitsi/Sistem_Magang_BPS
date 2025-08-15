@extends('layouts.admin')

@section('title', 'Admin dashboard')


@section('content')
    @php
        use Carbon\Carbon;
    @endphp


    <style>
        .custom-scrollbar {
            scrollbar-width: thin;
            scrollbar-color: #CBD5E0 #EDF2F7;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #EDF2F7;
            border-radius: 9999px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #CBD5E0;
            border-radius: 9999px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #A0AEC0;
        }

        /* Modal transition effect */
        .hover-modal {
            transition: opacity 0.2s ease, transform 0.2s ease;
            opacity: 0;
            transform: translateY(-10px);
            pointer-events: none;
            position: fixed; /* Changed from absolute to fixed */
            display: none;
            z-index: 50; /* Increased z-index for better stacking */
        }

        .group:hover .hover-modal {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
            display: block;
        }
    </style>


    <div class="w-full h-44 rounded-lg bg-blue-500 relative overflow-hidden">
        <img class="absolute inset-0 w-full h-full object-cover" src="{{ asset('assets/images/usernormal/bg-dash.svg') }}"
            alt="">
        <p class="flex h-full w-full px-6 items-center justify-start text-white text-xl md:text-3xl font-normal">Selamat
            datang di<span class="font-medium ml-1 md:ml-2 z-10">SIMAGANG</span></p>
    </div>

    @if (count($perluSertifikat) > 0)
        <div class="card rounded-lg bg-gradient-to-r from-green-600 to-green-200 p-5 h-full dark:bg-[#14181b] transition-all duration-200 mt-6 cursor-pointer relative" id="perluSertifikatHeader">
            <div class="flex justify-between items-center">
                <div class="text-white font-medium text-xl dark:text-white flex items-center gap-2">
                    Perlu Sertifikat
                    <span class="bg-red-600 text-white text-xs font-medium w-6 h-6 flex items-center justify-center rounded-full">{{ count($perluSertifikat) }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="ti ti-chevron-down text-xl transition-transform duration-300 chevron-icon-sertifikat"></i>
                </div>
            </div>
        </div>

        <div id="perluSertifikatContent" class="max-h-0 overflow-hidden transition-all duration-300">
            <div class="p-0.5 overflow-y-auto mt-4 grid grid-cols-1 gap-4">
                @foreach ($perluSertifikat as $magang)
                    <div class="card h-fit rounded-lg bg-white p-5 dark:bg-[#14181b] transition-all duration-200">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                            <div class="flex items-center gap-3">
                                @if (!empty($magang->user->foto_profil))
                                    <img id="profile-image"
                                        src="{{ Storage::url($magang->user->foto_profil) }}"
                                        alt="Preview Foto Profil"
                                        class="w-[50px] h-[50px] object-cover rounded-full outline outline-blue-600 cursor-pointer"
                                        onclick="openPreview('{{ Storage::url($magang->user->foto_profil) }}')">
                                @else
                                    <h1
                                        class="flex w-[50px] h-[50px] items-center justify-center text-xl text-white bg-blue-600 rounded-full">
                                        {{ strtoupper(substr($magang->user->name, 0, 1)) }}
                                    </h1>
                                @endif
                                <div>
                                    <div>
                                        <h5 class="font-semibold">{{ $magang->user->name }}</h5>
                                    </div>
                                    <p class="text-xs text-gray-500">{{ $magang->jenis_magang }}</p>
                                </div>
                            </div>
                            <a href="/input-sertifikat/{{ $magang->id }}" class="pjax-link w-full md:w-fit text-center bg-green-600 text-white px-3 py-1 rounded-lg hover:bg-green-100 hover:border hover:border-green-600 hover:text-green-600 transition-all duration-200 text-sm">
                                Berikan Sertifikat
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if (count($perluDinilai) > 0)
        <div class="card rounded-lg bg-gradient-to-r from-blue-600 to-blue-200 p-5 h-full dark:bg-[#14181b] transition-all duration-200 mt-6 cursor-pointer relative" id="perluDinilaiHeader">
            <div class="flex justify-between items-center">
                <div class="text-white font-medium text-xl dark:text-white flex items-center gap-2">
                    Perlu Dinilai
                    <span class="bg-red-600 text-white text-xs font-medium w-6 h-6 flex items-center justify-center rounded-full">{{ count($perluDinilai) }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="ti ti-chevron-down text-xl transition-transform duration-300 chevron-icon"></i>
                </div>
            </div>
        </div>

        <div id="perluDinilaiContent" class="max-h-0 overflow-hidden transition-all duration-300">
            <div class="p-0.5 overflow-y-auto mt-4 grid grid-cols-1 gap-4">
                @foreach ($perluDinilai as $magang)
                    <div class="card h-fit rounded-lg bg-white p-5 dark:bg-[#14181b] transition-all duration-200">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                            <div class="flex items-center gap-3">
                                @if (!empty($magang->user->foto_profil))
                                    <img id="profile-image"
                                        src="{{ Storage::url($magang->user->foto_profil) }}"
                                        alt="Preview Foto Profil"
                                        class="w-[50px] h-[50px] object-cover rounded-full outline outline-blue-600 cursor-pointer"
                                        onclick="openPreview('{{ Storage::url($magang->user->foto_profil) }}')">
                                @else
                                    <h1
                                        class="flex w-[50px] h-[50px] items-center justify-center text-xl text-white bg-blue-600 rounded-full">
                                        {{ strtoupper(substr($magang->user->name, 0, 1)) }}
                                    </h1>
                                @endif
                                <div>
                                    <div>
                                        <h5 class="font-semibold">{{ $magang->user->name }}</h5>
                                    </div>
                                    <p class="text-xs text-gray-500">{{ $magang->jenis_magang }}</p>
                                </div>
                            </div>
                            <a href="/penilaian/{{ $magang->id }}" class="pjax-link w-full md:w-fit text-center bg-blue-600 text-white px-3 py-1 rounded-lg hover:bg-blue-100 hover:border hover:border-blue-600 hover:text-blue-600 transition-all duration-200 text-sm">
                                Berikan Penilaian
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div class="relative grid grid-cols-1 mt-6 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">
        <div class="w-full bg-white rounded-lg card dark:bg-gray-800 p-4 !pb-0">
            <div class="flex justify-between pb-4 mb-4 border-b border-gray-200 dark:border-gray-700">
                <div>
                    <h5 class="leading-none text-xl font-semibold text-gray-900 dark:text-white pb-1">Rekapitulasi Peserta
                        Magang
                    </h5>
                    <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Data peserta masuk dan keluar setiap
                        bulan</p>
                </div>
                <div class="flex items-center gap-4"> <!-- Added flex container for buttons -->
                    <!-- Download Button -->

                    <!-- Year Dropdown -->
                    <button id="dropdownYearButtonRekap" data-dropdown-toggle="yearDropdownRekap"
                        data-dropdown-placement="bottom"
                        class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 text-center inline-flex items-center dark:hover:text-white"
                        type="button">
                        Tahun <span id="selectedYearRekap" class="ml-1">{{ $selectedYear }}</span>
                        <svg class="w-2.5 m-2.5 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4" />
                        </svg>
                    </button>

                    <!-- Dropdown Year Menu -->
                    <div id="yearDropdownRekap"
                        class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg card w-44 dark:bg-gray-700">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownYearButton">
                            <li><a href="#" class="block px-4 py-2" onclick="updateData(event, 2025)">2025</a>
                            </li>
                            <li><a href="#" class="block px-4 py-2" onclick="updateData(event, 2026)">2026</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Carousel Rekapitulation -->
            <div id="month-carousel" class="flex gap-4 overflow-x-auto p-4 custom-scrollbar relative">
                @foreach ($monthlyStats as $index => $stat)
                    <div class="flex-shrink-0 group" data-month="{{ $stat['month'] }}">
                        <div class="bg-white rounded-lg card p-4 w-32">
                            <div class="flex items-center justify-center mb-3">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="ml-2 font-semibold text-gray-800">{{ $stat['month'] }}</span>
                            </div>

                            <div class="flex justify-center gap-4">
                                <div class="text-center">
                                    <div class="text-green-500">
                                        <svg class="w-4 h-4 mx-auto mb-1 rotate-180" xmlns="http://www.w3.org/2000/svg"
                                            width="256" height="256" viewBox="0 0 256 256">
                                            <g fill="#057A55">
                                                <path
                                                    d="M215.46 216H40.54c-12.62 0-20.54-13.21-14.41-23.91l87.46-151.87c6.3-11 22.52-11 28.82 0l87.46 151.87c6.13 10.7-1.79 23.91-14.41 23.91"
                                                    opacity="0.2" />
                                                <path
                                                    d="M236.8 188.09L149.35 36.22a24.76 24.76 0 0 0-42.7 0L19.2 188.09a23.51 23.51 0 0 0 0 23.72A24.34 24.34 0 0 0 40.55 224h174.9a24.34 24.34 0 0 0 21.33-12.19a23.51 23.51 0 0 0 .02-23.72m-13.87 15.71a8.5 8.5 0 0 1-7.48 4.2H40.55a8.5 8.5 0 0 1-7.48-4.2a7.59 7.59 0 0 1 0-7.72l87.45-151.87a8.75 8.75 0 0 1 15 0l87.45 151.87a7.59 7.59 0 0 1-.04 7.72" />
                                            </g>
                                        </svg>
                                        <span class="block text-sm">{{ $stat['in'] }}</span>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <div class="text-red-500">
                                        <svg class="w-4 h-4 mx-auto mb-1" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 256 256">
                                            <g fill="#f00">
                                                <path
                                                    d="M215.46 216H40.54c-12.62 0-20.54-13.21-14.41-23.91l87.46-151.87c6.3-11 22.52-11 28.82 0l87.46 151.87c6.13 10.7-1.79 23.91-14.41 23.91"
                                                    opacity="0.2" />
                                                <path
                                                    d="M236.8 188.09L149.35 36.22a24.76 24.76 0 0 0-42.7 0L19.2 188.09a23.51 23.51 0 0 0 0 23.72A24.34 24.34 0 0 0 40.55 224h174.9a24.34 24.34 0 0 0 21.33-12.19a23.51 23.51 0 0 0 .02-23.72m-13.87 15.71a8.5 8.5 0 0 1-7.48 4.2H40.55a8.5 8.5 0 0 1-7.48-4.2a7.59 7.59 0 0 1 0-7.72l87.45-151.87a8.75 8.75 0 0 1 15 0l87.45 151.87a7.59 7.59 0 0 1-.04 7.72" />
                                            </g>
                                        </svg>
                                        <span class="block text-sm">{{ $stat['out'] }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Hover Modal-->
                        <div class="hover-modal">
                            <div class="bg-white rounded-lg shadow-lg p-4 w-72 border border-gray-200">
                                <h4 class="font-semibold text-gray-800 border-b pb-2 mb-3">Detail {{ $stat['month'] }} {{ $selectedYear }}</h4>
                                
                                @if(!empty($stat['departmentStats']))
                                    <div class="mb-3">
                                        <h5 class="font-medium text-green-600 mb-1 flex items-center">
                                            <svg class="w-3 h-3 mr-1 rotate-180" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                                <g fill="#057A55">
                                                    <path d="M236.8 188.09L149.35 36.22a24.76 24.76 0 0 0-42.7 0L19.2 188.09a23.51 23.51 0 0 0 0 23.72A24.34 24.34 0 0 0 40.55 224h174.9a24.34 24.34 0 0 0 21.33-12.19a23.51 23.51 0 0 0 .02-23.72" />
                                                </g>
                                            </svg>
                                            Peserta Masuk ({{ $stat['in'] }})
                                        </h5>
                                        <div class="max-h-36 overflow-y-auto custom-scrollbar pl-2">
                                            @forelse($stat['departmentStats']['in'] as $dept => $count)
                                                <div class="flex justify-between py-1 text-sm">
                                                    <span class="text-gray-700">{{ $dept }}</span>
                                                    <span class="font-medium">{{ $count }}</span>
                                                </div>
                                            @empty
                                                <p class="text-sm text-gray-500 italic">Tidak ada data</p>
                                            @endforelse
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <h5 class="font-medium text-red-600 mb-1 flex items-center">
                                            <svg class="w-3 h-3 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                                <g fill="#f00">
                                                    <path d="M236.8 188.09L149.35 36.22a24.76 24.76 0 0 0-42.7 0L19.2 188.09a23.51 23.51 0 0 0 0 23.72A24.34 24.34 0 0 0 40.55 224h174.9a24.34 24.34 0 0 0 21.33-12.19a23.51 23.51 0 0 0 .02-23.72" />
                                                </g>
                                            </svg>
                                            Peserta Keluar ({{ $stat['out'] }})
                                        </h5>
                                        <div class="max-h-36 overflow-y-auto custom-scrollbar pl-2">
                                            @forelse($stat['departmentStats']['out'] as $dept => $count)
                                                <div class="flex justify-between py-1 text-sm">
                                                    <span class="text-gray-700">{{ $dept }}</span>
                                                    <span class="font-medium">{{ $count }}</span>
                                                </div>
                                            @empty
                                                <p class="text-sm text-gray-500 italic">Tidak ada data</p>
                                            @endforelse
                                        </div>
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500 italic">Fungsi Bagian tidak tersedia</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 mt-6 lg:grid-cols-3 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">
        <div class="w-full flex bg-white rounded-lg card gap-3 p-3">
            <div class="w-9 h-9 bg-blue-200 text-blue-600 rounded-xl flex items-center justify-center">
                <i class="ti ti-file-search text-2xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-medium">Review Pengajuan</h1>
                <p class="text-2xl font-bold">{{ $reviewPengajuan }}</p>
                <p class="text-sm font-normal text-blue-600">+{{ $pengajuanBulanIni ?? 0 }} perbulan ini</p>
            </div>
        </div>
        <div class="w-full flex bg-white rounded-lg card gap-3 p-3">
            <div class="w-9 h-9 bg-blue-200 text-blue-600 rounded-xl flex items-center justify-center">
                <i class="ti ti-text-caption text-2xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-medium">Total Pengajuan</h1>
                <p class="text-2xl font-bold">{{ $totalPengajuan ?? 0 }}</p>
                <p class="text-sm font-normal text-blue-600">+{{ $pengajuanBulanIni ?? 0 }} perbulan ini</p>
            </div>
        </div>
        <div class="w-full flex bg-white rounded-lg card gap-3 p-3">
            <div class="w-9 h-9 bg-blue-200 text-blue-600 rounded-xl flex items-center justify-center">
                <i class="ti ti-users text-2xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-medium">Total Magang</h1>
                <p class="text-2xl font-bold">{{ $totalMagang ?? 0 }}</p>
                <p class="text-sm font-normal text-blue-600">+{{ $magangBulanIni ?? 0 }} perbulan ini</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 mt-6 lg:grid-cols-2 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">
        <div class="w-full flex bg-white rounded-lg card gap-3 p-3">
            <div class="w-9 h-9 bg-blue-200 text-blue-600 rounded-xl flex items-center justify-center">
                <i class="ti ti-users text-2xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-medium">Peserta Magang Aktif</h1>
                <p class="text-2xl font-bold">{{ $magangActive ?? 0 }}</p>
                <p class="text-sm font-normal text-blue-600">+{{ $magangAktifBulanIni ?? 0 }} perbulan ini</p>
            </div>
        </div>
        <div class="w-full flex bg-white rounded-lg card gap-3 p-3">
            <div class="w-9 h-9 bg-blue-200 text-blue-600 rounded-xl flex items-center justify-center">
                <i class="ti ti-users text-2xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-medium">Peserta Magang Selesai</h1>
                <p class="text-2xl font-bold">{{ $magangSelesai ?? 0 }}</p>
                <p class="text-sm font-normal text-blue-600">+{{ $magangSelesaiBulanIni ?? 0 }} perbulan ini</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 mt-6 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">
        <div class="w-full bg-white rounded-lg card dark:bg-gray-800 p-4 !pb-0">
            <div class="flex justify-between pb-4 mb-4 border-b border-gray-200 dark:border-gray-700">
                <div>
                    <h5 class="leading-none text-xl font-semibold text-gray-900 dark:text-white pb-1">Grafik Peserta Magang
                    </h5>
                    <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Data bulanan per tahun</p>
                </div>
                <div class="flex items-center gap-4"> <!-- Added flex container for buttons -->
                    <!-- Download Button -->
                    <button onclick="downloadCSV()"
                        class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white inline-flex items-center">
                        <i class="ti ti-file-download text-xl"></i>
                        Download CSV
                    </button>

                    <!-- Year Dropdown -->
                    <button id="dropdownYearButton" data-dropdown-toggle="yearDropdown" data-dropdown-placement="bottom"
                        class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 text-center inline-flex items-center dark:hover:text-white"
                        type="button">
                        Tahun <span id="selectedYear" class="ml-1">{{ $selectedYear }}</span>
                        <svg class="w-2.5 m-2.5 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4" />
                        </svg>
                    </button>

                    <!-- Dropdown Year Menu -->
                    <div id="yearDropdown"
                        class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg card w-44 dark:bg-gray-700">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownYearButton">
                            <li><a href="#" class="block px-4 py-2" onclick="updateChartYear(event, 2025)">2025</a>
                            </li>
                            <li><a href="#" class="block px-4 py-2" onclick="updateChartYear(event, 2026)">2026</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div id="column-chart"></div>
        </div>
    </div>

    @if ($reviewPengajuan)
        <div class="col-span-4 card bg-white dark:bg-gray-800 relative rounded-lg overflow-hidden mt-6">
            <div class="text-xl font-semibold text-gray-900 dark:text-white pt-5 pb-4 px-4 border-b border-gray-200">Daftar
                Pengajuan</div>
            @livewire('show-daftar-pengajuan')
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Script untuk Perlu Dinilai
            const dinilaiHeader = document.getElementById('perluDinilaiHeader');
            const dinilaiContent = document.getElementById('perluDinilaiContent');
            const dinilaiChevron = document.querySelector('.chevron-icon');
            
            if (dinilaiHeader && dinilaiContent && dinilaiChevron) {
                dinilaiHeader.addEventListener('mouseenter', function() {
                    dinilaiChevron.classList.add('text-blue-600');
                });
                
                dinilaiHeader.addEventListener('mouseleave', function() {
                    if (!dinilaiContent.classList.contains('expanded')) {
                        dinilaiChevron.classList.remove('text-blue-600');
                    }
                });
                
                dinilaiHeader.addEventListener('click', function() {
                    if (dinilaiContent.classList.contains('expanded')) {
                        dinilaiContent.style.maxHeight = '0px';
                        dinilaiContent.classList.remove('expanded');
                        dinilaiChevron.classList.remove('rotate-180');
                    } else {
                        dinilaiContent.style.maxHeight = dinilaiContent.scrollHeight + 'px';
                        dinilaiContent.classList.add('expanded');
                        dinilaiChevron.classList.add('rotate-180');
                    }
                });
            }
            
            // Script untuk Perlu Sertifikat
            const sertifikatHeader = document.getElementById('perluSertifikatHeader');
            const sertifikatContent = document.getElementById('perluSertifikatContent');
            const sertifikatChevron = document.querySelector('.chevron-icon-sertifikat');
            
            if (sertifikatHeader && sertifikatContent && sertifikatChevron) {
                sertifikatHeader.addEventListener('mouseenter', function() {
                    sertifikatChevron.classList.add('text-green-600');
                });
                
                sertifikatHeader.addEventListener('mouseleave', function() {
                    if (!sertifikatContent.classList.contains('expanded')) {
                        sertifikatChevron.classList.remove('text-green-600');
                    }
                });
                
                sertifikatHeader.addEventListener('click', function() {
                    if (sertifikatContent.classList.contains('expanded')) {
                        sertifikatContent.style.maxHeight = '0px';
                        sertifikatContent.classList.remove('expanded');
                        sertifikatChevron.classList.remove('rotate-180');
                    } else {
                        sertifikatContent.style.maxHeight = sertifikatContent.scrollHeight + 'px';
                        sertifikatContent.classList.add('expanded');
                        sertifikatChevron.classList.add('rotate-180');
                    }
                });
            }
        });
    </script>

    <script>
        // hover modal positioning
        document.addEventListener('DOMContentLoaded', function() {
            const monthCards = document.querySelectorAll('#month-carousel .group');
            const carousel = document.getElementById('month-carousel');
            
            monthCards.forEach(card => {
                const modal = card.querySelector('.hover-modal');
                
                // position on hover
                card.addEventListener('mouseenter', function() {
                    // Get position of the card relative to viewport
                    const cardRect = card.getBoundingClientRect();
                    const carouselRect = carousel.getBoundingClientRect();
                    
                    // Modal dimensions 
                    const modalWidth = 288; 
                    
                    
                    let top = cardRect.bottom + 10;
                    let left = cardRect.left;
                    
                    //  batas kanan carousel
                    const carouselRight = carouselRect.right;
                    // Jika modal keluar dari carousel, geser ke kiri
                    if (left + modalWidth > carouselRight) {
                        left = carouselRight - modalWidth - 10; // 10px padding
                    }
                    // Pastikan tidak keluar ke kiri juga
                    if (left < carouselRect.left) {
                        left = carouselRect.left + 10;
                    }
                    
                    // Apply position
                    modal.style.top = `${top}px`;
                    modal.style.left = `${left}px`;
                });
            });
            
            //  positions when scrolling the carousel
            carousel.addEventListener('scroll', function() {
                // Find currently hovered card if any
                const hoveredCard = document.querySelector('#month-carousel .group:hover');
                if (hoveredCard) {
                    // Trigger mouseenter to recalculate position
                    const event = new MouseEvent('mouseenter', {
                        view: window,
                        bubbles: true,
                        cancelable: true
                    });
                    hoveredCard.dispatchEvent(event);
                }
            });
        });
        
        // Original script content follows...
        let chartData = @json($chartData);
        let years = @json($years);

        //  initial selected year to the most recent year
        let selectedYear = 2025;

        function getSeriesData(year) {
            return [{
                    name: "Peserta Masuk",
                    color: "#1c64f2",
                    data: chartData[year].map(item => ({
                        x: item.month,
                        y: Math.round(item.masuk)
                    }))
                },
                {
                    name: "Peserta Keluar",
                    color: "#75b547",
                    data: chartData[year].map(item => ({
                        x: item.month,
                        y: Math.round(item.keluar)
                    }))
                }
            ];
        }


        // Update the year dropdown options
        const yearDropdown = document.getElementById("yearDropdown").querySelector("ul");
        yearDropdown.innerHTML = years.map(year =>
            `<li><a href="#" class="block px-4 py-2" onclick="updateChartYear(event, ${year})">${year}</a></li>`
        ).join('');

        const yearDropdownRekap = document.getElementById("yearDropdownRekap").querySelector("ul");
        yearDropdownRekap.innerHTML = years.map(year =>
            `<li><a href="#" class="block px-4 py-2" onclick="updateData(event, ${year})">${year}</a></li>`
        ).join('');

        // Update the initial selected year display
        document.getElementById("selectedYear").textContent = selectedYear;

        const options = {
            colors: ["#1c64f2", "#75b547"],
            series: getSeriesData(selectedYear),
            chart: {
                type: "bar",
                height: "320px",
                fontFamily: "Inter, sans-serif",
                toolbar: {
                    show: false,
                },
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: "70%",
                },
            },
            tooltip: {
                shared: true,
                intersect: false,
                style: {
                    fontFamily: "Inter, sans-serif",
                },
            },
            states: {
                hover: {
                    filter: {
                        type: "darken",
                        value: 1,
                    },
                },
            },
            stroke: {
                show: true,
                width: 0,
                colors: ["transparent"],
            },
            grid: {
                show: false,
                strokeDashArray: 4,
                padding: {
                    left: 2,
                    right: 2,
                    top: -14
                },
            },
            dataLabels: {
                enabled: true,
                formatter: function(val) {
                    return Math.round(val);
                }
            },
            legend: {
                show: true,
                position: "top",
            },
            xaxis: {
                categories: chartData[selectedYear].map(item => item.month),
                labels: {
                    style: {
                        fontFamily: "Inter, sans-serif",
                        cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
                    }
                }
            },
            yaxis: {
                min: 0,
                max: 4,
                tickAmount: 4,
                labels: {
                    formatter: function(val) {
                        return Math.floor(val);
                    },
                    style: {
                        fontFamily: "Inter, sans-serif",
                        cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
                    }
                }
            },
            fill: {
                opacity: 1,
            }
        };

        const chart = new ApexCharts(document.getElementById("column-chart"), options);
        chart.render();

        function updateChartYear(event, year) {
            event.preventDefault();
            selectedYear = year;
            document.getElementById("selectedYear").textContent = year;
            chart.updateSeries(getSeriesData(year));
        }

        function updateData(event, year) {
            event.preventDefault();
            selectedYear = year;
            document.getElementById("selectedYear").textContent = year;
            window.location.href = `{{ route('admin.dashboard') }}?year=${year}`;
        }

        // Fungsi untuk mengunduh data sebagai CSV
        function downloadCSV() {
            let csvContent = "Month,Peserta Masuk,Peserta Keluar\n";

            chartData[selectedYear].forEach(row => {
                csvContent += `${row.month},${Math.round(row.masuk)},${Math.round(row.keluar)}\n`;
            });

            const blob = new Blob([csvContent], {
                type: 'text/csv;charset=utf-8;'
            });
            const link = document.createElement("a");
            const url = window.URL.createObjectURL(blob);

            link.setAttribute("href", url);
            link.setAttribute("download", `peserta-data-${selectedYear}.csv`);
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            window.URL.revokeObjectURL(url);
        }

        function openPreview(url) {
            const screenWidth = window.screen.width;
            const screenHeight = window.screen.height;
            const width = screenWidth / 2;
            const height = screenHeight / 2;
            const left = (screenWidth - width) / 2;
            const top = (screenHeight - height) / 2;

            const newWindow = window.open(
                '',
                '',
                `width=${width},height=${height},top=${top},left=${left}`
            );

            if (newWindow) {
                newWindow.document.write('<img src="' + url + '" style="width:100%;height:auto;">');
                newWindow.document.title = "Image Preview";
            } else {
                alert('Preview dokumen tidak tersedia di tampilan mobile');
            }
        }
    </script>

@endsection
