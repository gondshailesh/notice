<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Please log in to continue.');
        }

        if (Auth::user()->role !== 1) {
            return redirect()->route('dashboard')
                ->with('error', 'You do not have permission to access the admin area.');
        }

        return $next($request);
    }
}