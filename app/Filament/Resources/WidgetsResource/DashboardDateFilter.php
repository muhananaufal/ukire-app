<?php

namespace App\Filament\Widgets;

use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Widgets\Widget;

class DashboardDateFilter extends Widget implements HasForms
{
    use InteractsWithForms;

    // protected static string $view = 'filament.widgets.dashboard-date-filter';

    public ?string $filter = '7d';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('filter')
                    ->label('Date Range')
                    ->options([
                        'today' => 'Today',
                        '7d' => 'Last 7 Days',
                        '30d' => 'Last 30 Days',
                        'mtd' => 'Month to Date',
                        'lm' => 'Last Month',
                    ])
                    ->default('7d')
                    ->live() // <-- Ini penting untuk interaktivitas
                    ->afterStateUpdated(fn() => $this->dispatch('dateRangeUpdated', date: $this->filter)),
            ]);
    }

    public function mount(): void
    {
        // Kirim event awal saat widget dimuat
        $this->dispatch('dateRangeUpdated', date: $this->filter);
    }
}
