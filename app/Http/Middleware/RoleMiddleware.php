<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        $user = $request->user();
        
        // Si no hay usuario autenticado, redirigir al login
        if (!$user) {
            return redirect()->route('login');
        }

        // ✅ PERMITIR ACCESO A RUTAS COMUNES SIN VERIFICAR ROL
        $allowedRoutes = [
            'admin.dashboard',
            'docente.dashboard', 
            'coordinador.dashboard',
            'account.update.profile',
            'account.update.password',
            'account.update.phone',
            'logout'
        ];

        $currentRoute = $request->route()->getName();
        
        // Si es una ruta permitida, dejar pasar
        if (in_array($currentRoute, $allowedRoutes)) {
            return $next($request);
        }

        // Verificar si el usuario tiene un rol válido
        if (!$user->rol) {
            abort(403, 'Usuario sin rol asignado.');
        }

        $nombreRol = strtolower($user->rol->nombre ?? '');
        
        // Permitir acceso si el rol del usuario está en los roles permitidos
        if (!in_array($nombreRol, array_map('strtolower', $roles), true)) {
            abort(403, 'No tienes permisos para acceder aquí.');
        }

        return $next($request);
    }
}