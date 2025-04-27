<div class="card p-5 rounded-lg bg-white">
    <div class="text-xl font-semibold">Logbook</div>
    @if ($todayLogbook && $todayLogbook->status === 'waiting' && !$todayLogbook->tanggal->isWeekend())
        <div
            class="w-full h-fit p-3 mt-5 flex flex-col md:flex-row items-start gap-3 md:items-center justify-between bg-amber-100 rounded-lg border text-amber-700 border-amber-700">
            <div class="flex gap-3 items-start lg:items-center">
                <i class="ti ti-alert-circle text-lg"></i>
                <p class="text-sm">Kamu belum mengisi logbook hari ini</p>
            </div>
            <a href="/logbook"
                class="pjax-link bg-amber-600 ml-7 md:ml-0 border border-transparent px-3 py-1 rounded-lg text-white hover:bg-amber-100 hover:border hover:border-amber-600 hover:text-amber-600 transition-all duration-200">
                <p class="text-sm whitespace-nowrap">isi logbook</p>
            </a>
        </div>
    @endif
    <div class="mt-6" id="logbook-donut-chart">
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
            const chartElement = document.getElementById("logbook-donut-chart");
            const fallbackMessage = document.getElementById("chart-fallback-message");

            if (!chartElement || typeof ApexCharts === 'undefined') {
                showFallbackMessage();
                return;
            }

            try {
                const chart = new ApexCharts(chartElement, getChartOptions(
                    {{ $mengisi }},
                    {{ $tidakMengisi }}
                ));
                chart.render();

                if (fallbackMessage) {
                    fallbackMessage.classList.add('hidden');
                }

                // Listen for Livewire events
                document.addEventListener('logbookUpdated', () => updateChart(chart));
                Livewire.on('logbookUpdated', () => updateChart(chart));

            } catch (error) {
                console.error("Error creating chart:", error);
                showFallbackMessage();
            }
        }

        function updateChart(chart) {
            try {
                chart.updateOptions(getChartOptions(
                    {{ $mengisi }},
                    {{ $tidakMengisi }}
                ));
            } catch (error) {
                console.error("Error updating chart:", error);
                showFallbackMessage();
            }
        }

        function showFallbackMessage() {
            const fallbackMessage = document.getElementById("chart-fallback-message");
            if (fallbackMessage) {
                fallbackMessage.classList.remove('hidden');
            }
        }

        function getChartOptions(mengisi = 0, tidakMengisi = 0) {
            const total = mengisi + tidakMengisi;
            let series, labels;

            if (total > 0) {
                series = [
                    (mengisi / total) * 100,
                    (tidakMengisi / total) * 100
                ];
                labels = ["Mengisi", "Tidak Mengisi"];
            } else {
                series = [100];
                labels = ["Belum Ada Data"];
            }

            return {
                series: series,
                colors: ['#1A56DB', '#f05252'],
                chart: {
                    height: 350, // Mengubah height dari 250 menjadi 350
                    width: "100%",
                    type: "donut",
                    fontFamily: 'Inter, sans-serif',
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '70%'
                        }
                    }
                },
                labels: labels,
                dataLabels: {
                    enabled: true,
                    formatter: function(val) {
                        return Math.round(val) + '%'
                    }
                },
                legend: {
                    position: 'bottom',
                    fontFamily: 'Inter, sans-serif',
                },
                tooltip: {
                    fillSeriesColor: false,
                    y: {
                        formatter: function(value, {
                            seriesIndex
                        }) {
                            if (total === 0) return "Belum Ada Data";
                            const counts = [mengisi, tidakMengisi];
                            return `${labels[seriesIndex]}: ${counts[seriesIndex]} (${Math.round(value)}%)`;
                        }
                    },
                    style: {
                        fontSize: '14px',
                        fontFamily: 'Inter, sans-serif'
                    }
                }
            };
        }
    });
</script>
