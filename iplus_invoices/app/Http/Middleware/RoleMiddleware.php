<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Check if the user's role is not equal to the provided role
        if ($request->user()->role_id != $role) {
            abort(401, 'Your Are Not Authorized.');
        }

        return $next($request);
    }
}
