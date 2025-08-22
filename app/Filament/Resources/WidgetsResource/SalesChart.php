<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Livewire\Attributes\On;

class SalesChart extends ChartWidget
{
    protected static ?string $heading = 'Penjualan Minggu Ini';
    protected static ?int $sort = 2; // Urutan widget di dashboard

    protected int | string | array $columnSpan = 'half';
    protected static string $className = 'h-96 flex flex-col';

    public ?string $filter = '7d';

    #[On('dateRangeUpdated')]
    public function updateFilter(string $date): void
    {
        $this->filter = $date;
    }

    protected function getData(): array
    {
        $now = Carbon::now();
        [$startDate, $endDate] = match ($this->filter) {
            '30d' => [$now->copy()->subDays(29), $now],
            'mtd' => [$now->copy()->startOfMonth(), $now],
            'lm' => [$now->copy()->subMonth()->startOfMonth(), $now->copy()->subMonth()->endOfMonth()],
            'today' => [$now->copy()->startOfDay(), $now],
            default => [$now->copy()->subDays(6), $now], // '7d'
        };

        $data = Order::query()
            ->where('status', '!=', 'cancelled') // Hanya hitung order yang tidak dibatalkan
            ->whereBetween('created_at', [Carbon::now()->subDays(6), Carbon::now()])
            ->selectRaw('DATE(created_at) as date, SUM(total_price) as total')
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get()
            ->pluck('total', 'date');

        // Siapkan label untuk 7 hari terakhir
        $labels = [];
        for ($i = 6; $i >= 0; $i--) {
            $labels[] = Carbon::now()->subDays($i)->format('D, M j'); // Format: Sun, Aug 18
        }

        // Siapkan data, isi dengan 0 jika tidak ada penjualan di hari itu
        $salesData = [];
        foreach ($labels as $label) {
            $dateKey = Carbon::parse($label)->format('Y-m-d');
            $salesData[] = ($data[$dateKey] ?? 0) / 100; // Konversi dari sen ke Rupiah
        }

        return [
            'datasets' => [
                [
                    'label' => 'Sales',
                    'data' => $salesData,
                    'backgroundColor' => 'rgba(251, 191, 36, 0.2)',
                    'borderColor' => 'rgba(251, 191, 36, 1)',
                    'tension' => 0.2,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line'; // Tipe grafik garis untuk tren
    }
}
