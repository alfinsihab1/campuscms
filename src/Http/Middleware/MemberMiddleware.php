<?php

namespace Ajifatur\FaturCMS\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class MemberMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check() && $request->user()->is_admin == 0) {
            // Aktivitas
            log_activity();

            // Return
            return $next($request);
        }
        
        return redirect('/login');
    }
}
