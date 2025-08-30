<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;

class ProductCategoryPieChart extends ChartWidget
{
    protected static ?string $heading = 'Penjualan Per Kategori';
    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'half';

    protected function getData(): array
    {
        $salesData = Order::query()
            ->where('status', '!=', 'cancelled')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->selectRaw('categories.name as category_name, SUM(order_items.price * order_items.quantity) as total_sales')
            ->groupBy('categories.name')
            ->pluck('total_sales', 'category_name');

        $labels = $salesData->keys()->toArray();
        $data = $salesData->values()->map(fn($sale) => $sale / 100)->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Penjualan',
                    'data' => $data,
                    'backgroundColor' => [
                        'rgba(251, 191, 36, 0.7)',
                        'rgba(59, 130, 246, 0.7)',
                        'rgba(16, 185, 129, 0.7)',
                        'rgba(239, 68, 68, 0.7)',
                        'rgba(139, 92, 246, 0.7)',
                    ],
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
