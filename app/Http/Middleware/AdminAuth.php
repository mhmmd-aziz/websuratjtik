<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        // Jika BELUM login
        if (
            !session()->has('admin') ||
            !session()->has('admin_id')
        ) {
            // Izinkan akses ke halaman login & proses login
            if (
                $request->routeIs('admin.login') ||
                $request->routeIs('admin.login.process')
            ) {
                return $next($request);
            }

            // Selain itu, tendang ke login
            return redirect()
                ->route('admin.login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        // Jika sudah login
        return $next($request);
    }
}
