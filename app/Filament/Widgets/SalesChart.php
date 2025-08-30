<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Livewire\Attributes\On;

class SalesChart extends ChartWidget
{
    protected static ?string $heading = 'Penjualan Minggu Ini';
    protected static ?int $sort = 2;

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
            default => [$now->copy()->subDays(6), $now],
        };

        $data = Order::query()
            ->where('status', '!=', 'cancelled')
            ->whereBetween('created_at', [Carbon::now()->subDays(6), Carbon::now()])
            ->selectRaw('DATE(created_at) as date, SUM(total_price) as total')
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get()
            ->pluck('total', 'date');

        $labels = [];
        for ($i = 6; $i >= 0; $i--) {
            $labels[] = Carbon::now()->subDays($i)->format('D, M j');
        }

        $salesData = [];
        foreach ($labels as $label) {
            $dateKey = Carbon::parse($label)->format('Y-m-d');
            $salesData[] = ($data[$dateKey] ?? 0) / 100;
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
        return 'line';
    }
}
