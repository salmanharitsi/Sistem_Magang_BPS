<div id="logbook-donut-chart">
    <!-- Fallback message container -->
    <div id="chart-fallback-message" class="hidden text-center p-4 text-red-800 bg-red-50 rounded-lg">
        Grafik gagal ditampilkan!
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
                labels = ["Disetujui", "Ditolak"];
            } else {
                series = [100];
                labels = ["Belum Ada Data"];
            }

            return {
                series: series,
                colors: ['#1A56DB', '#f05252'],
                chart: {
                    height: 300, // Mengubah height dari 250 menjadi 350
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