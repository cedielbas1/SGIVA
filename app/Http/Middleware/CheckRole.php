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
            return redirect()->route('login');
        }

        $userRole = $request->user()->role;

        // Permitir super_admin en todas las rutas protegidas por role
        if ($userRole === 'super_admin') {
            return $next($request);
        }

        // Comprobar si el rol del usuario está en la lista de roles permitidos
        if (!empty($roles) && in_array($userRole, $roles, true)) {
            return $next($request);
        }

        abort(403, 'No tienes permiso para acceder a este recurso.');
    }
}
