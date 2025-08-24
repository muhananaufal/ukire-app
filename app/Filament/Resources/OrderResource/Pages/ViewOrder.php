<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Str;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(), // Tombol "Edit" di pojok kanan atas
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Grid::make(3)->schema([
                    // Kolom Kiri: Detail Pesanan
                    Section::make('Order Details')
                        ->schema([
                            TextEntry::make('id')->label('Order ID'),
                            TextEntry::make('created_at')->dateTime(),
                            TextEntry::make('status')
                                ->badge()
                                ->color(fn(string $state): string => match ($state) {
                                    'unpaid' => 'warning',
                                    'processing' => 'info',
                                    'shipped' => 'primary',
                                    'completed' => 'success',
                                    'cancelled' => 'danger',
                                    default => 'gray',
                                })
                                ->formatStateUsing(fn(string $state): string => Str::ucfirst($state)),
                            TextEntry::make('total_price')
                                ->money('IDR', divideBy: 100),
                        ])->columnSpan(1),

                    // Kolom Kanan: Detail Pelanggan & Pengiriman
                    Section::make('Customer & Shipping')
                        ->schema([
                            TextEntry::make('user.name')->label('Customer Account'),
                            TextEntry::make('user.email')->label('Customer Email'),
                            TextEntry::make('recipient_name')
                                ->label('Recipient Name'),
                            TextEntry::make('phone')
                                ->label('Recipient Phone')
                                ->icon('heroicon-o-phone')
                                // Logika baru yang lebih aman
                                ->url(function (?string $state): ?string {
                                    if (empty($state)) {
                                        return null;
                                    }
                                    return 'tel:' . $state;
                                }),
                            TextEntry::make('shipping_address')
                                ->label('Recipient Address'),
                        ])->columnSpan(2),
                ]),
                // Bagian Bawah: Item Pesanan
                Section::make('Order Items')
                    ->schema([
                        // Ini adalah cara menampilkan tabel relasi di dalam Infolist
                        \Filament\Infolists\Components\RepeatableEntry::make('items')
                            ->hiddenLabel()
                            ->schema([
                                TextEntry::make('product.name')->weight('bold'),
                                TextEntry::make('quantity')->label('Qty'),
                                TextEntry::make('price')
                                    ->label('Price/item')
                                    ->money('IDR', divideBy: 100),
                            ])->columns(3),
                    ]),
            ]);
    }
}
