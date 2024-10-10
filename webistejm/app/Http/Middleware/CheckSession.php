<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class CheckSession
{
    public function handle($request, Closure $next)
    {
        Log::info('Checking session in CheckSession middleware.', ['session' => session()->all()]);

        if (!session()->has('user')) {
            Log::info('Session expired or user not logged in.');
            return redirect()->route('login')->with('error', 'Session expired, please login again.');
        }

        $user = session('user');
        Log::info('User found in session.', ['user' => $user]);

        Log::info('Session valid, proceeding to next middleware.');
        return $next($request);
    }
}
