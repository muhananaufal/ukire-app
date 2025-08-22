<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Filament\Resources\OrderResource\RelationManagers\ItemsRelationManager;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Shop';

    public static bool $isGloballySearchable = true;

    // Kita akan mencari berdasarkan ID Pesanan
    public static function getGloballySearchableAttributes(): array
    {
        return ['id', 'user.name'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return "Order #" . $record->id;
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Customer' => $record->user->name,
            'Status' => $record->status,
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'processing' => 'Processing',
                        'shipped' => 'Shipped',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Order ID')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_price')
                    ->money('IDR', divideBy: 100)
                    ->sortable(),

                // ===================================================================
                // INI ADALAH BAGIAN YANG DIPERBAIKI
                // ===================================================================
                Tables\Columns\TextColumn::make('status')
                    ->badge() // <-- Ini akan mengubahnya menjadi badge
                    ->color(fn(string $state): string => match ($state) {
                        'unpaid' => 'warning',
                        'processing' => 'info',
                        'shipped' => 'primary',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(string $state): string => Str::ucfirst($state)) // <-- Membuat huruf pertama kapital
                    ->searchable()
                    ->sortable(),
                // ===================================================================

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                // Anda juga bisa menambahkan ViewAction jika perlu
                Action::make('Mark as Shipped')
                    ->action(function (Order $record) {
                        $record->update(['status' => 'shipped']);
                        Notification::make()
                            ->title('Order marked as shipped')
                            ->success()
                            ->send();
                    })
                    ->icon('heroicon-o-truck')
                    ->color('success')
                    ->requiresConfirmation() // Minta konfirmasi sebelum menjalankan
                    ->visible(fn(Order $record): bool => $record->status === 'processing'), // Hanya tampil jika status 'processing'

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
