<?php
// Lokasi file: app/Http/Middleware/RedirectIfNotAsesorOrGJM.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotAsesorOrGJM
{
  /**
   * Handle an incoming request.
   * Allow access if user is Asesor OR GJM (super admin)
   */
  public function handle(Request $request, Closure $next): Response
  {
    if (!Auth::check()) {
      return redirect()->route('login');
    }

    $user = Auth::user();

    // Allow access if user is asesor OR gjm (super admin)
    if ($user->role === 'asesor' || $user->role === 'gjm') {
      // Set a flag to indicate if GJM is viewing as super admin
      if ($user->role === 'gjm') {
        session(['viewing_as_gjm' => true]);
      }
      return $next($request);
    }

    // Redirect based on user role
    switch ($user->role) {
      case 'ujm':
        return redirect('/ujm');
      default:
        abort(403, 'Unauthorized access.');
    }
  }
}