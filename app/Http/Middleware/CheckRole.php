<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, $roleName)
    {
        if (!$request->user() || !$request->user()->roles()->where('name', $roleName)->exists()) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
