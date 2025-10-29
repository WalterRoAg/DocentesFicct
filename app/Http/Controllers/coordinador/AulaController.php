<?php

namespace App\Http\Controllers\Coordinador;

use App\Http\Controllers\Controller;
use App\Models\Aula;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AulaController extends Controller
{
    /** Check rápido de permiso en cada acción */
    private function authorizeAulas()
    {
        abort_unless(auth()->user()?->canPermiso('gestionar-aulas'), 403, 'No tienes permiso para gestionar aulas');
    }

   public function index(\Illuminate\Http\Request $request)
{
    $this->authorizeAulas();

    // filtro opcional: ?estado=activos|inactivos|todos
    $estado = $request->string('estado', 'todos')->toString();

    $aulas = \App\Models\Aula::query()
        ->when($estado === 'activos',   fn($q) => $q->where('activo', true))
        ->when($estado === 'inactivos', fn($q) => $q->where('activo', false))
        ->orderBy('piso')->orderBy('numero')
        ->paginate(10)
        ->withQueryString();

    return view('coordinador.aulas.index', compact('aulas', 'estado'));
}

public function desactivar(\App\Models\Aula $aula)
{
    $this->authorizeAulas();
    $aula->update(['activo' => false]);
    return back()->with('ok', 'Aula desactivada');
}

public function activar(\App\Models\Aula $aula)
{
    $this->authorizeAulas();
    $aula->update(['activo' => true]);
    return back()->with('ok', 'Aula activada');
}



    public function create()
    {
        $this->authorizeAulas();
        return view('coordinador.aulas.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAulas();

        $data = $request->validate([
            'piso'      => ['required', 'integer', 'min:0', 'max:100'],
            'numero'    => ['required', 'string', 'max:50', 'unique:aulas,numero'],
            'capacidad' => ['required', 'integer', 'min:1', 'max:500'],
        ]);

        $data['activo'] = true; // <- importante

        Aula::create($data);

        return redirect()->route('coordinador.aulas.index')->with('ok', 'Aula registrada');
    }


    public function edit(Aula $aula)
    {
        $this->authorizeAulas();
        return view('coordinador.aulas.edit', compact('aula'));
    }

    public function update(Request $request, Aula $aula)
    {
        $this->authorizeAulas();

        $data = $request->validate([
            'piso'      => ['required', 'integer', 'min:0', 'max:100'],
            'numero'    => ['required', 'string', 'max:50', Rule::unique('aulas', 'numero')->ignore($aula->id)],
            'capacidad' => ['required', 'integer', 'min:1', 'max:500'],
        ]);

        $aula->update($data);

        return redirect()->route('coordinador.aulas.index')->with('ok', 'Aula actualizada');
    }
    public function destroy(Aula $aula)
    {
        $this->authorizeAulas();

        // baja lógica
        $aula->update(['activo' => false]);

        return redirect()->route('coordinador.aulas.index')->with('ok', 'Aula desactivada');
    }
}
