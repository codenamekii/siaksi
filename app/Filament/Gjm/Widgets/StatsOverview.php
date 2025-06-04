<?php

namespace App\Filament\Gjm\Widgets;

use App\Models\User;
use App\Models\Dokumen;
use App\Models\ProgramStudi;
use App\Models\JadwalAMI;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
  protected function getStats(): array
  {
    // Get counts
    $totalUJM = User::where('role', 'ujm')->where('is_active', true)->count();
    $totalProdi = ProgramStudi::where('is_active', true)->count();
    $totalDokumen = Dokumen::where('level', 'fakultas')->count();
    $upcomingAMI = JadwalAMI::where('tanggal_mulai', '>', now())->count();

    return [
      Stat::make('Total UJM Aktif', $totalUJM)
        ->description('Unit Jaminan Mutu')
        ->descriptionIcon('heroicon-m-arrow-trending-up')
        ->color('success')
        ->chart([3, 4, 4, 5, 6, 7, 7]),

      Stat::make('Program Studi', $totalProdi)
        ->description('Program studi aktif')
        ->descriptionIcon('heroicon-m-academic-cap')
        ->color('primary'),

      Stat::make('Dokumen Fakultas', $totalDokumen)
        ->description('Total dokumen')
        ->descriptionIcon('heroicon-m-document-text')
        ->color('warning'),

      Stat::make('Jadwal AMI', $upcomingAMI)
        ->description('AMI mendatang')
        ->descriptionIcon('heroicon-m-calendar-days')
        ->color('info'),
    ];
  }
}
