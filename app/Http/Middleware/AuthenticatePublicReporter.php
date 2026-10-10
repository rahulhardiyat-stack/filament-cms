<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatePublicReporter
{
    public function handle(Request $request, Closure $next)
    {
        $guard = Auth::guard('public_reporter');
        if (! $guard->user()?->is_active) {
            $guard->logout();

            return redirect()->route('lapor.public.login');
        }
        $response = $next($request);
        $response->headers->set('Cache-Control', 'no-store, private');

        return $response;
    }
}
