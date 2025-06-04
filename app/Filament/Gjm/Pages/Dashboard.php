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
      \App\Filament\Gjm\Widgets\StatsOverview::class,
      \App\Filament\Gjm\Widgets\UpcomingAMI::class,
      \App\Filament\Gjm\Widgets\ProgramStudiStatus::class,
      \App\Filament\Gjm\Widgets\RecentDocuments::class,
      \App\Filament\Gjm\Widgets\UjmAccessWidget::class, // Added new widget
    ];
  }

  public function getColumns(): int | string | array
  {
    return [
      'sm' => 1,
      'md' => 2,
      'xl' => 4,
    ];
  }
}
