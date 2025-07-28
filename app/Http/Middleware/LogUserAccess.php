<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogUserAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            activity('akses')
                ->causedBy(auth()->user())
                ->withProperties(['url' => $request->fullUrl()])
                ->log('Mengakses halaman');
        }

        return $next($request);
    }
}
