<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('User Details')
                    ->schema([
                        Grid::make(2)->schema([
                            TextEntry::make('name'),
                            TextEntry::make('email'),
                            TextEntry::make('created_at')
                                ->label('Registered On')
                                ->dateTime('d M Y, H:i'),
                            IconEntry::make('email_verified_at')
                                ->label('Email Status')
                                ->boolean()
                                ->trueIcon('heroicon-o-check-badge')
                                ->trueColor('success')
                                ->falseIcon('heroicon-o-x-circle')
                                ->falseColor('danger'),
                        ]),
                    ]),
                Section::make('Customer Stats')
                    ->schema([
                        Grid::make(2)->schema([
                            TextEntry::make('orders_count')
                                ->label('Total Orders Placed')
                                ->getStateUsing(fn ($record) => $record->orders()->count()),
                            TextEntry::make('total_spent')
                                ->label('Lifetime Value')
                                ->money('IDR', divideBy: 100)
                                ->getStateUsing(function ($record) {
                                    return $record->orders()->whereIn('status', ['processing', 'shipped', 'completed'])->sum('total_price');
                                }),
                        ]),
                    ]),
            ]);
    }
}