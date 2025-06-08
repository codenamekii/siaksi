<?php
// Lokasi file: routes/role-switch.php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

// Return to original dashboard - Simplified
Route::get('/return-to-gjm-dashboard', function () {
  // Clear any viewing session
  session()->forget(['viewing_as_gjm', 'viewing_ujm_id']);

  // Since GJM is still logged in, just redirect
  return redirect('/gjm')->with('success', 'Kembali ke dashboard GJM');
})->middleware('auth')->name('return.to.gjm');
