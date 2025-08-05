<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminOrPembimbingMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Check authentication
        if (!Auth::guard('pegawai')->check()) {
            return $this->forceLogout();
        }

        $pegawai = Auth::guard('pegawai')->user();
        
        // Check roles (pastikan nilai role_temp sesuai database)
        if (!in_array($pegawai->role_temp, ['admin', 'regular', 'ketua_tim', 'pimpinan'])) {
            return $this->forceLogout();
        }

        // Set layout based on role (opsional)
        if ($pegawai->role_temp === 'admin') {
            $request->attributes->set('layout', 'layouts.admin');
        }
        else if ($pegawai->role_temp === 'ketua_tim') {
            $request->attributes->set('layout', 'layouts.ketua-tim');
        }
        else if ($pegawai->role_temp === 'pimpinan') {
            $request->attributes->set('layout', 'layouts.pimpinan');
        }
        else {
            $request->attributes->set('layout', 'layouts.pembimbing');
        }

        return $next($request);
    }

    protected function forceLogout(): Response
    {
        Auth::guard('pegawai')->logout();
        return redirect('/login')->withErrors([
            'message' => 'Anda tidak memiliki akses ke halaman ini'
        ]);
    }
}