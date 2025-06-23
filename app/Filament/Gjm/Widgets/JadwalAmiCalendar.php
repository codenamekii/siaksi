<?php

namespace App\Filament\Gjm\Widgets;

use App\Models\JadwalAMI;
use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;

class JadwalAMICalendar extends Widget
{
    protected static string $view = 'filament.gjm.widgets.jadwal-ami-calendar';

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 2;

    public ?Model $record = null;

    protected function getViewData(): array
    {
        $jadwalAMI = JadwalAMI::where('status', '!=', 'cancelled')
            ->orderBy('tanggal_mulai')
            ->get()
            ->map(function ($jadwal) {
                return [
                    'id' => $jadwal->id,
                    'title' => $jadwal->nama_kegiatan,
                    'start' => $jadwal->tanggal_mulai->format('Y-m-d'),
                    'end' => $jadwal->tanggal_selesai->addDay()->format('Y-m-d'),
                    'color' => $this->getEventColor($jadwal->status),
                    // Use direct URL instead of route helper
                    'url' => '/gjm/jadwal-a-m-i-s/' . $jadwal->id . '/edit',
                ];
            });

        return [
            'events' => $jadwalAMI,
        ];
    }

    protected function getEventColor(string $status): string
    {
        return match ($status) {
            'draft' => '#6b7280',
            'scheduled' => '#3b82f6',
            'ongoing' => '#f59e0b',
            'completed' => '#10b981',
            'cancelled' => '#ef4444',
            default => '#6b7280',
        };
    }

    public static function canView(): bool
    {
        return true;
    }
}
