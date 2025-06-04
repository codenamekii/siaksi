<?php

namespace App\Filament\Gjm\Widgets;

use Filament\Widgets\Widget;
use App\Models\JadwalAMI;

class UpcomingAMI extends Widget
{
  protected static string $view = 'filament.gjm.widgets.upcoming-ami';

  protected int | string | array $columnSpan = 'full';

  protected static ?int $sort = 2;

  public function getUpcomingAMI()
  {
    return JadwalAMI::where('tanggal_mulai', '>=', now())
      ->orderBy('tanggal_mulai')
      ->take(5)
      ->get();
  }
}
