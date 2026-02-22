<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfNotInstalled
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! file_exists(storage_path('installed.lock'))) {
            if ($request->is('install') || $request->is('install/*')) {
                return $next($request);
            }
            return redirect()->route('install.welcome');
        }
        if ($request->is('install') || $request->is('install/*')) {
            return redirect('/');
        }
        return $next($request);
    }
}
