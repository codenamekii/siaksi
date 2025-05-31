<?php

namespace App\Filament\Ujm\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
  protected static ?string $navigationIcon = 'heroicon-o-home';

  // HAPUS LINE INI - Jangan override view
  // protected static string $view = 'filament.ujm.pages.dashboard';

  public function getTitle(): string
  {
    return 'Dashboard UJM';
  }

  // Kosongkan widgets dulu untuk testing
  public function getWidgets(): array
  {
    return [
      \App\Filament\Ujm\Widgets\StatsOverview::class,
      \App\Filament\Ujm\Widgets\RecentActivities::class,
      \App\Filament\Ujm\Widgets\DocumentStatus::class,
    ];
  }
}