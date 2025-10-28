<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PersonaController extends Controller
{
    public function index()
    {
        $personas = Persona::latest()->paginate(15);
        return view('admin.personas.index', compact('personas'));
    }

    public function create()
    {
        return view('admin.personas.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'carnet'   => ['required','string','max:50','unique:personas,carnet'],
            'nombre'   => ['required','string','max:150'],
            'telefono' => ['nullable','string','max:30'],
        ]);

        $persona = Persona::create($data);

        return redirect()
            ->route('personas.index')
            ->with('status', 'Persona creada correctamente.');
    }

    public function show(Persona $persona)
    {
        $persona->load(['docente','administrativo','usuarios']);
        return view('admin.personas.show', compact('persona'));
    }

    public function edit(Persona $persona)
    {
        return view('admin.personas.edit', compact('persona'));
    }

    public function update(Request $request, Persona $persona)
    {
        $data = $request->validate([
            'carnet'   => ['required','string','max:50', Rule::unique('personas','carnet')->ignore($persona->id)],
            'nombre'   => ['required','string','max:150'],
            'telefono' => ['nullable','string','max:30'],
        ]);

        $persona->update($data);

        return redirect()
            ->route('personas.index')
            ->with('status', 'Persona actualizada.');
    }

    public function destroy(Persona $persona)
    {
        // Opcional: validar que no tenga usuario/docente/administrativo asociados
        $persona->delete();

        return redirect()
            ->route('personas.index')
            ->with('status', 'Persona eliminada.');
    }
}
