<div class="card p-5 rounded-lg bg-white">
    <div class="text-xl font-semibold">Presensi</div>
    @if ($todayPresensi && $todayPresensi->status === 'waiting' && !$todayPresensi->tanggal->isWeekend())
        <div class="w-full h-fit p-3 mt-5 flex flex-col md:flex-row items-start gap-3 md:items-center justify-between bg-amber-100 rounded-lg border text-amber-700 border-amber-700">
            <div class="flex gap-3 items-start lg:items-center">
                <i class="ti ti-alert-circle text-lg"></i>
                <p class="text-sm">Kamu belum melaporkan kehadiran hari ini</p>
            </div>
            <a href="/presensi"
                class="pjax-link bg-amber-600 ml-7 md:ml-0 border border-transparent px-3 py-1 rounded-lg text-white hover:bg-amber-100 hover:border hover:border-amber-600 hover:text-amber-600 transition-all duration-200">
                <p class="text-sm whitespace-nowrap">Lapor</p>
            </a>
        </div>
    @endif
    <div class="mt-6" id="attendance-pie-chart">
        <!-- Fallback message container -->
        <div id="chart-fallback-message" class="hidden text-center p-4 text-red-800 bg-red-50 rounded-lg">
            Grafik gagal ditampilkan!
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:initialized', function() {
        setTimeout(() => {
            try {
                initChart();
            } catch (error) {
                console.error("Error initializing chart:", error);
                showFallbackMessage();
            }
        }, 100);
        
        function initChart() {
            const chartElement = document.getElementById("attendance-pie-chart");
            const fallbackMessage = document.getElementById("chart-fallback-message");
            
            if (!chartElement) {
                console.error("Chart element not found");
                showFallbackMessage();
                return;
            }
            
            if (typeof ApexCharts === 'undefined') {
                console.error("ApexCharts library not loaded");
                showFallbackMessage();
                return;
            }
            
            try {
                // Debug: check if data exists
                console.log("Chart data:", {{ $hadir }}, {{ $izin }}, {{ $tidakHadir }});
                
                // Create chart with the provided data
                const chart = new ApexCharts(chartElement, getChartOptions(
                    {{ $hadir }}, 
                    {{ $izin }}, 
                    {{ $tidakHadir }}
                ));
                
                chart.render();
                
                // Hide fallback message if chart renders successfully
                if (fallbackMessage) {
                    fallbackMessage.classList.add('hidden');
                }
                
                // Listen for both Livewire v2 and v3 events
                document.addEventListener('presensiUpdated', function() {
                    try {
                        chart.updateOptions(getChartOptions(
                            {{ $hadir }}, 
                            {{ $izin }}, 
                            {{ $tidakHadir }}
                        ));
                    } catch (updateError) {
                        console.error("Error updating chart:", updateError);
                        showFallbackMessage();
                    }
                });
                
                Livewire.on('presensiUpdated', function() {
                    try {
                        chart.updateOptions(getChartOptions(
                            {{ $hadir }}, 
                            {{ $izin }}, 
                            {{ $tidakHadir }}
                        ));
                    } catch (updateError) {
                        console.error("Error updating chart:", updateError);
                        showFallbackMessage();
                    }
                });
                
            } catch (error) {
                console.error("Error creating chart:", error);
                showFallbackMessage();
            }
        }
        
        function showFallbackMessage() {
            const fallbackMessage = document.getElementById("chart-fallback-message");
            if (fallbackMessage) {
                fallbackMessage.classList.remove('hidden');
            }
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
                    height: 350,
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
    });
</script>