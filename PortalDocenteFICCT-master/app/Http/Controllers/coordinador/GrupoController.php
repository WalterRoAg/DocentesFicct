<?php

namespace App\Http\Controllers\Coordinador;

use App\Http\Controllers\Controller;
use App\Models\Grupo;
use Illuminate\Http\Request;

class GrupoController extends Controller
{
    public function index()
    {
        $grupos = Grupo::orderBy('id')->get();
        return view('coordinador.grupos.index', compact('grupos'));
    }

    public function create()
    {
        return view('coordinador.grupos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:10|unique:grupos,nombre',
        ]);

        $grupo = new Grupo();
        $grupo->nombre = $request->nombre;
        $grupo->save();

        return redirect()->route('coordinador.grupos.index')
            ->with('success', 'Grupo registrado correctamente.');
    }

    public function edit(Grupo $grupo)
    {
        return view('coordinador.grupos.edit', compact('grupo'));
    }

    public function update(Request $request, Grupo $grupo)
    {
        $request->validate([
            'nombre' => 'required|string|max:10|unique:grupos,nombre,' . $grupo->id,
        ]);

        $grupo->nombre = $request->nombre;
        $grupo->save();

        return redirect()->route('coordinador.grupos.index')
            ->with('success', 'Grupo actualizado correctamente.');
    }

    public function destroy(\App\Models\Grupo $grupo)
    {
        $grupo->delete();
        return redirect()
            ->route('coordinador.grupos.index')
            ->with('success', 'Grupo eliminado correctamente.');
    }
}
