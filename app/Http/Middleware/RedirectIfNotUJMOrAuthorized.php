<?php
// Lokasi file: app/Http/Middleware/RedirectIfNotUJMOrAuthorized.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotUJMOrAuthorized
{
  /**
   * Handle an incoming request.
   */
  public function handle(Request $request, Closure $next)
  {
    if (!Auth::check()) {
      return redirect()->route('login');
    }

    $user = Auth::user();

    // Allow if user is UJM
    if ($user->role === 'ujm') {
      // Check if user is active
      if (!$user->is_active) {
        Auth::logout();
        return redirect()->route('login')->with('error', 'Akun Anda tidak aktif. Silakan hubungi administrator.');
      }
      return $next($request);
    }

    // Allow if GJM is accessing as UJM (check session)
    if (session('gjm_original_user')) {
      return $next($request);
    }

    // Otherwise redirect based on role
    switch ($user->role) {
      case 'gjm':
        return redirect('/gjm');
      case 'asesor':
        return redirect()->route('asesor.dashboard');
      default:
        abort(403, 'Unauthorized access.');
    }
  }
}

// Lokasi file: app/Http/Middleware/RedirectIfNotAsesorOrAuthorized.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotAsesorOrAuthorized
{
  public function handle(Request $request, Closure $next): Response
  {
    if (!Auth::check()) {
      return redirect()->route('login');
    }

    $user = Auth::user();

    // Allow if user is Asesor
    if ($user->role === 'asesor') {
      return $next($request);
    }

    // Allow if GJM or UJM is accessing as Asesor (check session)
    if (session('gjm_original_user') || session('ujm_original_user')) {
      return $next($request);
    }

    // Otherwise deny access
    abort(403, 'Unauthorized access.');
  }
}