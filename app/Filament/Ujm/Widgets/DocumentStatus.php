<?php

namespace App\Filament\Ujm\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Dokumen;
use Illuminate\Support\Facades\Auth;

class DocumentStatus extends BaseWidget
{
  protected function getStats(): array
  {
    $prodiId = Auth::user()->program_studi_id;

    $totalDokumen = Dokumen::where('program_studi_id', $prodiId)->count();
    $dokumenVisible = Dokumen::where('program_studi_id', $prodiId)
      ->where('is_visible_to_asesor', true)
      ->count();
    $dokumenFile = Dokumen::where('program_studi_id', $prodiId)
      ->where('tipe', 'file')
      ->count();
    $dokumenUrl = Dokumen::where('program_studi_id', $prodiId)
      ->where('tipe', 'url')
      ->count();

    return [
      Stat::make('Total Dokumen', $totalDokumen)
        ->description('Dokumen program studi')
        ->descriptionIcon('heroicon-m-document-text')
        ->color('primary'),

      Stat::make('Visible ke Asesor', $dokumenVisible)
        ->description('Dapat dilihat asesor')
        ->descriptionIcon('heroicon-m-eye')
        ->color('success'),

      Stat::make('Dokumen File', $dokumenFile)
        ->description('Upload file')
        ->descriptionIcon('heroicon-m-paper-clip')
        ->color('info'),

      Stat::make('Dokumen URL', $dokumenUrl)
        ->description('Link eksternal')
        ->descriptionIcon('heroicon-m-link')
        ->color('warning'),
    ];
  }
}
