<?php

namespace LaravelLookbook\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthorizeLookbook
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
        // Check if the user is authorized to access the Lookbook interface
        if (!Auth::check() || !Auth::user()->can('access-lookbook')) {
            abort(403, 'Unauthorized access to Lookbook.');
        }

        return $next($request);
    }
}