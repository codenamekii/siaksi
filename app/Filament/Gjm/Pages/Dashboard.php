<?php

namespace App\Filament\Gjm\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    public function getTitle(): string
    {
        return 'Dashboard GJM';
    }

    public function getWidgets(): array
    {
        return [
          \App\Filament\Gjm\Widgets\FakultasSummaryWidget::class, 
          \App\Filament\Gjm\Widgets\ProgramStudiStatsWidget::class,
          \App\Filament\Gjm\Widgets\InfoCenterWidget::class, 
          \App\Filament\Gjm\Widgets\QuickAccessWidget::class, 
        ];
    }

    public function getColumns(): int|string|array
    {
        return [
            'sm' => 1,
            'md' => 2,
            'xl' => 4,
        ];
    }
}
