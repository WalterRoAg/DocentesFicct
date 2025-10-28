<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => ['required','string','min:6'],
        ]);

        $user = $request->user(); // auth()->user()
        $user->contrasena = Hash::make($request->password);
        $user->save();

        return back()->with('ok', 'Contraseña actualizada correctamente.');
    }
}
