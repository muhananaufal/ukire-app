<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ProductResource;
use App\Models\Product;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class TopSellingProducts extends BaseWidget
{
    protected static ?int $sort = 5;
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = 'Top Selling Products';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Product::query()
                    ->with('category')
                    ->withCount(['items as quantity_sold' => function (Builder $query) {
                        $query->whereHas('order', fn(Builder $q) => $q->whereIn('status', ['processing', 'shipped', 'completed']));
                    }])
                    ->orderBy('quantity_sold', 'desc')
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('category.name'),
                Tables\Columns\TextColumn::make('quantity_sold')
                    ->label('Units Sold'),
            ])
            ->actions([
                Tables\Actions\Action::make('View')
                    ->url(fn(Product $record): string => ProductResource::getUrl('edit', ['record' => $record])),
            ])
            ->paginated(false);
    }
}
