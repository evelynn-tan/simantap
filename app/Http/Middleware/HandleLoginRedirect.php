<?php

namespace App\Http\Middleware; 

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HandleLoginRedirect
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            if (Auth::user()->role == 'operator') {
                // Jika rolenya operator, arahkan ke dashboard admin
                return redirect()->route('admin.dashboard');
            } elseif (Auth::user()->role == 'pegawai') {
                // Jika rolenya pegawai, arahkan ke dashboard pegawai
                return redirect()->route('pegawai.dashboard');
            }
        }
        return $next($request);
    }
}
