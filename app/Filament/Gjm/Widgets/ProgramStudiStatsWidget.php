<?php

namespace App\Filament\Gjm\Widgets;

use App\Models\ProgramStudi;
use App\Models\User;
use App\Models\AkreditasiProdi;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class ProgramStudiStatsWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        $user = Auth::user();
        $fakultasId = $user->fakultas_id;

        // Get prodi stats
        $totalProdi = ProgramStudi::when($fakultasId, function ($query) use ($fakultasId) {
            return $query->where('fakultas_id', $fakultasId);
        })->count();

        // Get active UJM count
        $activeUjm = User::where('role', 'ujm')
            ->where('is_active', true)
            ->when($fakultasId, function ($query) use ($fakultasId) {
                return $query->whereHas('programStudi', function ($q) use ($fakultasId) {
                    $q->where('fakultas_id', $fakultasId);
                });
            })
            ->count();

        // Get accredited prodi count
        $accreditedProdi = ProgramStudi::when($fakultasId, function ($query) use ($fakultasId) {
            return $query->where('fakultas_id', $fakultasId);
        })
            ->whereHas('akreditasi', function ($query) {
                $query->where('is_active', true)->where('tanggal_berakhir', '>', now());
            })
            ->count();

        return [
            Stat::make('Total Program Studi', $totalProdi)
                ->description('Program studi di fakultas')
                ->icon('heroicon-o-academic-cap')
                ->color('primary')
                ->chart([7, 2, 10, 3, 15, 4, 17]),

            Stat::make('UJM Aktif', $activeUjm)
                ->description('Unit Jaminan Mutu aktif')
                ->icon('heroicon-o-users')
                ->color('success')
                ->extraAttributes([
                    'class' => 'cursor-pointer',
                ])
                ->url(route('filament.gjm.resources.users.index', ['tableFilters[role][value]' => 'ujm'])),

            Stat::make('Prodi Terakreditasi', $accreditedProdi . ' dari ' . $totalProdi)
                ->description($totalProdi > 0 ? number_format(($accreditedProdi / $totalProdi) * 100, 1) . '% terakreditasi' : 'Belum ada prodi')
                ->icon('heroicon-o-shield-check')
                ->color($accreditedProdi === $totalProdi ? 'success' : 'warning'),
        ];
    }
}
