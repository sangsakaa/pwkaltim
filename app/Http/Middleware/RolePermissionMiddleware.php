<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RolePermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $permission)
    {
        $user = auth()->user();

        if (!$user) {
            abort(401);
        }

        if (!$user->hasRolePermission($permission)) {
            abort(403, 'Permission denied by role.');
        }

        return $next($request);
    }
}
