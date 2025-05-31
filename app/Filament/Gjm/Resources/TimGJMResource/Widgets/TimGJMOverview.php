<?php

namespace App\Filament\Gjm\Resources\TimGJMResource\Widgets;

use App\Models\TimGJM;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TimGJMOverview extends BaseWidget
{
  protected function getStats(): array
  {
    $total = TimGJM::count();
    $active = TimGJM::where('is_active', true)->count();
    $positions = TimGJM::where('is_active', true)
      ->distinct('jabatan')
      ->count('jabatan');

    return [
      Stat::make('Total Anggota', $total)
        ->description('Seluruh anggota tim GJM')
        ->descriptionIcon('heroicon-m-user-group')
        ->color('primary'),
      Stat::make('Anggota Aktif', $active)
        ->description($total - $active . ' tidak aktif')
        ->descriptionIcon('heroicon-m-check-circle')
        ->color('success'),
      Stat::make('Jabatan', $positions)
        ->description('Jumlah jabatan berbeda')
        ->descriptionIcon('heroicon-m-briefcase')
        ->color('info'),
    ];
  }
}
