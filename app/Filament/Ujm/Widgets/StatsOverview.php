<?php

namespace App\Filament\Ujm\Widgets;

use App\Models\Dokumen;
use App\Models\Dosen;
use App\Models\TenagaKependidikan;
use App\Models\AkreditasiProdi;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class StatsOverview extends BaseWidget
{
  protected function getStats(): array
  {
    $prodiId = Auth::user()->program_studi_id;

    // Get counts
    $totalDokumen = Dokumen::where('program_studi_id', $prodiId)->count();
    $totalDosen = Dosen::where('program_studi_id', $prodiId)->where('is_active', true)->count();
    $totalTendik = TenagaKependidikan::where('program_studi_id', $prodiId)->where('is_active', true)->count();

    // Get akreditasi status
    $akreditasiAktif = AkreditasiProdi::where('program_studi_id', $prodiId)
      ->where('is_active', true)
      ->where('tanggal_berakhir', '>', now())
      ->first();

    return [
      Stat::make('Total Dokumen', $totalDokumen)
        ->description('Dokumen program studi')
        ->descriptionIcon('heroicon-m-arrow-trending-up')
        ->color('success')
        ->chart([7, 3, 4, 5, 6, 3, 5]),

      Stat::make('Dosen Aktif', $totalDosen)
        ->description('Dosen program studi')
        ->descriptionIcon('heroicon-m-academic-cap')
        ->color('primary'),

      Stat::make('Tenaga Kependidikan', $totalTendik)
        ->description('Tendik aktif')
        ->descriptionIcon('heroicon-m-users')
        ->color('warning'),

      Stat::make('Status Akreditasi', $akreditasiAktif ? $akreditasiAktif->status_akreditasi : 'Belum Terakreditasi')
        ->description($akreditasiAktif ? 'Berlaku hingga ' . $akreditasiAktif->tanggal_berakhir->format('d M Y') : 'Perlu diperbarui')
        ->descriptionIcon($akreditasiAktif ? 'heroicon-m-check-badge' : 'heroicon-m-x-circle')
        ->color($akreditasiAktif ? 'success' : 'danger'),
    ];
  }
}