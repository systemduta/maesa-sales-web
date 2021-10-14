<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsChasier
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!auth()->user()->hasRole(['user']))
            return $next($request);

        Auth::logout();
        return redirect()->to('/')->with('warning', 'Your session has expired because your account is deactivated.');
    }
}
