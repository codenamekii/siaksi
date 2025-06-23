<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotUJM
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
   * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
   */
  public function handle(Request $request, Closure $next)
  {
    if (!Auth::check()) {
      return redirect()->route('login');
    }

    if (Auth::user()->role !== 'ujm') {
      // Redirect based on user role
      switch (Auth::user()->role) {
        case 'gjm':
          return redirect('/gjm');
        case 'asesor':
          return redirect()->route('asesor.dashboard');
        default:
          abort(403, 'Unauthorized access.');
      }
    }

    // Check if user is active
    if (!Auth::user()->is_active) {
      Auth::logout();
      return redirect()->route('login')->with('error', 'Akun Anda tidak aktif. Silakan hubungi administrator.');
    }

    return $next($request);
  }
}