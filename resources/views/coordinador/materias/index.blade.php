@extends('layouts.coordinador')

@section('content')
<div class="bg-white rounded-2xl border p-6">
  {{-- Header superior: título + acciones principales --}}
  <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
    <div>
      <h1 class="text-xl font-semibold text-slate-900">Materias</h1>
      <p class="text-sm text-slate-600 mt-1">
        Administración de materias, asignación de grupos y disponibilidad académica.
      </p>

      {{-- Mensajes flash --}}
      @if(session('success'))
        <div class="mt-3 rounded-lg bg-emerald-50 text-emerald-800 px-4 py-2 text-sm">
          {{ session('success') }}
        </div>
      @endif
      @if(session('error'))
        <div class="mt-3 rounded-lg bg-rose-50 text-rose-800 px-4 py-2 text-sm">
          {{ session('error') }}
        </div>
      @endif
      @if($errors->any())
        <div class="mt-3 rounded-lg bg-rose-50 text-rose-800 px-4 py-2 text-sm">
          <ul class="list-disc pl-5">
            @foreach($errors->all() as $e)
              <li>{{ $e }}</li>
            @endforeach
          </ul>
        </div>
      @endif
    </div>

    <div class="flex flex-col sm:flex-row gap-2">
      <a href="{{ route('coordinador.materias.create') }}"
         class="rounded-xl bg-emerald-600 text-white px-4 py-2 text-sm hover:bg-emerald-700 text-center">
        Registrar materia
      </a>

      <a href="{{ route('coordinador.materias.assignGroup') }}"
         class="rounded-xl bg-slate-100 text-slate-700 ring-1 ring-slate-200 px-4 py-2 text-sm hover:bg-slate-200 text-center">
        Asignar grupo
      </a>
    </div>
  </div>


  {{-- Tabla --}}
  <div class="overflow-x-auto">
    <table class="min-w-full text-sm">
      <thead>
        <tr class="text-left text-slate-500 border-b">
          <th class="py-2 pr-4">Sigla</th>
          <th class="py-2 pr-4">Nombre</th>
          <th class="py-2 pr-4">Nivel</th>
          <th class="py-2 pr-4">Grupos / Estado</th>
          <th class="py-2 pr-4">Disponible</th>
          <th class="py-2 pr-4 text-right">Acciones</th>
        </tr>
      </thead>

      <tbody>
      @forelse($materias as $materia)
        @php
          $activos = $materia->grupos->where('pivot.activo', true)->count();
          $total   = $materia->grupos->count();
          $disponible = $activos > 0;
        @endphp

        <tr class="border-b last:border-b-0 align-top">
          {{-- Sigla --}}
          <td class="py-3 pr-4 font-medium text-slate-900">
            {{ $materia->sigla }}
          </td>

          {{-- Nombre --}}
          <td class="py-3 pr-4 text-slate-800">
            {{ $materia->nombre }}
          </td>

          {{-- Nivel / Semestre --}}
          <td class="py-3 pr-4 text-slate-800">
            Semestre {{ $materia->nivel }}
          </td>

          {{-- Grupos asignados --}}
          <td class="py-3 pr-4 text-slate-800">
            @forelse($materia->grupos as $grupo)
              <div class="flex flex-wrap items-center gap-2 mb-2">

                {{-- pill del grupo con toggle activo/inactivo --}}
                <form method="POST"
                      action="{{ route('coordinador.materias.grupos.toggle', [$materia->sigla, $grupo->id]) }}">
                  @csrf
                  @method('PATCH')
                  <button type="submit"
                          class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-xs ring-1
                                 @if($grupo->pivot->activo)
                                   bg-emerald-50 text-emerald-700 ring-emerald-200 hover:bg-emerald-100
                                 @else
                                   bg-slate-100 text-slate-600 ring-slate-200 hover:bg-slate-200
                                 @endif">
                    <span>●</span>
                    <span>{{ $grupo->nombre }}</span>
                    @unless($grupo->pivot->activo)
                      <span class="text-slate-500">(inactiva)</span>
                    @endunless
                  </button>
                </form>

                {{-- Quitar vínculo materia-grupo --}}
                <form method="POST"
                      action="{{ route('coordinador.materias.grupos.detach', [$materia->sigla, $grupo->id]) }}"
                      onsubmit="return confirm('¿Quitar el grupo {{ $grupo->nombre }} de {{ $materia->sigla }}?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit"
                          class="text-rose-700 hover:underline text-xs font-medium">
                    Quitar
                  </button>
                </form>
              </div>
            @empty
              <span class="text-slate-500 text-xs">Sin grupos asignados</span>
            @endforelse
          </td>

          {{-- Estado global de la materia (Disponible si tiene al menos un grupo activo) --}}
          <td class="py-3 pr-4">
            @if($disponible)
              <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 text-emerald-700 px-2 py-0.5 text-xs ring-1 ring-emerald-200">
                ● Disponible
                <span class="text-slate-500">({{ $activos }}/{{ $total }})</span>
              </span>
            @else
              <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 text-slate-600 px-2 py-0.5 text-xs ring-1 ring-slate-200">
                ● No disponible
              </span>
            @endif
          </td>

          {{-- Acciones --}}
          <td class="py-3 pr-4">
            <div class="flex items-center justify-end gap-3">

              {{-- Editar materia (incluye pestañas para editar info y grupos) --}}
              <a href="{{ route('coordinador.materias.edit', $materia->sigla) }}"
                 class="text-emerald-700 hover:underline text-sm">
                Editar
              </a>

              {{-- Eliminar materia --}}
              <form method="POST"
                    action="{{ route('coordinador.materias.destroy', $materia->sigla) }}"
                    onsubmit="return confirm('¿Eliminar la materia {{ $materia->sigla }}? Esta acción no se puede deshacer.');">
                @csrf
                @method('DELETE')
                <button class="text-rose-700 hover:underline text-sm">
                  Eliminar
                </button>
              </form>

            </div>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="6" class="py-6 text-center text-slate-500">
            No hay materias registradas
          </td>
        </tr>
      @endforelse
      </tbody>
    </table>
  </div>

  {{-- Si algún día quieres paginación, puedes poner esto: --}}
  {{-- <div class="mt-4">{{ $materias->links() }}</div> --}}
</div>
@endsection
