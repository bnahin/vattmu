<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

class LogLastActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $expires = Carbon::now()->addMinutes(5);
            Cache::put('user-online-' . Auth::user()->id, true, $expires);

            $user = Auth::user();
            $user->last_activity = Carbon::now();
            $user->save();
        }

        return $next($request);
    }
}
