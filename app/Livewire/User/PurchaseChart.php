<?php

namespace App\Livewire\User;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PurchaseChart extends Component
{
    public array $chartData = [];

    public function mount()
    {
        $this->prepareChartData();
    }

    public function prepareChartData()
    {
        $user = Auth::user();
        $data = $user->orders()
            ->where('status', '!=', 'cancelled')
            ->where('created_at', '>=', Carbon::now()->subMonths(5)->startOfMonth())
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, SUM(total_price) as total')
            ->groupBy('month')
            ->orderBy('month', 'ASC')
            ->get()
            ->pluck('total', 'month');

        $labels = [];
        for ($i = 5; $i >= 0; $i--) {
            $labels[] = Carbon::now()->subMonths($i)->format('M Y');
        }

        $salesData = [];
        foreach ($labels as $label) {
            $monthKey = Carbon::parse($label)->format('Y-m');
            $salesData[] = ($data[$monthKey] ?? 0) / 100;
        }

        $this->chartData = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Total Belanja',
                    'data' => $salesData,
                    'borderColor' => '#f59e0b',
                    'backgroundColor' => '#fef3c7',
                    'tension' => 0.2,
                    'fill' => true,
                ],
            ],
        ];

        $this->dispatch('chartDataUpdated', data: $this->chartData);
    }

    public function render()
    {
        return view('livewire.user.purchase-chart');
    }
}
