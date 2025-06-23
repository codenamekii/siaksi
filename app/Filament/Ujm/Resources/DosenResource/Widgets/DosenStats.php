<?php

namespace App\Filament\Ujm\Resources\DosenResource\Widgets;

use App\Models\Dosen;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class DosenStats extends BaseWidget
{
  protected function getStats(): array
  {
    $prodiId = Auth::user()->programStudi?->id;

    if (!$prodiId) {
      return [];
    }

    $query = Dosen::where('program_studi_id', $prodiId);

    $totalDosen = $query->count();
    $dosenAktif = $query->where('is_active', true)->count();
    $dosenS3 = Dosen::where('program_studi_id', $prodiId)
      ->where('pendidikan_terakhir', 'S3')
      ->where('is_active', true)
      ->count();
    $profesor = Dosen::where('program_studi_id', $prodiId)
      ->where('jabatan_akademik', 'Profesor')
      ->where('is_active', true)
      ->count();

    return [
      Stat::make('Total Dosen', $totalDosen)
        ->description('Seluruh dosen terdaftar')
        ->color('primary')
        ->icon('heroicon-o-users'),

      Stat::make('Dosen Aktif', $dosenAktif)
        ->description($totalDosen - $dosenAktif . ' non-aktif')
        ->color('success')
        ->icon('heroicon-o-check-circle'),

      Stat::make('Doktor (S3)', $dosenS3)
        ->description('Dosen dengan gelar S3')
        ->color('warning')
        ->icon('heroicon-o-academic-cap'),

      Stat::make('Profesor', $profesor)
        ->description('Jabatan akademik tertinggi')
        ->color('danger')
        ->icon('heroicon-o-star'),
    ];
  }
}
