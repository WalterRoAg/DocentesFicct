<?php

namespace App\Http\Middleware;

use Closure;

class PermisoMiddleware
{
    public function handle($request, Closure $next, $permiso)
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Verificar permisos de forma más robusta
        $tienePermiso = $user->rol && $user->rol->permisos()
            ->where('nombre', $permiso)
            ->exists();

        if (!$tienePermiso) {
            abort(403, 'No tienes el permiso requerido: ' . $permiso);
        }

        return $next($request);
    }
}