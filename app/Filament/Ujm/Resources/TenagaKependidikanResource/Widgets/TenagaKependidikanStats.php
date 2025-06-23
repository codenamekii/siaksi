<?php

namespace App\Filament\Ujm\Resources\TenagaKependidikanResource\Widgets;

use App\Models\TenagaKependidikan;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class TenagaKependidikanStats extends BaseWidget
{
  protected function getStats(): array
  {
    $prodiId = Auth::user()->programStudi?->id;

    if (!$prodiId) {
      return [];
    }

    $query = TenagaKependidikan::where('program_studi_id', $prodiId);

    $total = $query->count();
    $aktif = (clone $query)->where('is_active', true)->count();
    $tendik = (clone $query)->whereIn('status_kepegawaian', ['Tetap', 'Kontrak'])->where('is_active', true)->count();
    $teknis = (clone $query)->whereIn('jabatan', ['Laboran', 'Teknisi', 'Pranata Komputer'])->where('is_active', true)->count();

    return [
      Stat::make('Total Tendik', $total)
        ->description('Seluruh tenaga kependidikan')
        ->color('primary')
        ->icon('heroicon-o-briefcase'),

      Stat::make('Tendik Aktif', $aktif)
        ->description($total - $aktif . ' non-aktif')
        ->color('success')
        ->icon('heroicon-o-check-circle'),

      Stat::make('Tetap/Kontrak', $tendik)
        ->description('ASN aktif')
        ->color('info')
        ->icon('heroicon-o-identification'),

      Stat::make('Tenaga Teknis', $teknis)
        ->description('Laboran, Teknisi, Pranata Komputer')
        ->color('warning')
        ->icon('heroicon-o-wrench-screwdriver'),
    ];
  }
}
