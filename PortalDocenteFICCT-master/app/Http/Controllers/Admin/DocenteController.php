<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Docente;
use App\Models\Persona;
use Illuminate\Http\Request;

class DocenteController extends Controller
{
    public function index()
    {
        $docentes = Docente::with('persona')->latest()->paginate(15);
        return view('admin.docentes.index', compact('docentes'));
    }

    public function create()
    {
        // Personas que aún no son docentes
        $personas = Persona::doesntHave('docente')->orderBy('nombre')->get();
        return view('admin.docentes.create', compact('personas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'persona_id'        => ['required','exists:personas,id','unique:docentes,persona_id'],
            'anios_experiencia' => ['nullable','integer','min:0','max:80'],
            'fecha_ingreso'     => ['nullable','date'],
            'activo'            => ['boolean'],
        ]);

        Docente::create($data);

        return redirect()->route('docentes.index')->with('status','Docente creado.');
    }

    // Route model binding por persona (si definiste parameters([...=>'persona']))
    public function show(Persona $persona)
    {
        $docente = Docente::with('persona')->where('persona_id', $persona->id)->firstOrFail();
        return view('admin.docentes.show', compact('docente'));
    }

    public function edit(Persona $persona)
    {
        $docente = Docente::where('persona_id', $persona->id)->firstOrFail();
        return view('admin.docentes.edit', compact('docente'));
    }

    public function update(Request $request, Persona $persona)
    {
        $docente = Docente::where('persona_id', $persona->id)->firstOrFail();

        $data = $request->validate([
            'anios_experiencia' => ['nullable','integer','min:0','max:80'],
            'fecha_ingreso'     => ['nullable','date'],
            'activo'            => ['boolean'],
        ]);

        $docente->update($data);

        return redirect()->route('docentes.index')->with('status','Docente actualizado.');
    }

    public function destroy(Persona $persona)
    {
        $docente = Docente::where('persona_id', $persona->id)->firstOrFail();
        $docente->delete();

        return redirect()->route('docentes.index')->with('status','Docente eliminado.');
    }
}
