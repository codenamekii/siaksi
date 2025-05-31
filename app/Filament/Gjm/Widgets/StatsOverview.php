<?php

// 1. app/Filament/Gjm/Widgets/StatsOverview.php
namespace App\Filament\Gjm\Widgets;

use App\Models\User;
use App\Models\ProgramStudi;
use App\Models\Dokumen;
use App\Models\JadwalAMI;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
  protected static ?int $sort = 1;

  protected function getStats(): array
  {
    return [
      Stat::make('Total UJM', User::where('role', 'ujm')->count())
        ->description('Unit Jaminan Mutu aktif')
        ->descriptionIcon('heroicon-m-users')
        ->color('primary')
        ->chart([7, 3, 4, 5, 6, 3, 7]),

      Stat::make('Program Studi', ProgramStudi::where('is_active', true)->count())
        ->description('Program studi aktif')
        ->descriptionIcon('heroicon-m-academic-cap')
        ->color('success'),

      Stat::make('Dokumen SPMI', Dokumen::whereIn('level', ['universitas', 'fakultas'])->count())
        ->description('Total dokumen tersimpan')
        ->descriptionIcon('heroicon-m-document-text')
        ->color('info'),

      Stat::make('Jadwal AMI', JadwalAMI::where('status', 'scheduled')->count())
        ->description('AMI terjadwal')
        ->descriptionIcon('heroicon-m-calendar-days')
        ->color('warning'),
    ];
  }
}