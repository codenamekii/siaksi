<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotUJMOrGJM
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Check if user is authenticated
        if (!$user) {
            return redirect()->route('login');
        }

        // Check if user role is UJM or GJM
        $allowedRoles = ['ujm', 'gjm'];

        if (!in_array($user->role, $allowedRoles)) {
            // Redirect based on user role
            return $this->redirectBasedOnRole($user);
        }

        // If user is UJM or GJM, allow access
        return $next($request);
    }

    /**
     * Redirect user based on their role
     */
    protected function redirectBasedOnRole($user)
    {
        switch ($user->role) {
            case 'asesor':
                return redirect()->route('asesor.dashboard');
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'user':
                return redirect()->route('home');
            default:
                abort(403, 'Unauthorized access. Your role: ' . $user->role);
        }
    }
}
