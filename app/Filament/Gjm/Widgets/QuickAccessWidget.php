<?php

namespace App\Filament\Gjm\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class QuickAccessWidget extends BaseWidget
{
    protected static ?int $sort = 3;

    protected function getStats(): array
    {
        return [Stat::make('Dashboard Asesor', 'Lihat Tampilan')->description('Lihat tampilan sebagai asesor')->icon('heroicon-o-eye')->color('primary')->url('/asesor/dashboard')->openUrlInNewTab(), Stat::make('Kelola Dokumen', 'Upload & Kelola')->description('Upload & kelola dokumen')->icon('heroicon-o-document-text')->color('success')->url('/gjm/dokumen'), Stat::make('Jadwal AMI', 'Atur Jadwal')->description('Atur jadwal audit')->icon('heroicon-o-calendar-days')->color('warning')->url('/gjm/jadwal-amis')];
    }
}
