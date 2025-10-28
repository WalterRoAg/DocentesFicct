<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Administrativo;
use App\Models\Persona;
use Illuminate\Http\Request;

class AdministrativoController extends Controller
{
    public function index()
    {
        $administrativos = Administrativo::with('persona')->latest()->paginate(15);
        return view('admin.administrativos.index', compact('administrativos'));
    }

    public function create()
    {
        $personas = Persona::doesntHave('administrativo')->orderBy('nombre')->get();
        return view('admin.administrativos.create', compact('personas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'persona_id'    => ['required','exists:personas,id','unique:administrativos,persona_id'],
            'cargo'         => ['nullable','string','max:120'],
            'fecha_ingreso' => ['nullable','date'],
            'activo'        => ['boolean'],
        ]);

        Administrativo::create($data);

        return redirect()->route('administrativos.index')->with('status','Administrativo creado.');
    }

    public function show(Persona $persona)
    {
        $administrativo = Administrativo::with('persona')->where('persona_id', $persona->id)->firstOrFail();
        return view('admin.administrativos.show', compact('administrativo'));
    }

    public function edit(Persona $persona)
    {
        $administrativo = Administrativo::where('persona_id', $persona->id)->firstOrFail();
        return view('admin.administrativos.edit', compact('administrativo'));
    }

    public function update(Request $request, Persona $persona)
    {
        $administrativo = Administrativo::where('persona_id', $persona->id)->firstOrFail();

        $data = $request->validate([
            'cargo'         => ['nullable','string','max:120'],
            'fecha_ingreso' => ['nullable','date'],
            'activo'        => ['boolean'],
        ]);

        $administrativo->update($data);

        return redirect()->route('administrativos.index')->with('status','Administrativo actualizado.');
    }

    public function destroy(Persona $persona)
    {
        $administrativo = Administrativo::where('persona_id', $persona->id)->firstOrFail();
        $administrativo->delete();

        return redirect()->route('administrativos.index')->with('status','Administrativo eliminado.');
    }
}
