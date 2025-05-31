<?php

// 1. app/Filament/Ujm/Widgets/StatsOverview.php
namespace App\Filament\Ujm\Widgets;

use App\Models\Berita;
use App\Models\Dokumen;
use App\Models\Dosen;
use App\Models\TenagaKependidikan;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class StatsOverview extends BaseWidget
{
  protected static ?int $sort = 1;

  protected function getStats(): array
  {
    $prodiId = Auth::user()->programStudi?->id;

    if (!$prodiId) {
      return [
        Stat::make('Status', 'Program Studi Tidak Ditemukan')
          ->description('Hubungi administrator')
          ->color('danger')
          ->icon('heroicon-o-exclamation-triangle'),
      ];
    }

    return [
      Stat::make('Berita & Pengumuman', Berita::where('program_studi_id', $prodiId)->count())
        ->description('Total konten')
        ->color('primary')
        ->icon('heroicon-o-newspaper'),

      Stat::make('Dokumen Mutu', Dokumen::where('program_studi_id', $prodiId)->count())
        ->description('Total dokumen')
        ->color('success')
        ->icon('heroicon-o-document-text'),

      Stat::make('Dosen', Dosen::where('program_studi_id', $prodiId)->where('is_active', true)->count())
        ->description('Dosen aktif')
        ->color('info')
        ->icon('heroicon-o-academic-cap'),

      Stat::make('Tenaga Kependidikan', TenagaKependidikan::where('program_studi_id', $prodiId)->where('is_active', true)->count())
        ->description('Staf aktif')
        ->color('warning')
        ->icon('heroicon-o-briefcase'),
    ];
  }
}
