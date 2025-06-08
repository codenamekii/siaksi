<?php
// Lokasi file: app/Http/Middleware/RedirectIfNotUJMOrGJM.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotUJMOrGJM
{
  /**
   * Handle an incoming request.
   * Allow access if user is UJM OR GJM (super admin)
   */
  public function handle(Request $request, Closure $next)
  {
    if (!Auth::check()) {
      return redirect()->route('login');
    }

    $user = Auth::user();

    // Allow access if user is ujm OR gjm (super admin)
    if ($user->role === 'ujm' || $user->role === 'gjm') {
      // Set a flag to indicate if GJM is viewing as super admin
      if ($user->role === 'gjm') {
        session(['viewing_as_gjm' => true]);
      }
      return $next($request);
    }

    // Check if user is active
    if (!$user->is_active) {
      Auth::logout();
      return redirect()->route('login')->with('error', 'Akun Anda tidak aktif. Silakan hubungi administrator.');
    }

    // Redirect based on user role
    switch ($user->role) {
      case 'asesor':
        return redirect()->route('asesor.dashboard');
      default:
        abort(403, 'Unauthorized access.');
    }
  }
}