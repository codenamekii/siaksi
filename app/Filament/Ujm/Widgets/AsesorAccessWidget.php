<?php
// Lokasi file: app/Filament/Ujm/Widgets/AsesorAccessWidget.php

namespace App\Filament\Ujm\Widgets;

use Filament\Widgets\Widget;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AsesorAccessWidget extends Widget
{
  protected static string $view = 'filament.ujm.widgets.asesor-access-widget';

  protected int | string | array $columnSpan = 'full';

  protected static ?int $sort = 4;

  // Hide this widget if current user is GJM (they already have access)
  public static function canView(): bool
  {
    return Auth::user()->role === 'ujm';
  }

  public function goToAsesorDashboard()
  {
    // UJM still needs to switch identity
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
