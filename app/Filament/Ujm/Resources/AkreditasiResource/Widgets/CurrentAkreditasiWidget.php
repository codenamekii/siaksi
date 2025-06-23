<?php

namespace App\Filament\Ujm\Resources\AkreditasiResource\Widgets;

use App\Models\AkreditasiProdi;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class CurrentAkreditasiWidget extends Widget
{
  protected static string $view = 'filament.ujm.widgets.current-akreditasi';

  protected int | string | array $columnSpan = 'full';

  protected function getViewData(): array
  {
    $currentAkreditasi = AkreditasiProdi::where('program_studi_id', Auth::user()->programStudi?->id)
      ->where('is_active', true)
      ->first();

    return [
      'akreditasi' => $currentAkreditasi,
      'programStudi' => Auth::user()->programStudi,
    ];
  }
}
