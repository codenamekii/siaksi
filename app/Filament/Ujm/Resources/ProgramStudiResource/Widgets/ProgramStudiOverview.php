<?php

// 1. app/Filament/Ujm/Resources/ProgramStudiResource/Widgets/ProgramStudiOverview.php
namespace App\Filament\Ujm\Resources\ProgramStudiResource\Widgets;

use App\Models\ProgramStudi;
use App\Models\Dokumen;
use App\Models\Dosen;
use App\Models\TenagaKependidikan;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class ProgramStudiOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $prodi = Auth::user()->programStudi;

        if (!$prodi) {
            return [
                Stat::make('Status', 'Tidak ada program studi')
                    ->description('User belum terhubung dengan program studi')
                    ->color('danger'),
            ];
        }

        $totalDokumen = Dokumen::where('program_studi_id', $prodi->id)->count();
        $dokumenAsesor = Dokumen::where('program_studi_id', $prodi->id)
            ->where('is_visible_to_asesor', true)
            ->count();
        $totalDosen = Dosen::where('program_studi_id', $prodi->id)
            ->where('is_active', true)
            ->count();
        $totalTendik = TenagaKependidikan::where('program_studi_id', $prodi->id)
            ->where('is_active', true)
            ->count();

        return [
            Stat::make('Status Akreditasi', $prodi->akreditasiAktif?->status_akreditasi ?? 'Belum Terakreditasi')
                ->description($prodi->akreditasiAktif ? 'Berlaku s.d ' . $prodi->akreditasiAktif->tanggal_berakhir->format('d M Y') : 'Perlu diperbarui')
                ->color($prodi->akreditasiAktif ? 'success' : 'warning')
                ->icon($prodi->akreditasiAktif ? 'heroicon-o-check-circle' : 'heroicon-o-exclamation-circle'),
            
            Stat::make('Total Dokumen', $totalDokumen)
                ->description($dokumenAsesor . ' terlihat oleh asesor')
                ->color('info')
                ->icon('heroicon-o-document-text'),
            
            Stat::make('Dosen Aktif', $totalDosen)
                ->description('Dosen tetap program studi')
                ->color('primary')
                ->icon('heroicon-o-user-group'),
            
            Stat::make('Tenaga Kependidikan', $totalTendik)
                ->description('Staf administrasi & laboran')
                ->color('secondary')
                ->icon('heroicon-o-briefcase'),
        ];
    }
}
