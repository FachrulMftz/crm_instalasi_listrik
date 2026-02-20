<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        $user = auth()->user();

        if (!$user) {
            abort(403);
        }
        
        $allowedRoles = [];

        foreach ($roles as $roleGroup) {
            foreach (explode(',', $roleGroup) as $role) {
                $allowedRoles[] = trim($role);
            }
        }

        if (! in_array($user->role, $allowedRoles)) {
            abort(403);
        }

        return $next($request);
    }
}