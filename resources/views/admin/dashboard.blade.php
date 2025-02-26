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
    </style>


    <div class="w-full h-44 rounded-lg bg-blue-500 relative overflow-hidden">
        <img class="absolute inset-0 w-full h-full object-cover" src="{{ asset('assets/images/usernormal/bg-dash.svg') }}"
            alt="">
        <p class="flex h-full w-full px-6 items-center justify-start text-white text-xl md:text-3xl font-normal">Selamat
            datang di<span class="font-medium ml-1 md:ml-2 z-10">SIMAGANG</span></p>
    </div>

    <div class="grid grid-cols-1 mt-6 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">
        <div class="w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 !pb-0">
            <div class="flex justify-between pb-4 mb-4 border-b border-gray-200 dark:border-gray-700">
                <div>
                    <h5 class="leading-none text-xl font-semibold text-gray-900 dark:text-white pb-1">Rekapitulasi Peserta
                        Magang
                    </h5>
                    <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Data bulanan per tahun</p>
                </div>
                <div class="flex items-center gap-4"> <!-- Added flex container for buttons -->
                    <!-- Download Button -->

                    <!-- Year Dropdown -->
                    <button id="dropdownYearButtonRekap" data-dropdown-toggle="yearDropdownRekap"
                        data-dropdown-placement="bottom"
                        class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 text-center inline-flex items-center dark:hover:text-white"
                        type="button">
                        Tahun <span id="selectedYearRekap" class="ml-1">2025</span>
                        <svg class="w-2.5 m-2.5 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4" />
                        </svg>
                    </button>

                    <!-- Dropdown Year Menu -->
                    <div id="yearDropdownRekap"
                        class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownYearButton">
                            <li><a href="#" class="block px-4 py-2" onclick="updateData(event, 2025)">2025</a>
                            </li>
                            <li><a href="#" class="block px-4 py-2" onclick="updateData(event, 2026)">2026</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Create a partial: resources/views/components/month-carousel.blade.php -->
            <div class="flex gap-4 overflow-x-auto p-4 custom-scrollbar">
                @foreach ($monthlyStats as $stat)
                    <div class="flex-shrink-0">
                        <div class="bg-white rounded-lg shadow-md p-4 w-32">
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
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 mt-6 lg:grid-cols-3 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">
        <div class="w-full flex bg-white rounded-lg shadow gap-3 p-3">
            <div class="w-9 h-9 bg-blue-200 text-blue-600 rounded-xl flex items-center justify-center">
                <i class="ti ti-file-search text-2xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-medium">Review Pengajuan</h1>
                <p class="text-2xl font-bold">{{ $reviewPengajuan }}</p>
                <p class="text-sm font-normal text-blue-600">+{{ $pengajuanBulanIni ?? 0 }} perbulan ini</p>
            </div>
        </div>
        <div class="w-full flex bg-white rounded-lg shadow gap-3 p-3">
            <div class="w-9 h-9 bg-blue-200 text-blue-600 rounded-xl flex items-center justify-center">
                <i class="ti ti-text-caption text-2xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-medium">Total Pengajuan</h1>
                <p class="text-2xl font-bold">{{ $totalPengajuan ?? 0 }}</p>
                <p class="text-sm font-normal text-blue-600">+{{ $pengajuanBulanIni ?? 0 }} perbulan ini</p>
            </div>
        </div>
        <div class="w-full flex bg-white rounded-lg shadow gap-3 p-3">
            <div class="w-9 h-9 bg-blue-200 text-blue-600 rounded-xl flex items-center justify-center">
                <i class="ti ti-users text-2xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-medium">Total Magang</h1>
                <p class="text-2xl font-bold">{{ $totalMagang ??  0 }}</p>
                <p class="text-sm font-normal text-blue-600">+{{ $magangBulanIni ?? 0 }} perbulan ini</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 mt-6 lg:grid-cols-2 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">
        <div class="w-full flex bg-white rounded-lg shadow gap-3 p-3">
            <div class="w-9 h-9 bg-blue-200 text-blue-600 rounded-xl flex items-center justify-center">
                <i class="ti ti-users text-2xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-medium">Peserta Magang Aktif</h1>
                <p class="text-2xl font-bold">{{ $magangActive ?? 0 }}</p>
                <p class="text-sm font-normal text-blue-600">+10 perbulan ini</p>
            </div>
        </div>
        <div class="w-full flex bg-white rounded-lg shadow gap-3 p-3">
            <div class="w-9 h-9 bg-blue-200 text-blue-600 rounded-xl flex items-center justify-center">
                <i class="ti ti-users text-2xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-medium">Peserta Magang Selesai</h1>
                <p class="text-2xl font-bold">100</p>
                <p class="text-sm font-normal text-blue-600">+10 perbulan ini</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 mt-6 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">
        <div class="w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 !pb-0">
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
                        Tahun <span id="selectedYear" class="ml-1">2025</span>
                        <svg class="w-2.5 m-2.5 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4" />
                        </svg>
                    </button>

                    <!-- Dropdown Year Menu -->
                    <div id="yearDropdown"
                        class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
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

    <div class="col-span-4 card bg-white dark:bg-gray-800 relative sm:rounded-lg overflow-hidden mt-6">
        <div class="text-xl font-semibold text-gray-900 dark:text-white pt-5 pb-4 px-4 border-b border-gray-200">Daftar
            Pengajuan</div>
        @livewire('show-daftar-pengajuan')
    </div>

    <script>
        let chartData = @json($chartData);
        let years = @json($years);

        // Set initial selected year to the most recent year
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
    </script>

@endsection
