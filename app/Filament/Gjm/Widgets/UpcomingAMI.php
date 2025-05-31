<?php

namespace App\Filament\Gjm\Widgets;

use App\Models\JadwalAMI;
use Filament\Widgets\Widget;

class UpcomingAMI extends Widget
{
  protected static string $view = 'filament.gjm.widgets.upcoming-ami';

  protected static ?int $sort = 3;

  protected int | string | array $columnSpan = [
    'md' => 2,
    'xl' => 3,
  ];

  protected function getViewData(): array
  {
    return [
      'upcomingAMI' => JadwalAMI::with('programStudi')
        ->where('status', 'scheduled')
        ->where('tanggal_mulai', '>=', now())
        ->orderBy('tanggal_mulai')
        ->limit(5)
        ->get(),
    ];
  }
}
