<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembimbingMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('pegawai')->check()) {
            $pegawai = Auth::guard('pegawai')->user();

            if ($pegawai->role_temp == 'regular') {
                return $next($request);
            }
        }

        Auth::guard('pegawai')->logout();
        return redirect('');
    }
}
