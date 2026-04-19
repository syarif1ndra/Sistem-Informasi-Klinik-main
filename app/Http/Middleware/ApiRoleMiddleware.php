<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Generic role checker untuk API (Sanctum).
 * Usage di routes: ->middleware('api.role:admin') atau 'api.role:admin,bidan'
 */
class ApiRoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): mixed
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated.'], 401);
        }

        if (!in_array($user->role, $roles, true)) {
            return response()->json(['success' => false, 'message' => 'Forbidden. Anda tidak memiliki akses.'], 403);
        }

        return $next($request);
    }
}
