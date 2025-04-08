@extends('layouts.pembimbing')

@section('title', 'Pembimbing dashboard')

@section('content')
    @php
        use Carbon\Carbon;

        $chartData = $bimbinganActive->map(function($magang) {
            return [
                'hadir' => $magang->attendance_stats['hadir'],
                'izin' => $magang->attendance_stats['izin'],
                'tidak_hadir' => $magang->attendance_stats['tidak_hadir']
            ];
        })->toJson();
    @endphp

    <div class="w-full h-44 rounded-lg bg-blue-500 relative overflow-hidden">
        <img class="absolute inset-0 w-full h-full object-cover" src="{{ asset('assets/images/usernormal/bg-dash.svg') }}"
            alt="">
        <p class="flex h-full w-full px-6 items-center justify-start text-white text-xl md:text-3xl font-normal">Selamat
            datang di<span class="font-medium ml-1 md:ml-2 z-10">SIMAGANG</span></p>
    </div>

    <div class="grid grid-cols-1 mt-6 lg:grid-cols-3 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">
        <div class="w-full flex bg-white rounded-lg card gap-3 p-3">
            <div class="w-9 h-9 bg-blue-200 text-blue-600 rounded-xl flex items-center justify-center">
                <i class="ti ti-users text-2xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-medium">Total Bimbingan</h1>
                <p class="text-2xl font-bold">10</p>
                <p class="text-sm font-normal text-blue-600">+2 perbulan ini</p>
            </div>
        </div>
        <div class="w-full flex bg-white rounded-lg card gap-3 p-3">
            <div class="w-9 h-9 bg-blue-200 text-blue-600 rounded-xl flex items-center justify-center">
                <i class="ti ti-users text-2xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-medium">Bimbingan Selesai</h1>
                <p class="text-2xl font-bold">8</p>
                <p class="text-sm font-normal text-blue-600">+5 perbulan ini</p>
            </div>
        </div>
        <div class="w-full flex bg-white rounded-lg card gap-3 p-3">
            <div class="w-9 h-9 bg-blue-200 text-blue-600 rounded-xl flex items-center justify-center">
                <i class="ti ti-users text-2xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-medium">Bimbingan Aktif</h1>
                <p class="text-2xl font-bold">2</p>
                <p class="text-sm font-normal text-blue-600">+2 perbulan ini</p>
            </div>
        </div>
    </div>


    @if (count($bimbinganActive) > 0)
        <div class="mt-6 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
            <div class="">
                <h4 class="text-gray-900 font-semibold text-xl dark:text-white">
                    Bimbingan Aktif
                </h4>
            </div>
        </div>

        <div class="relative mt-6">
            <!-- Carousel container -->
            <div id="bimbingan-carousel" class="overflow-hidden">
                <div class="carousel-inner flex transition-transform duration-300 ease-in-out">
                    @foreach ($bimbinganActive as $index => $pesertaMagang)
                        <div class="carousel-item w-full flex-shrink-0" data-index="{{ $index }}">
                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 px-[70px] py-0.5">
                                <div class="card h-fit p-5 rounded-lg bg-white">
                                    <div class="flex justify-between items-start gap-4">
                                        @if (!empty($pesertaMagang->user->foto_profil))
                                            <img id="profile-image"
                                                src="{{ Storage::url($pesertaMagang->user->foto_profil) }}"
                                                alt="Preview Foto Profil"
                                                class="w-[71px] h-[71px] object-cover rounded-full outline outline-blue-600 cursor-pointer"
                                                onclick="openPreview('{{ Storage::url($pesertaMagang->user->foto_profil) }}')">
                                        @else
                                            <h1
                                                class="flex w-[71px] h-[71px] items-center justify-center text-xl text-white bg-blue-600 rounded-full">
                                                {{ strtoupper(substr($pesertaMagang->user->name, 0, 1)) }}
                                            </h1>
                                        @endif
                                        <div>
                                            <a href=""
                                                class="pjax-link mx-auto w-fit flex items-center gap-1 bg-blue-600 border border-transparent px-2 py-2 rounded-lg text-white hover:bg-blue-100 hover:border hover:border-blue-600 hover:text-blue-600 transition-all duration-200">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="flex flex-col mt-4">
                                        <h1 class="text-lg font-semibold">{{ $pesertaMagang->user->name }}</h1>
                                        <h4 class="text-gray-500 text-sm">{{ $pesertaMagang->user->institusi }}</h4>
                                        <div class="text-xs w-fit mt-3 px-2 py-1 rounded-md bg-blue-100 text-blue-600 border border-blue-600">
                                            <p>{{ $pesertaMagang->jenis_magang }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card p-5 rounded-lg bg-white">
                                    <h4 class="text-lg font-semibold mb-4">Grafik Presensi</h4>
                                        <!-- Line Chart -->
                                        <div class="pie-chart-container relative" id="pie-chart-{{ $index }}"></div>
                                </div>
                                <div class="card p-5 rounded-lg bg-white">
                                    <h4 class="text-lg font-semibold mb-4">Grafik Logbook</h4>
                                    {{-- Implement your logbook chart here --}}
                                    <div class="h-fit flex items-center justify-center bg-gray-100 rounded">
                                        <span class="text-gray-500">Grafik Logbook akan ditampilkan di sini</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Carousel navigation buttons -->
            <button id="prev-btn"
                class="absolute top-1/2 left-2 transform -translate-y-1/2 bg-blue-500 text-white rounded-full w-10 h-10 shadow-lg hover:bg-blue-600 focus:outline-none">
                <i class="ti ti-chevron-left text-xl"></i>
            </button>
            <button id="next-btn"
                class="absolute top-1/2 right-2 transform -translate-y-1/2 bg-blue-500 text-white rounded-full w-10 h-10 shadow-lg hover:bg-blue-600 focus:outline-none">
                <i class="ti ti-chevron-right text-xl"></i>
            </button>

        </div>
    @else
        <div class="mt-6 card rounded-lg bg-white p-5 h-full dark:bg-[#14181b] transition-all duration-200">
            <div
                class="w-full h-fit flex gap-3 items-center p-3 bg-amber-100 rounded-lg border text-amber-700 border-amber-700">
                <i class="ti ti-alert-circle text-lg"></i>
                <p class="text-sm">Tidak ada bimbingan yang aktif</p>
            </div>
        </div>
    @endif

    @if ($allBimbinganCount)
        <div class="col-span-4 card bg-white dark:bg-gray-800 relative sm:rounded-lg overflow-hidden mt-6">
            <div class="text-xl font-semibold text-gray-900 dark:text-white pt-5 pb-4 px-5 border-b border-gray-200">
                Daftar Bimbingan</div>
            @livewire('show-daftar-bimbingan')
        </div>
    @endif

    <!-- Carousel JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const carousel = document.getElementById('bimbingan-carousel');
            const carouselInner = carousel.querySelector('.carousel-inner');
            const items = carousel.querySelectorAll('.carousel-item');
            const prevBtn = document.getElementById('prev-btn');
            const nextBtn = document.getElementById('next-btn');
            const indicators = document.querySelectorAll('.carousel-indicator');
    
            let currentIndex = 0;
            const totalItems = items.length;
    
            // Initialize charts for all slides
            initializeAllCharts();
    
            // Set first indicator as active
            if (indicators.length > 0) {
                indicators[0].classList.add('bg-blue-500');
            }
    
            // Event listeners for buttons
            prevBtn.addEventListener('click', () => {
                currentIndex = (currentIndex - 1 + totalItems) % totalItems;
                updateCarousel();
            });
    
            nextBtn.addEventListener('click', () => {
                currentIndex = (currentIndex + 1) % totalItems;
                updateCarousel();
            });
    
            // Event listeners for indicators
            indicators.forEach(indicator => {
                indicator.addEventListener('click', () => {
                    currentIndex = parseInt(indicator.dataset.index);
                    updateCarousel();
                });
            });
    
            function updateCarousel() {
                // Update transform to show current item
                carouselInner.style.transform = `translateX(-${currentIndex * 100}%)`;
    
                // Update indicators
                indicators.forEach((indicator, index) => {
                    if (index === currentIndex) {
                        indicator.classList.add('bg-blue-500');
                        indicator.classList.remove('bg-gray-300');
                    } else {
                        indicator.classList.remove('bg-blue-500');
                        indicator.classList.add('bg-gray-300');
                    }
                });
            }
    
            function initializeAllCharts() {
                items.forEach((item, index) => {
                    const chartContainer = item.querySelector('.pie-chart-container');
                    if (chartContainer && typeof ApexCharts !== 'undefined') {
                        const chartId = `pie-chart-${index}`;
                        chartContainer.id = chartId;
                        
                        const magangData = @json($bimbinganActive);
                        const currentMagang = magangData[index];
                        
                        const chart = new ApexCharts(document.getElementById(chartId), 
                            getChartOptions(
                                currentMagang.attendance_stats.hadir,
                                currentMagang.attendance_stats.izin,
                                currentMagang.attendance_stats.tidak_hadir
                            )
                        );
                        chart.render();
                        chartContainer._chart = chart;
                    }
                });
            }
    
            function getChartOptions(hadir = 0, izin = 0, tidakHadir = 0) {
                // Calculate percentages only for non-waiting statuses
                const total = hadir + izin + tidakHadir;
                let series, labels;
                
                if (total > 0) {
                    series = [
                        (hadir / total) * 100,
                        (izin / total) * 100,
                        (tidakHadir / total) * 100
                    ];
                    labels = ["Hadir", "Izin", "Tidak Hadir"];
                } else {
                    series = [100]; // Show 100% "No Data" if no records
                    labels = ["Belum Ada Data"];
                }

                return {
                    series: series,
                    colors: ["#0e9f6e", "#f59e0b", "#f05252"], 
                    chart: {
                        height: 250,
                        width: "100%",
                        type: "pie",
                    },
                    stroke: {
                        colors: ["white"],
                        lineCap: "",
                    },
                    plotOptions: {
                        pie: {
                            labels: {
                                show: true,
                            },
                            size: "100%",
                            dataLabels: {
                                offset: -25
                            }
                        },
                    },
                    labels: labels,
                    dataLabels: {
                        enabled: true,
                        formatter: function(val, opts) {
                            if (total === 0) return "No Data";
                            return Math.round(val) + "%";
                        },
                        style: {
                            fontFamily: "Inter, sans-serif",
                        },
                    },
                    legend: {
                        position: "bottom",
                        fontFamily: "Inter, sans-serif",
                    },
                    tooltip: {
                        enabled: true,
                        y: {
                            formatter: function(value, { seriesIndex }) {
                                if (total === 0) return "No Data";
                                const count = [hadir, izin, tidakHadir][seriesIndex];
                                return `${labels[seriesIndex]}: ${count} (${Math.round(value)}%)`;
                            }
                        }
                    }
                }
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
        });
    </script>
@endsection
