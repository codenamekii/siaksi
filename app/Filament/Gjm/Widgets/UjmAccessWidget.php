<?php
// Lokasi file: app/Filament/Gjm/Widgets/UjmAccessWidget.php

namespace App\Filament\Gjm\Widgets;

use Filament\Widgets\Widget;
use App\Models\User;
use App\Models\ProgramStudi;
use Illuminate\Support\Facades\Auth;

class UjmAccessWidget extends Widget
{
  protected static string $view = 'filament.gjm.widgets.ujm-access-widget';

  protected int | string | array $columnSpan = 'full';

  protected static ?int $sort = 5;

  public function getUjmUsers()
  {
    return User::where('role', 'ujm')
      ->where('is_active', true)
      ->with('programStudi.fakultas')
      ->orderBy('name')
      ->get();
  }

  public function loginAsUjm($ujmId)
  {
    // GJM doesn't need to switch identity, just redirect
    $ujm = User::find($ujmId);

    if ($ujm && $ujm->role === 'ujm') {
      // Set session to indicate which UJM dashboard GJM is viewing
      session(['viewing_ujm_id' => $ujmId]);
      session(['viewing_as_gjm' => true]);

      // Redirect directly to UJM dashboard
      return redirect('/ujm');
    }

    return redirect()->back()->with('error', 'Unable to access UJM dashboard.');
  }

  public function goToAsesorDashboard()
  {
    // GJM doesn't need to switch identity
    // Just set session flag and redirect
    session(['viewing_as_gjm' => true]);

    // Redirect directly to asesor dashboard
    return redirect('/asesor/dashboard');
  }
}
