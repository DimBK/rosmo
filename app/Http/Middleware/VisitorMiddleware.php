<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Visitor;
use Carbon\Carbon;

class VisitorMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Only log web views (GET requests), excluding admin dashboard maybe
        if ($request->isMethod('get') && !$request->expectsJson()) {
            $ip = $request->ip();
            $date = Carbon::today()->toDateString();
            
            // Check if visitor with this IP already logged today
            $visited = Visitor::where('ip_address', $ip)
                              ->where('visited_date', $date)
                              ->exists();
                              
            if (!$visited) {
                Visitor::create([
                    'ip_address' => $ip,
                    'user_agent' => $request->userAgent(),
                    'visited_date' => $date
                ]);
            }
        }

        return $next($request);
    }
}
