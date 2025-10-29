<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Models\Persona;


class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::with('rol')->get();
        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function edit(Usuario $usuario)
    {
        $roles = Rol::all();
        $personas = Persona::all();
        return view('admin.usuarios.edit', compact('usuario', 'roles', 'personas'));
    }


    public function create()
    {
        $roles = Rol::all();
        $personas = Persona::all();
        return view('admin.usuarios.create', compact('roles', 'personas'));
    }

    public function update(Request $request, Usuario $usuario)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'correo' => 'required|email|unique:usuarios,correo,' . $usuario->id,
            'rol_id' => 'required|exists:rols,id',
            'persona_id' => 'required|exists:personas,id',
        ]);

        $usuario->update([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'rol_id' => $request->rol_id,
            'persona_id' => $request->persona_id,
            'activo' => $request->activo ?? true,
        ]);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    // Cambiar sólo el nombre de usuario (alias/username)
    public function updateUsername(Request $request, Usuario $usuario)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:120'],
        ]);

        $usuario->update(['nombre' => $data['nombre']]);

        return back()->with('status', 'Nombre de usuario actualizado.');
    }

    // Cambiar sólo la contraseña
    public function updatePassword(Request $request, Usuario $usuario)
    {
        $data = $request->validate([
            'password_actual' => ['required'],
            'password'        => ['required', 'min:6', 'confirmed'], // requiere password_confirmation
        ]);

        // Opcional: si el admin puede forzar sin validar password actual, quita este if
        if (!Hash::check($data['password_actual'], $usuario->contrasena)) {
            return back()->withErrors(['password_actual' => 'La contraseña actual no es correcta.']);
        }

        $usuario->update([
            'contrasena' => Hash::make($data['password']),
        ]);

        return back()->with('status', 'Contraseña actualizada.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'correo' => 'required|email|unique:usuarios,correo',
            'contrasena' => 'required|string|min:4',
            'rol_id' => 'required|exists:rols,id',
            'persona_id' => 'required|exists:personas,id',
        ]);

        Usuario::create([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'contrasena' => Hash::make($request->contrasena),
            'rol_id' => $request->rol_id,
            'persona_id' => $request->persona_id,
            'activo' => true,
        ]);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario registrado correctamente.');
    }

    public function destroy(Usuario $usuario)
    {
        $usuario->update(['activo' => false]);
        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario desactivado correctamente.');
    }
}
