@extends('layouts.coordinador')

@section('content')
<div class="bg-white rounded-2xl border p-6">
  <div class="flex items-center justify-between mb-4">
    <h1 class="text-xl font-semibold">Aulas</h1>
    <a href="{{ route('coordinador.aulas.create') }}" class="rounded-xl bg-emerald-600 text-white px-4 py-2 text-sm hover:bg-emerald-700">
      Registrar aula
    </a>
  </div>

  {{-- Filtros de estado --}}
  <form method="GET" class="mb-4 flex items-center gap-2">
    <label class="text-sm text-slate-600">Estado:</label>
    <select name="estado" class="rounded-xl bg-white ring-1 ring-slate-200 px-3 py-2 text-sm">
      <option value="todos"     @selected(($estado ?? '')==='todos')>Todos</option>
      <option value="activos"   @selected(($estado ?? '')==='activos')>Activos</option>
      <option value="inactivos" @selected(($estado ?? '')==='inactivos')>Inactivos</option>
    </select>
    <button class="rounded-xl bg-slate-800 text-white px-3 py-2 text-sm">Aplicar</button>
    @if(($estado ?? 'todos')!=='todos')
      <a href="{{ route('coordinador.aulas.index') }}" class="text-sm text-slate-700 hover:underline">Limpiar</a>
    @endif
  </form>

  @if(session('ok'))
    <div class="mb-4 rounded-lg bg-emerald-50 text-emerald-800 px-4 py-2">{{ session('ok') }}</div>
  @endif
  @if($errors->any())
    <div class="mb-4 rounded-lg bg-red-50 text-red-800 px-4 py-2">
      <ul class="list-disc pl-5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
  @endif

  <div class="overflow-x-auto">
    <table class="min-w-full text-sm">
      <thead>
        <tr class="text-left text-slate-500 border-b">
          <th class="py-2 pr-4">Piso</th>
          <th class="py-2 pr-4">Número</th>
          <th class="py-2 pr-4">Capacidad</th>
          <th class="py-2 pr-4">Estado</th>
          <th class="py-2 pr-4 text-right">Acciones</th>
        </tr>
      </thead>
      <tbody>
      @forelse($aulas as $aula)
        <tr class="border-b last:border-b-0">
          <td class="py-2 pr-4">{{ $aula->piso }}</td>
          <td class="py-2 pr-4">{{ $aula->numero }}</td>
          <td class="py-2 pr-4">{{ $aula->capacidad }}</td>
          <td class="py-2 pr-4">
            @if($aula->activo)
              <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 text-emerald-700 px-2 py-0.5 text-xs ring-1 ring-emerald-200">
                ● Activa
              </span>
            @else
              <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 text-slate-600 px-2 py-0.5 text-xs ring-1 ring-slate-200">
                ● Inactiva
              </span>
            @endif
          </td>
          <td class="py-2 pr-4">
            <div class="flex items-center justify-end gap-3">
              <a href="{{ route('coordinador.aulas.edit', $aula) }}" class="text-emerald-700 hover:underline">Editar</a>

              @if($aula->activo)
                <form method="POST" action="{{ route('coordinador.aulas.desactivar', $aula) }}"
                      onsubmit="return confirm('¿Desactivar el aula {{ $aula->numero }}?');">
                  @csrf @method('PUT')
                  <button class="text-rose-700 hover:underline">Desactivar</button>
                </form>
              @else
                <form method="POST" action="{{ route('coordinador.aulas.activar', $aula) }}">
                  @csrf @method('PUT')
                  <button class="text-emerald-700 hover:underline">Activar</button>
                </form>
              @endif
            </div>
          </td>
        </tr>
      @empty
        <tr><td colspan="5" class="py-6 text-center text-slate-500">No hay aulas</td></tr>
      @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-4">{{ $aulas->links() }}</div>
</div>
@endsection
