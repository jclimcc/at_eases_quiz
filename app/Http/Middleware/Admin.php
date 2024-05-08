<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if ($request->user()->hasRole('user')) {
            // Redirect the user to the admin dashboard if they are an admin.
            return redirect('/dashboard');
        }
        if ($request->user()->hasRole('driver')) {
            // Redirect the user to the admin dashboard if they are an admin.
            return redirect('driver/dashboard');
        }
        return $next($request);
    }
}
