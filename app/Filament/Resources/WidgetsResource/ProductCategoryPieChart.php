<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\Order;
use Filament\Widgets\ChartWidget;

class ProductCategoryPieChart extends ChartWidget
{
    protected static ?string $heading = 'Penjualan Per Kategori';
    protected static ?int $sort = 3; // Urutan widget di dashboard, setelah tabel pesanan

    protected int | string | array $columnSpan = 'half';

    protected function getData(): array
    {
        // Ambil data penjualan dan kelompokkan berdasarkan kategori
        $salesData = Order::query()
            ->where('status', '!=', 'cancelled')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->selectRaw('categories.name as category_name, SUM(order_items.price * order_items.quantity) as total_sales')
            ->groupBy('categories.name')
            ->pluck('total_sales', 'category_name');

        // Ambil label (nama kategori) dan data (total penjualan)
        $labels = $salesData->keys()->toArray();
        $data = $salesData->values()->map(fn($sale) => $sale / 100)->toArray(); // Konversi dari sen

        return [
            'datasets' => [
                [
                    'label' => 'Penjualan',
                    'data' => $data,
                    // Siapkan palet warna yang menarik untuk setiap kategori
                    'backgroundColor' => [
                        'rgba(251, 191, 36, 0.7)', // Amber
                        'rgba(59, 130, 246, 0.7)', // Blue
                        'rgba(16, 185, 129, 0.7)', // Emerald
                        'rgba(239, 68, 68, 0.7)',  // Red
                        'rgba(139, 92, 246, 0.7)', // Violet
                    ],
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'pie'; // Tipe grafik: pie
    }
}
