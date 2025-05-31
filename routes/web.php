<?php
// routes/web.php - Fixed version dengan Auth facade

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\AsesorController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Redirect root based on auth status
Route::get('/', function () {
  if (Auth::check()) {
    $user = Auth::user();

    switch ($user->role) {
      case 'gjm':
        return redirect('/gjm');
      case 'ujm':
        return redirect('/ujm');
      case 'asesor':
        return redirect()->route('asesor.dashboard');
      default:
        return redirect()->route('login');
    }
  }

  return redirect()->route('login');
});

// Guest routes (not logged in)
Route::middleware('guest')->group(function () {
  Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
  Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});

// Authenticated routes (must be logged in)
Route::middleware('auth')->group(function () {
  // Logout route
  Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

  // Asesor routes - tanpa role middleware dulu
  Route::get('/dashboard', [AsesorController::class, 'dashboard'])->name('asesor.dashboard');
  Route::get('/dokumen-institusi', [AsesorController::class, 'dokumenInstitusi'])->name('asesor.dokumen-institusi');
  Route::get('/dokumen-fakultas', [AsesorController::class, 'dokumenFakultas'])->name('asesor.dokumen-fakultas');
  Route::get('/dokumen-prodi', [AsesorController::class, 'dokumenProdi'])->name('asesor.dokumen-prodi');
  Route::get('/informasi-tambahan', [AsesorController::class, 'informasiTambahan'])->name('asesor.informasi-tambahan');
});

// Temporary route untuk check user role
Route::get('/check-role', function () {
  if (Auth::check()) {
    return response()->json([
      'user' => Auth::user()->name,
      'email' => Auth::user()->email,
      'role' => Auth::user()->role,
      'is_active' => Auth::user()->is_active
    ]);
  }

  return response()->json(['message' => 'Not authenticated']);
})->middleware('auth');

// Debug route - cek auth status
Route::get('/debug-auth', function () {
  return response()->json([
    'auth_check' => Auth::check(),
    'user' => Auth::user(),
    'guard' => Auth::guard()->name ?? 'default',
    'session' => session()->all()
  ]);
});
