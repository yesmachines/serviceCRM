<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckAdminPermission {

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission): Response {
        if (Auth::guard('web')->user()->can($permission)) {
            return $next($request);
        }

        alert()->error('No Access!', 'You don\'t have permission to access this page.');
        return redirect()->route('dashboard');
    }
}
