<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role_id): Response
    {
        if (!Auth::user()) {
            abort(401, 'unauthorized');
        }
        if (!$request->user()->hasRole($role_id)) {
            abort(403, 'unauthorized');
        }

        return $next($request);
    }
}
