@extends('layouts.admin')

@section('title', 'Admin dashboard')

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
        <div class="w-full flex bg-white rounded-lg shadow gap-3 p-3">
            <div class="w-9 h-9 bg-blue-200 text-blue-600 rounded-xl flex items-center justify-center">
                <i class="ti ti-file-search text-2xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-medium">Review Pengajuan</h1>
                <p class="text-2xl font-bold">15</p>
                <p class="text-sm font-normal text-blue-600">+2 perbulan ini</p>
            </div>
        </div>
        <div class="w-full flex bg-white rounded-lg shadow gap-3 p-3">
            <div class="w-9 h-9 bg-blue-200 text-blue-600 rounded-xl flex items-center justify-center">
                <i class="ti ti-text-caption text-2xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-medium">Total Pengajuan</h1>
                <p class="text-2xl font-bold">10</p>
                <p class="text-sm font-normal text-blue-600">+2 perbulan ini</p>
            </div>
        </div>
        <div class="w-full flex bg-white rounded-lg shadow gap-3 p-3">
            <div class="w-9 h-9 bg-blue-200 text-blue-600 rounded-xl flex items-center justify-center">
                <i class="ti ti-users text-2xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-medium">Total Magang</h1>
                <p class="text-2xl font-bold">125</p>
                <p class="text-sm font-normal text-blue-600">+6 perbulan ini</p>
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
                <p class="text-2xl font-bold">25</p>
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
                        Tahun <span id="selectedYear" class="ml-1">2023</span>
                        <svg class="w-2.5 m-2.5 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4" />
                        </svg>
                    </button>

                    <!-- Dropdown Year Menu -->
                    <div id="yearDropdown"
                        class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownYearButton">
                            <li><a href="#" class="block px-4 py-2" onclick="updateChartYear(event, 2023)">2023</a>
                            </li>
                            <li><a href="#" class="block px-4 py-2" onclick="updateChartYear(event, 2024)">2024</a>
                            </li>
                            <li><a href="#" class="block px-4 py-2" onclick="updateChartYear(event, 2025)">2025</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div id="column-chart"></div>
        </div>
    </div>

    <div class="col-span-4 card bg-white dark:bg-gray-800 relative sm:rounded-lg overflow-hidden mt-6">
        <div class="text-xl font-semibold text-gray-900 dark:text-white pt-5 pb-4 px-4 border-b border-gray-200">Daftar Pengajuan</div>
        @livewire('show-daftar-pengajuan')
    </div>

    <script>
       let chartData = {
            2023: [
                { month: "Jan", organic: 100, social: 200 },
                { month: "Feb", organic: 150, social: 180 },
                { month: "Mar", organic: 160, social: 210 },
                { month: "Apr", organic: 120, social: 190 },
                { month: "May", organic: 130, social: 170 },
                { month: "Jun", organic: 140, social: 200 },
                { month: "Jul", organic: 110, social: 220 },
                { month: "Aug", organic: 180, social: 230 },
                { month: "Sep", organic: 150, social: 210 },
                { month: "Oct", organic: 170, social: 240 },
                { month: "Nov", organic: 160, social: 200 },
                { month: "Dec", organic: 170, social: 210 }
            ],
            2024: [
                { month: "Jan", organic: 130, social: 230 },
                { month: "Feb", organic: 110, social: 160 },
                { month: "Mar", organic: 140, social: 180 },
                { month: "Apr", organic: 150, social: 210 },
                { month: "May", organic: 160, social: 190 },
                { month: "Jun", organic: 170, social: 220 },
                { month: "Jul", organic: 180, social: 240 },
                { month: "Aug", organic: 150, social: 200 },
                { month: "Sep", organic: 160, social: 230 },
                { month: "Oct", organic: 140, social: 210 },
                { month: "Nov", organic: 130, social: 220 },
                { month: "Dec", organic: 190, social: 220 }
            ],
            2025: [
                { month: "Jan", organic: 120, social: 210 },
                { month: "Feb", organic: 140, social: 170 },
                { month: "Mar", organic: 150, social: 200 },
                { month: "Apr", organic: 160, social: 190 },
                { month: "May", organic: 130, social: 180 },
                { month: "Jun", organic: 170, social: 220 },
                { month: "Jul", organic: 160, social: 230 },
                { month: "Aug", organic: 180, social: 250 },
                { month: "Sep", organic: 140, social: 210 },
                { month: "Oct", organic: 150, social: 220 },
                { month: "Nov", organic: 180, social: 240 },
                { month: "Dec", organic: 200, social: 230 }
            ]
        };

        let selectedYear = 2023;

        function getSeriesData(year) {
            return [
                {
                    name: "Peserta Masuk",
                    color: "#1c64f2",
                    data: chartData[year].map(item => ({ x: item.month, y: item.organic }))
                },
                {
                    name: "Peserta Keluar",
                    color: "#75b547",
                    data: chartData[year].map(item => ({ x: item.month, y: item.social }))
                }
            ];
        }

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
                show: true,
                labels: {
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

        // Fungsi untuk mengunduh data sebagai CSV
        function downloadCSV() {
            // Membuat header CSV
            let csvContent = "Month,Peserta Masuk,Peserta Keluar\n";
            
            // Menambahkan data untuk tahun yang dipilih
            chartData[selectedYear].forEach(row => {
                csvContent += `${row.month},${row.organic},${row.social}\n`;
            });
            
            // Membuat blob dan link untuk mengunduh
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement("a");
            
            // Membuat URL untuk blob
            const url = window.URL.createObjectURL(blob);
            
            // Mengatur properti link
            link.setAttribute("href", url);
            link.setAttribute("download", `peserta-data-${selectedYear}.csv`);
            
            // Menambahkan link ke dokumen
            document.body.appendChild(link);
            
            // Mengklik link secara programatis
            link.click();
            
            // Membersihkan
            document.body.removeChild(link);
            window.URL.revokeObjectURL(url);
        }
    </script>

@endsection
