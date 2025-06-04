<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

// GJM Routes for switching roles
Route::prefix('gjm')->middleware(['auth'])->group(function () {
  // Switch to UJM
  Route::get('/login-as-ujm/{ujm}', function ($ujmId) {
    $currentUser = Auth::user();

    // Check if current user is GJM
    if ($currentUser->role !== 'gjm') {
      abort(403, 'Unauthorized');
    }

    $ujm = User::findOrFail($ujmId);

    // Verify the user is UJM
    if ($ujm->role !== 'ujm') {
      return redirect()->back()->with('error', 'Invalid user role.');
    }

    // Store current user ID in session
    session(['gjm_original_user' => $currentUser->id]);

    // Login as UJM
    Auth::login($ujm);

    // Redirect to UJM dashboard
    return redirect('/ujm')->with('success', 'Berhasil masuk sebagai ' . $ujm->name);
  })->name('filament.gjm.widgets.ujm-access.login');

  // Switch to Asesor
  Route::get('/login-as-asesor', function () {
    $currentUser = Auth::user();

    // Check if current user is GJM
    if ($currentUser->role !== 'gjm') {
      abort(403, 'Unauthorized');
    }

    // Get first active asesor
    $asesor = User::where('role', 'asesor')->where('is_active', true)->first();

    if (!$asesor) {
      return redirect()->back()->with('error', 'Tidak ada asesor aktif.');
    }

    // Store current user ID in session
    session(['gjm_original_user' => $currentUser->id]);

    // Login as asesor
    Auth::login($asesor);

    // Redirect to asesor dashboard
    return redirect('/asesor/dashboard')->with('success', 'Berhasil masuk sebagai Asesor');
  })->name('filament.gjm.widgets.ujm-access.asesor');
});

// UJM Routes for switching roles
Route::prefix('ujm')->middleware(['auth'])->group(function () {
  // Switch to Asesor
  Route::get('/asesor-access', function () {
    $currentUser = Auth::user();

    // Check if current user is UJM
    if ($currentUser->role !== 'ujm') {
      abort(403, 'Unauthorized');
    }

    // Get first active asesor
    $asesor = User::where('role', 'asesor')->where('is_active', true)->first();

    if (!$asesor) {
      return redirect()->back()->with('error', 'Tidak ada asesor aktif.');
    }

    // Store current user ID in session
    session(['ujm_original_user' => $currentUser->id]);

    // Login as asesor
    Auth::login($asesor);

    // Redirect to asesor dashboard
    return redirect('/asesor/dashboard')->with('success', 'Berhasil masuk sebagai Asesor');
  });

  // Return to original user
  Route::get('/return-to-original', function () {
    $originalUserId = session('ujm_original_user');

    if ($originalUserId) {
      $originalUser = User::find($originalUserId);

      if ($originalUser) {
        // Clear session
        session()->forget('ujm_original_user');

        // Login back as original user
        Auth::login($originalUser);

        return redirect('/ujm')->with('success', 'Berhasil kembali ke dashboard UJM');
      }
    }

    return redirect('/ujm');
  });
});

// Return to original user from any dashboard
Route::get('/return-to-original-dashboard', function () {
  $gjmOriginalUser = session('gjm_original_user');
  $ujmOriginalUser = session('ujm_original_user');

  if ($gjmOriginalUser) {
    $originalUser = User::find($gjmOriginalUser);
    if ($originalUser) {
      session()->forget('gjm_original_user');
      Auth::login($originalUser);
      return redirect('/gjm')->with('success', 'Berhasil kembali ke dashboard GJM');
    }
  }

  if ($ujmOriginalUser) {
    $originalUser = User::find($ujmOriginalUser);
    if ($originalUser) {
      session()->forget('ujm_original_user');
      Auth::login($originalUser);
      return redirect('/ujm')->with('success', 'Berhasil kembali ke dashboard UJM');
    }
  }

  // Fallback - redirect based on current user role
  $user = Auth::user();
  if ($user) {
    switch ($user->role) {
      case 'gjm':
        return redirect('/gjm');
      case 'ujm':
        return redirect('/ujm');
      case 'asesor':
        return redirect('/asesor/dashboard');
    }
  }

  return redirect('/');
})->middleware('auth')->name('return.to.original');
