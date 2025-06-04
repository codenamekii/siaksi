<?php

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
        // Quick test route to bypass middleware
        Route::get('/quick-asesor-test', function () {
          // Login as first asesor user
          $asesor = \App\Models\User::where('role', 'asesor')->where('is_active', true)->first();

          if (!$asesor) {
            return 'No active asesor user found in database!';
          }

          Auth::login($asesor);

          return "
            <h2>Quick Asesor Test</h2>
            <p>Logged in as: {$asesor->name}</p>
            <p>Email: {$asesor->email}</p>
            <p>Role: {$asesor->role}</p>
            <hr>
            <p><a href='/asesor/dashboard'>Go to Asesor Dashboard</a></p>
            <p><a href='/check-role'>Check Role</a></p>
            <hr>
            <p>If you get 403 error when clicking dashboard link, the problem is in the middleware.</p>
        ";
        });

        // Direct asesor dashboard test
        Route::get('/test-asesor-direct', function () {
          $asesor = \App\Models\User::where('role', 'asesor')->where('is_active', true)->first();

          if (!$asesor) {
            return 'No active asesor user found!';
          }

          Auth::login($asesor);

          // Try to load dashboard directly
          try {
            $controller = new \App\Http\Controllers\AsesorController();
            return $controller->dashboard(request());
          } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
          }
        });
    }

    // Include role switching routes
    require __DIR__ . '/role-switch.php';
  }

  return redirect()->route('login');
});

// Redirect /dashboard based on role
Route::get('/dashboard', function () {
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
})->middleware('auth');

// Guest routes (not logged in)
Route::middleware('guest')->group(function () {
  Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
  Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});

// Authenticated routes (must be logged in)
Route::middleware('auth')->group(function () {
  // Logout routes
  Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
  Route::get('/logout', [LogoutController::class, 'logout'])->name('logout.get'); // For testing

  // Asesor routes - TEMPORARY WITHOUT asesor middleware
  Route::prefix('asesor')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AsesorController::class, 'dashboard'])->name('asesor.dashboard');

    // Dokumen routes
    Route::get('/dokumen-institusi', [AsesorController::class, 'dokumenInstitusi'])->name('asesor.dokumen-institusi');
    Route::get('/dokumen-fakultas', [AsesorController::class, 'dokumenFakultas'])->name('asesor.dokumen-fakultas');
    Route::get('/dokumen-prodi', [AsesorController::class, 'dokumenProdi'])->name('asesor.dokumen-prodi');

    // Informasi
    Route::get('/informasi-tambahan', [AsesorController::class, 'informasiTambahan'])->name('asesor.informasi-tambahan');

    // Future routes (to be implemented)
    // Route::get('/statistik', [AsesorController::class, 'statistik'])->name('asesor.statistik');
    // Route::get('/profile', [AsesorController::class, 'profile'])->name('asesor.profile');
    // Route::get('/search', [AsesorController::class, 'search'])->name('asesor.search');
  });
});

// Debug routes (only for development)
if (app()->environment('local')) {
  // Check user role
  Route::get('/check-role', function () {
    if (Auth::check()) {
      return response()->json([
        'authenticated' => true,
        'user' => Auth::user()->name,
        'email' => Auth::user()->email,
        'role' => Auth::user()->role,
        'is_active' => Auth::user()->is_active,
        'can_access_asesor' => Auth::user()->role === 'asesor',
        'session_data' => session()->all()
      ]);
    }

    return response()->json([
      'authenticated' => false,
      'message' => 'Not authenticated'
    ]);
  })->middleware('auth');

  // Debug auth status
  Route::get('/debug-auth', function () {
    return response()->json([
      'auth_check' => Auth::check(),
      'user' => Auth::user(),
      'guard' => Auth::guard()->name ?? 'default',
      'session' => session()->all()
    ]);
  });

  // Test asesor access
  Route::get('/test-asesor', function () {
    if (!Auth::check()) {
      return 'Not logged in. <a href="/login">Login</a>';
    }

    $user = Auth::user();
    return "
            <h2>Current User</h2>
            <p>Name: {$user->name}</p>
            <p>Email: {$user->email}</p>
            <p>Role: {$user->role}</p>
            <p>Is Active: " . ($user->is_active ? 'Yes' : 'No') . "</p>
            <p>Is Asesor: " . ($user->role === 'asesor' ? 'Yes' : 'No') . "</p>
            <hr>
            <a href='/asesor/dashboard'>Try to access Asesor Dashboard</a><br>
            <a href='/logout'>Logout</a>
        ";
  })->middleware('auth');

  // Quick test route to bypass middleware
  Route::get('/quick-asesor-test', function () {
    // Login as first asesor user
    $asesor = \App\Models\User::where('role', 'asesor')->where('is_active', true)->first();

    if (!$asesor) {
      return 'No active asesor user found in database!';
    }

    Auth::login($asesor);

    return "
            <h2>Quick Asesor Test</h2>
            <p>Logged in as: {$asesor->name}</p>
            <p>Email: {$asesor->email}</p>
            <p>Role: {$asesor->role}</p>
            <hr>
            <p><a href='/asesor/dashboard'>Go to Asesor Dashboard</a></p>
            <p><a href='/check-role'>Check Role</a></p>
            <hr>
            <p>If you get 403 error when clicking dashboard link, the problem is in the middleware.</p>
        ";
  });
}
