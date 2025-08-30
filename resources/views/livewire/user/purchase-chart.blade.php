<div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm h-80 flex flex-col">
    <h3 class="font-bold text-gray-900 mb-4 flex-shrink-0">Aktivitas Belanja 6 Bulan Terakhir</h3>
    <div class="flex-grow" wire:ignore>
        <canvas id="purchaseChart"></canvas>
    </div>

    @script
    <script>
        const chartEl = document.getElementById('purchaseChart');
        let purchaseChartInstance = window.purchaseChartInstance;
        if (purchaseChartInstance) {
            purchaseChartInstance.destroy();
        }

        window.purchaseChartInstance = new Chart(chartEl, {
            type: 'line',
            data: @json($chartData),
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                            }
                        }
                    }
                }
            }
        });

        $wire.on('chartDataUpdated', ({ data }) => {
            if (window.purchaseChartInstance) {
                window.purchaseChartInstance.data = data;
                window.purchaseChartInstance.update();
            }
        });
    </script>
    @endscript
</div>