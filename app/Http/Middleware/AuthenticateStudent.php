<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateStudent
{
    public function handle(Request $request, Closure $next)
    {
        $student = Auth::guard('student')->user();

        if (! $student || ! $student->is_active) {
            Auth::guard('student')->logout();

            return redirect()->route('lapor.login');
        }

        $response = $next($request);
        $response->headers->set('Cache-Control', 'no-store, private');

        return $response;
    }
}
