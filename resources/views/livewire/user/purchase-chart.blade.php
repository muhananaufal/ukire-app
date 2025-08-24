<div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
    <h3 class="font-bold text-gray-900 mb-4">Aktivitas Belanja 6 Bulan Terakhir</h3>
    
    {{-- Ini adalah kanvas kita --}}
    <div wire:ignore>
        <canvas id="purchaseChart"></canvas>
    </div>

    {{-- Ini adalah "pelukis" (JavaScript) kita --}}
    @script
    <script>
        const chartEl = document.getElementById('purchaseChart');
        let purchaseChart = new Chart(chartEl, {
            type: 'line',
            data: @json($chartData),
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value, index, values) {
                                return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                            }
                        }
                    }
                }
            }
        });

        // Dengarkan sinyal dari backend
        $wire.on('chartDataUpdated', ({ data }) => {
            // Perbarui data grafik dan gambar ulang
            purchaseChart.data = data;
            purchaseChart.update();
        });
    </script>
    @endscript
</div>