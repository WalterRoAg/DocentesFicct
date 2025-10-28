<?php

namespace App\Http\Controllers\Coordinador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Materia;
use App\Models\Grupo;
use App\Models\GrupoMateria;
use Illuminate\Support\Facades\DB;

class MateriaController extends Controller
{
    public function index()
    {
        // Trae grupos + campo pivot 'activo'
        $materias = Materia::with(['grupos' => function ($q) {
            $q->withPivot('activo');
        }])->get();

        return view('coordinador.materias.index', compact('materias'));
    }

    // ✅ Mostrar formulario de creación
    public function create()
    {
        return view('coordinador.materias.create');
    }

    // ✅ Guardar una nueva materia
    public function store(Request $request)
    {
        $request->validate([
            'sigla' => 'required|string|max:10|unique:materias,sigla',
            'nombre' => 'required|string|max:100',
            'nivel' => 'required|integer|min:1|max:12',
        ]);

        Materia::create($request->only(['sigla', 'nombre', 'nivel']));
        return redirect()->route('coordinador.materias.index')->with('success', 'Materia registrada correctamente.');
    }

    // ✅ Editar materia existente
    public function edit(Materia $materia)
    {
        $grupos = Grupo::all();
        $materia->load('grupos');
        return view('coordinador.materias.edit', compact('materia', 'grupos'));
    }

    // ✅ Actualizar datos de materia
    public function update(Request $request, Materia $materia)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'nivel' => 'required|integer|min:1|max:12',
        ]);

        $materia->update($request->only(['nombre', 'nivel']));
        return redirect()->route('coordinador.materias.index')->with('success', 'Materia actualizada correctamente.');
    }

    public function toggleGroup(Materia $materia, Grupo $grupo)
    {
        // Verifica que exista la relación
        $rel = $materia->grupos()->where('grupos.id', $grupo->id)->first();
        if (!$rel) {
            return back()->with('error', 'La materia no está asignada a ese grupo.');
        }

        $current = (bool) $rel->pivot->activo;
        $materia->grupos()->updateExistingPivot($grupo->id, ['activo' => !$current]);

        return back()->with(
            'success',
            ($current ? 'Se desactivó' : 'Se activó') .
                " la materia {$materia->sigla} en el grupo {$grupo->nombre}."
        );
    }

    // ✅ Eliminar materia (solo si no tiene horarios)
    public function destroy(Materia $materia)
    {
        /*if ($materia->horarioClases()->exists()) {
            return back()->with('error', 'No se puede eliminar una materia con horarios asignados.');
        }*/

        $materia->delete();
        return redirect()->route('coordinador.materias.index')->with('success', 'Materia eliminada correctamente.');
    }

    // ✅ Mostrar formulario para asignar grupos
    public function assignGroup()
    {
        $materias = Materia::all();
        $grupos = Grupo::all();
        return view('coordinador.materias.assign', compact('materias', 'grupos'));
    }

    // ✅ Guardar la asignación grupo ↔ materia
    public function storeGroupAssignment(Request $request)
    {
        $request->validate([
            'materia_sigla' => 'required|exists:materias,sigla',
            'grupo_id' => 'required|exists:grupos,id',
        ]);

        GrupoMateria::updateOrCreate(
            ['materia_sigla' => $request->materia_sigla, 'grupo_id' => $request->grupo_id],
            ['activo' => true]
        );

        return redirect()->route('coordinador.materias.index')->with('success', 'Grupo asignado correctamente.');
    }
    public function detachGroup(Materia $materia, Grupo $grupo)
    {
        $materia->grupos()->detach($grupo->id);

        return back()->with('success', "Se desasignó el grupo {$grupo->nombre} de la materia {$materia->sigla}.");
    }
}
