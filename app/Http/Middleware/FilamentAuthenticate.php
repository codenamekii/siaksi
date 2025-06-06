<?php
// Lokasi file: app/Http/Middleware/FilamentAuthenticate.php

namespace App\Http\Middleware;

use Filament\Http\Middleware\Authenticate as FilamentAuthenticateBase;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FilamentAuthenticate extends FilamentAuthenticateBase
{
  protected function authenticate($request, array $guards): void
  {
    $panelId = filament()->getCurrentPanel()?->getId();

    // Check if user is authenticated
    if (!Auth::check()) {
      parent::authenticate($request, $guards);
      return;
    }

    // Allow access based on panel and session
    $user = Auth::user();

    // For UJM panel
    if ($panelId === 'ujm') {
      // Allow if user is UJM or GJM accessing as UJM
      if ($user->role === 'ujm' || session('gjm_original_user')) {
        return;
      }
    }

    // For GJM panel
    if ($panelId === 'gjm') {
      // Allow only GJM
      if ($user->role === 'gjm') {
        return;
      }
    }

    // Otherwise authenticate normally
    parent::authenticate($request, $guards);
  }
}