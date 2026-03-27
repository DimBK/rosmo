<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->role === 'super_admin') {
            return $next($request);
        }

        if ($user->role !== $role) {
            abort(403, 'Unauthorized Access');
        }

        return $next($request);
    }
}
