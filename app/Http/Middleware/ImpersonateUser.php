<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ImpersonateUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is being impersonated
        if (session()->has('impersonated_by')) {
            // Add impersonation indicator to the view
            view()->share('is_impersonating', true);
            view()->share('impersonated_by', session('impersonated_by'));
        }

        return $next($request);
    }
}
