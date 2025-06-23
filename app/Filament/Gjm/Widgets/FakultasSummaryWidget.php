<?php

namespace App\Filament\Gjm\Widgets;

use App\Models\Fakultas;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class FakultasSummaryWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $user = Auth::user();
        $fakultas = null;

        if ($user && $user->fakultas_id) {
            $fakultas = Fakultas::with('strukturOrganisasi')->withCount('programStudi')->find($user->fakultas_id);
        } elseif ($user && $user->role === 'gjm') {
            $fakultas = Fakultas::with('strukturOrganisasi')->withCount('programStudi')->first();
        }

        if (!$fakultas) {
            return [Stat::make('Status', 'Fakultas tidak ditemukan')->description('Silakan hubungi administrator')->color('danger')->icon('heroicon-o-x-circle')];
        }

        return [
            Stat::make('Fakultas', $fakultas->nama)
                ->description('Dekan: ' . ($fakultas->dekan ?? 'Belum diset'))
                ->icon('heroicon-o-building-library')
                ->color('primary'),

            Stat::make('Total Program Studi', $fakultas->program_studi_count)->description('Program studi terdaftar')->icon('heroicon-o-academic-cap')->color('success'),

            Stat::make('Struktur Organisasi', $fakultas->strukturOrganisasi()->where('is_active', true)->count() > 0 ? 'Tersedia' : 'Belum ada')
                ->description($fakultas->strukturOrganisasi()->where('is_active', true)->count() > 0 ? 'Klik untuk melihat' : 'Upload di menu Organisasi')
                ->icon('heroicon-o-rectangle-group')
                ->color($fakultas->strukturOrganisasi()->where('is_active', true)->count() > 0 ? 'info' : 'warning')
                ->url($fakultas->strukturOrganisasi()->where('is_active', true)->count() > 0 ? route('filament.gjm.resources.struktur-organisasi-fakultas.index') : null),
        ];
    }
}
