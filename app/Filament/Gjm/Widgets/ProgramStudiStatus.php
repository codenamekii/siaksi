<?php

namespace App\Filament\Gjm\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\ProgramStudi;

class ProgramStudiStatus extends BaseWidget
{
  protected function getStats(): array
  {
    $totalProdi = ProgramStudi::count();
    $prodiAktif = ProgramStudi::where('is_active', true)->count();
    $prodiWithUjm = ProgramStudi::whereNotNull('ujm_id')->count();
    $prodiTerakreditasi = ProgramStudi::whereHas('akreditasiAktif')->count();

    return [
      Stat::make('Total Program Studi', $totalProdi)
        ->description('Semua program studi')
        ->descriptionIcon('heroicon-m-academic-cap')
        ->color('primary'),

      Stat::make('Prodi Aktif', $prodiAktif)
        ->description('Status aktif')
        ->descriptionIcon('heroicon-m-check-circle')
        ->color('success'),

      Stat::make('Prodi dengan UJM', $prodiWithUjm)
        ->description('Memiliki UJM')
        ->descriptionIcon('heroicon-m-users')
        ->color('info'),

      Stat::make('Prodi Terakreditasi', $prodiTerakreditasi)
        ->description('Akreditasi aktif')
        ->descriptionIcon('heroicon-m-check-badge')
        ->color('warning'),
    ];
  }
}