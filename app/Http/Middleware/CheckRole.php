<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle($request, Closure $next, $role)
    {
        if (!auth()->check() || auth()->user()->ruolo !== $role) {
            abort(403);
        }
        return $next($request);
    }
}
