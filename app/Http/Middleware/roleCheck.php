<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class roleCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, ...$roles)
    {
        $userRoles = userrole(Auth::user()->person_id);

        // Cek apakah user punya salah satu role yang dibutuhkan
        if (empty(array_intersect($roles, $userRoles))) {
            abort(403);
        }

        return $next($request);
    }
}
