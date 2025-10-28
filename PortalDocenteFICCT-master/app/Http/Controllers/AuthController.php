<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showLogin()
    {
        // Si ya está autenticado, redirigir al dashboard según su rol
        if (Auth::check()) {
            return $this->redirectToDashboard();
        }
        
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validar los datos
        $request->validate([
            'correo' => 'required|email',
            'contrasena' => 'required|string|min:4',
        ]);

        // Credenciales a verificar
        $credenciales = [
            'correo' => $request->correo,
            'password' => $request->contrasena,
        ];

        // Intentar autenticación
        if (Auth::attempt($credenciales, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user()->load('rol');

            // 🔒 Verificar si el usuario está activo
            if (!$user->activo) {
                Auth::logout();
                return back()
                    ->withErrors(['correo' => 'Usuario inactivo.'])
                    ->onlyInput('correo');
            }

            // Debug: verificar que el rol se carga correctamente
            Log::info('Login exitoso', [
                'user_id' => $user->id,
                'rol' => $user->rol?->nombre,
                'activo' => $user->activo
            ]);

            return $this->redirectToDashboard();
        }

        // Si las credenciales no son válidas
        return back()
            ->withErrors(['correo' => 'Credenciales inválidas'])
            ->onlyInput('correo');
    }

    /**
     * Redirige al dashboard según el rol del usuario
     */
    protected function redirectToDashboard()
    {
        $user = Auth::user();
        $rol = strtolower($user->rol?->nombre ?? '');

        Log::info('Redirigiendo usuario', [
            'user_id' => $user->id,
            'rol' => $rol
        ]);

        return match ($rol) {
            'docente' => redirect()->route('docente.dashboard'),
            'administrador' => redirect()->route('admin.dashboard'),
            'coordinador' => redirect()->route('coordinador.dashboard'),
            default => $this->handleNoRole(),
        };
    }

    /**
     * Maneja usuarios sin rol asignado
     */
    protected function handleNoRole()
    {
        Auth::logout();
        return redirect()->route('login')
            ->withErrors(['correo' => 'No tienes un rol asignado. Contacta al administrador.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}