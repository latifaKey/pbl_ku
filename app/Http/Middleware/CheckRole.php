<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|array  $roles  Role atau array roles yang diizinkan
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Jika user belum login, redirect ke halaman login
        if (Auth::guest()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Konversi parameter menjadi array jika multi-role
        $rolesArray = [];
        foreach ($roles as $role) {
            // Jika role berisi koma, pecah menjadi array
            if (strpos($role, ',') !== false) {
                $explodedRoles = explode(',', $role);
                $rolesArray = array_merge($rolesArray, $explodedRoles);
            } else {
                $rolesArray[] = $role;
            }
        }

        // Jika user memiliki salah satu role yang diizinkan, lanjutkan request
        if (in_array(Auth::user()->role, $rolesArray)) {
            return $next($request);
        }

        // Jika user tidak memiliki role yang diizinkan, redirect dengan pesan error
        return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke fitur ini.');
    }
}
