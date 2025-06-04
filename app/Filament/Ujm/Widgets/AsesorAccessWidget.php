<?php

namespace App\Filament\Ujm\Widgets;

use Filament\Widgets\Widget;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AsesorAccessWidget extends Widget
{
  protected static string $view = 'filament.ujm.widgets.asesor-access-widget';

  protected int | string | array $columnSpan = 'full';

  protected static ?int $sort = 4;

  public function goToAsesorDashboard()
  {
    // Get first asesor user
    $asesor = User::where('role', 'asesor')->where('is_active', true)->first();

    if ($asesor) {
      // Store current user ID to return later
      session(['ujm_original_user' => Auth::id()]);

      // Login as asesor
      Auth::login($asesor);

      // Redirect to asesor dashboard
      return redirect('/asesor/dashboard');
    }

    return redirect()->back()->with('error', 'No active asesor user found.');
  }
}