<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\DashboardDateFilter;
use App\Filament\Widgets\LatestOrders;
use App\Filament\Widgets\ProductCategoryPieChart;
use App\Filament\Widgets\SalesChart;
use App\Filament\Widgets\StatsOverview;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
  public function getHeaderWidgets(): array
  {
    return [
    ];
  }

  public function getWidgets(): array
  {
    return [
      StatsOverview::class,
      SalesChart::class,
      ProductCategoryPieChart::class,
      LatestOrders::class,
    ];
  }
}
