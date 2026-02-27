<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Inertia\Inertia;


class PageMaintenance
{
    /**
     * Halaman yang ingin dimatikan (bisa pakai wildcard atau URI spesifik)
     */
    protected array $maintenanceRoutes = [
    ];

    public function handle(Request $request, Closure $next): Response
    {
        foreach ($this->maintenanceRoutes as $route) {
            if ($request->is($route)) {
                return Inertia::render('Error/503') // nama komponen Vue
                    ->toResponse($request)
                    ->setStatusCode(503);
            }
        }

        return $next($request);
    }

}
