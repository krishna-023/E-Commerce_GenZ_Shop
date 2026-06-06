<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user) {
            return $request->expectsJson()
                ? response()->json(['message' => 'Unauthenticated.'], 401)
                : redirect()->route('login');
        }

        // Super Admin bypass
        if ($user->role === 'super-admin') {
            return $next($request);
        }

        // Load all roles from config
        $allRoles = config('role_permissions', []);
        $rolePermissions = $allRoles[$user->role] ?? [];

        if (in_array('all', $rolePermissions)) {
            return $next($request);
        }

        // Match by route name
        $currentRoute = $request->route()->getName();

        if (!in_array($currentRoute, $rolePermissions)) {
            return $request->expectsJson()
                ? response()->json(['message' => 'Unauthorized.'], 403)
                : abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
