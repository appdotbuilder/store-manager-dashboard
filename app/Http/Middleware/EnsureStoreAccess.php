<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureStoreAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        // Super admins have access to everything
        if ($user->isSuperAdmin()) {
            return $next($request);
        }

        // Store admins must have a store assigned
        if ($user->isStoreAdmin() && !$user->store_id) {
            abort(403, 'No store assigned to your account');
        }

        return $next($request);
    }
}