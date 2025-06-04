<?php

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
    $ujm = User::find($ujmId);

    if ($ujm && $ujm->role === 'ujm') {
      // Store current user ID to return later
      session(['gjm_original_user' => Auth::id()]);

      // Login as UJM
      Auth::login($ujm);

      // Redirect to UJM dashboard
      return redirect('/ujm');
    }

    return redirect()->back()->with('error', 'Unable to access UJM dashboard.');
  }

  public function goToAsesorDashboard()
  {
    // Get first asesor user or create temporary session
    $asesor = User::where('role', 'asesor')->where('is_active', true)->first();

    if ($asesor) {
      // Store current user ID to return later
      session(['gjm_original_user' => Auth::id()]);

      // Login as asesor
      Auth::login($asesor);

      // Redirect to asesor dashboard
      return redirect('/asesor/dashboard');
    }

    return redirect()->back()->with('error', 'No active asesor user found.');
  }
}