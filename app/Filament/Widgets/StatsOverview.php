<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\OrderResource;
use App\Filament\Resources\UserResource;
use App\Models\Order;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;
use Livewire\Attributes\On;

class StatsOverview extends BaseWidget
{
    public ?string $filter = '7d';

    #[On('dateRangeUpdated')]
    public function updateFilter(string $date): void
    {
        $this->filter = $date;
    }

    protected function getStats(): array
    {
        [$startDate, $endDate, $previousStartDate, $previousEndDate] = $this->resolveDateRange($this->filter);

        $currentRevenue = Order::whereIn('status', ['processing', 'shipped', 'completed'])->whereBetween('created_at', [$startDate, $endDate])->sum('total_price');
        $currentCustomers = User::where('role', 'customer')->whereBetween('created_at', [$startDate, $endDate])->count();
        $currentOrders = Order::whereBetween('created_at', [$startDate, $endDate])->count();

        $previousRevenue = Order::whereIn('status', ['processing', 'shipped', 'completed'])->whereBetween('created_at', [$previousStartDate, $previousEndDate])->sum('total_price');
        $previousCustomers = User::where('role', 'customer')->whereBetween('created_at', [$previousStartDate, $previousEndDate])->count();
        $previousOrders = Order::whereBetween('created_at', [$previousStartDate, $previousEndDate])->count();

        return [
            $this->createStat('Pendapatan Total', $currentRevenue, $previousRevenue, isCurrency: true),
            $this->createStat('Pelanggan Baru', $currentCustomers, $previousCustomers)->url(UserResource::getUrl('index')),
            $this->createStat('Pesanan Baru', $currentOrders, $previousOrders)->url(OrderResource::getUrl('index', ['tableFilters' => ['created_at' => ['created_from' => now()->startOfDay(), 'created_until' => now()->endOfDay()]]])),
        ];
    }

    private function resolveDateRange(string $filter): array
    {
        $now = Carbon::now();
        switch ($filter) {
            case '7d':
                return [$now->copy()->subDays(6), $now, $now->copy()->subDays(13), $now->copy()->subDays(7)];
            case '30d':
                return [$now->copy()->subDays(29), $now, $now->copy()->subDays(59), $now->copy()->subDays(30)];
            case 'mtd':
                return [$now->copy()->startOfMonth(), $now, $now->copy()->subMonth()->startOfMonth(), $now->copy()->subMonth()->endOfMonth()];
            case 'lm':
                return [$now->copy()->subMonth()->startOfMonth(), $now->copy()->subMonth()->endOfMonth(), $now->copy()->subMonths(2)->startOfMonth(), $now->copy()->subMonths(2)->endOfMonth()];
            case 'today':
            default:
                return [$now->copy()->startOfDay(), $now, $now->copy()->subDay()->startOfDay(), $now->copy()->subDay()->endOfDay()];
        }
    }

    private function createStat(string $label, float|int $currentValue, float|int $previousValue, bool $isCurrency = false): Stat
    {
        $percentageChange = $previousValue != 0 ? (($currentValue - $previousValue) / $previousValue) * 100 : 100;

        $description = 'vs bulan lalu';
        $descriptionIcon = 'heroicon-m-arrow-trending-up';
        $color = 'success';

        if ($percentageChange < 0) {
            $descriptionIcon = 'heroicon-m-arrow-trending-down';
            $color = 'danger';
        }

        $formattedValue = $isCurrency
            ? 'Rp ' . number_format($currentValue / 100, 0, ',', '.')
            : number_format($currentValue);

        return Stat::make($label, $formattedValue)
            ->description(abs(round($percentageChange, 2)) . '% ' . $description)
            ->descriptionIcon($descriptionIcon)
            ->color($color);
    }
}
