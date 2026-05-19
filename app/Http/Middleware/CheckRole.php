<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     * 
     * Uso: Route::middleware('check_role:admin')->group(...)
     */
    public function handle(Request $request, Closure $next, ...$roles): mixed
    {
        if (!$request->user()) {
            return redirect('login');
        }

        foreach ($roles as $role) {
            if ($request->user()->role === $role) {
                return $next($request);
            }
            
            // Permitir super_admin en todas las rutas de admin
            if ($request->user()->role === 'super_admin' && $role === 'admin') {
                return $next($request);
            }
        }

        abort(403, 'No tienes permiso para acceder a este recurso.');
    }
}
