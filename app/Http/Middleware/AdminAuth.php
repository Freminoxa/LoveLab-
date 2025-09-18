<?php
// app/Http/Middleware/AdminAuth.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('admin_authenticated')) {
            return redirect()->route('admin.login')->withErrors(['error' => 'Please login first']);
        }

        return $next($request);
    }
}