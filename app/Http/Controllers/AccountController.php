<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Models\Persona;

class AccountController extends Controller
{
   // app/Http/Controllers/AccountController.php

private function redirectToDashboard()
{
    $rol = strtolower(trim(auth()->user()->rol->nombre ?? ''));

    return match ($rol) {
        'administrador' => redirect()->route('admin.dashboard'),
        'coordinador'   => redirect()->route('coordinador.dashboard'),
        'docente'       => redirect()->route('docente.dashboard'),
        default         => redirect('/'),
    };
}

public function updatePassword(Request $request)
{
    $request->validate([
        'password' => ['required','string','min:6','confirmed'],
    ]);

    $u = $request->user();
    $u->contrasena = \Illuminate\Support\Facades\Hash::make($request->password);
    $u->save();

    return $this->redirectToDashboard()->with('ok', 'Contraseña actualizada');
}

public function updateProfile(Request $request)
{
    $u = $request->user();
    $data = $request->validate([
        'nombre' => ['required','string','min:3','max:100'],
        'correo' => ['required','email','max:150', \Illuminate\Validation\Rule::unique('usuarios','correo')->ignore($u->id)],
    ]);
    $u->fill($data)->save();

    return $this->redirectToDashboard()->with('ok', 'Datos actualizados');
}

public function updatePhone(Request $request)
{
    $request->validate([
        'telefono' => ['required','string','min:6','max:30'],
    ]);

    $u = $request->user();
    if (!$u->persona_id) {
        $persona = \App\Models\Persona::create([
            'carnet'   => 'S/N',
            'nombre'   => $u->nombre,
            'telefono' => $request->telefono,
        ]);
        $u->persona_id = $persona->id;
        $u->save();
    } else {
        $u->persona()->updateOrCreate(['id' => $u->persona_id], ['telefono' => $request->telefono]);
    }

    return $this->redirectToDashboard()->with('ok', 'Teléfono actualizado');
}

}
