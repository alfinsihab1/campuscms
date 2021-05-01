<?php

namespace Ajifatur\FaturCMS\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class GuestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        // Aktivitas
        log_activity();

        if (Auth::guard($guard)->check() && $request->user()->is_admin == 1 && is_int(strpos($request->path(), 'login'))) {
            return redirect()->route('admin.dashboard');
        }
        elseif (Auth::guard($guard)->check() && $request->user()->is_admin == 0 && is_int(strpos($request->path(), 'login'))) {
            return redirect()->route('member.dashboard');
        }

        return $next($request);
    }
}
