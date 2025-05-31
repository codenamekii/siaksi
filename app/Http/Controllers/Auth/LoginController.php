<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
  public function showLoginForm()
  {
    return view('auth.login');
  }

  public function login(Request $request)
  {
    $credentials = $request->validate([
      'email' => ['required', 'email'],
      'password' => ['required'],
    ]);

    if (Auth::attempt($credentials, $request->boolean('remember'))) {
      $request->session()->regenerate();

      $user = Auth::user();

      // Redirect berdasarkan role
      if ($user->role === 'gjm') {
        return redirect('/gjm');
      } elseif ($user->role === 'ujm') {
        return redirect('/ujm');
      } elseif ($user->role === 'asesor') {
        return redirect()->route('asesor.dashboard');
      }

      return redirect('/');
    }

    throw ValidationException::withMessages([
      'email' => __('auth.failed'),
    ]);
  }
}
