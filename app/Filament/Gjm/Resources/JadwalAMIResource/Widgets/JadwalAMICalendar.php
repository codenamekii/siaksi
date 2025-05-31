<?php

namespace App\Filament\Gjm\Resources\JadwalAMIResource\Widgets;

use App\Models\JadwalAMI;
use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;

class JadwalAMICalendar extends Widget
{
  protected static string $view = 'filament.gjm.widgets.jadwal-ami-calendar';

  protected int | string | array $columnSpan = 'full';

  protected function getViewData(): array
  {
    $jadwalAMI = JadwalAMI::with('programStudi')
      ->whereIn('status', ['scheduled', 'ongoing'])
      ->orderBy('tanggal_mulai')
      ->get();

    return [
      'jadwalAMI' => $jadwalAMI,
    ];
  }
}
