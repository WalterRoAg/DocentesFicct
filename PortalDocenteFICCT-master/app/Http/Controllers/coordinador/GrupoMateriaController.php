<?php

namespace App\Http\Controllers\Coordinador;

use App\Models\GrupoMateria;
use App\Models\Materia;
use App\Models\Grupo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GrupoMateriaController extends Controller
{
    // Asignar un grupo a una materia
    public function store(Request $request, Materia $materia)
    {
        // Validamos los datos para asignar un grupo
        $request->validate([
            'grupo_id' => 'required|exists:grupos,id',
            'activo' => 'nullable|boolean',
        ]);

        // Insertar en la tabla de grupo_materias
        GrupoMateria::create([
            'grupo_id' => $request->grupo_id,
            'materia_sigla' => $materia->sigla,
            'activo' => $request->activo ?? false, // Por defecto inactiva
        ]);

        return redirect()->route('coordinador.materias.index')->with('success', 'Grupo asignado a la materia.');
    }
}
