<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class User
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //check role. if role is not admin, redirect to welcome page
        if (!Auth::check()) {
            // Redirect the user to the login page if they are not logged in.
            return redirect('login');
        }

        if (!$request->user()->hasRole('user')) {
            // Redirect the user to the admin dashboard if they are an admin.
            return redirect('/dashboard');
        }

        return $next($request);
    }
}
