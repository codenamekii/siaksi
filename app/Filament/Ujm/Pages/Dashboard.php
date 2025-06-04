<?php

namespace App\Filament\Ujm\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
  protected static ?string $navigationIcon = 'heroicon-o-home';

  public function getTitle(): string
  {
    return 'Dashboard UJM';
  }

  public function getWidgets(): array
  {
    return [
      \App\Filament\Ujm\Widgets\StatsOverview::class,
      \App\Filament\Ujm\Widgets\RecentActivities::class,
      \App\Filament\Ujm\Widgets\DocumentStatus::class,
      \App\Filament\Ujm\Widgets\AsesorAccessWidget::class, // Added new widget
    ];
  }
}