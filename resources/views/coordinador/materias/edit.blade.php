@extends('layouts.coordinador')

@section('content')
<div class="space-y-8">

    {{-- Bloque: Editar datos básicos de la materia --}}
    <div class="bg-white rounded-2xl border p-6 max-w-xl">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h1 class="text-xl font-semibold text-slate-900">
                    Editar materia: {{ $materia->sigla }}
                </h1>
                <p class="text-sm text-slate-600 mt-1">
                    Actualiza el nombre o el semestre.
                </p>
            </div>

            <a href="{{ route('coordinador.materias.index') }}"
               class="text-sm text-slate-600 hover:underline">
                ← Volver
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 rounded-lg bg-emerald-50 text-emerald-800 px-4 py-2 text-sm">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 rounded-lg bg-rose-50 text-rose-800 px-4 py-2 text-sm">
                {{ session('error') }}
            </div>
        @endif
        @if($errors->any())
            <div class="mb-4 rounded-lg bg-rose-50 text-rose-800 px-4 py-2 text-sm">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST"
              action="{{ route('coordinador.materias.update', $materia->sigla) }}"
              class="space-y-4">
            @csrf
            @method('PUT')

            {{-- Sigla (solo lectura, PK lógica) --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Sigla
                </label>
                <input type="text"
                       value="{{ $materia->sigla }}"
                       disabled
                       class="w-full bg-slate-50 text-slate-500 rounded-xl ring-1 ring-slate-200 px-3 py-2 text-sm cursor-not-allowed">
            </div>

            {{-- Nombre --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Nombre <span class="text-rose-600">*</span>
                </label>
                <input type="text" name="nombre"
                       value="{{ old('nombre', $materia->nombre) }}"
                       class="w-full rounded-xl bg-white ring-1 ring-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-emerald-400"
                       required>
            </div>

            {{-- Nivel --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Semestre / Nivel <span class="text-rose-600">*</span>
                </label>
                <input type="number" name="nivel" min="1" max="12"
                       value="{{ old('nivel', $materia->nivel) }}"
                       class="w-full rounded-xl bg-white ring-1 ring-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-emerald-400"
                       required>
            </div>

            <div class="flex items-center gap-3 pt-4">
                <button type="submit"
                        class="rounded-xl bg-emerald-600 text-white px-4 py-2 text-sm hover:bg-emerald-700">
                    Guardar cambios
                </button>

                <a href="{{ route('coordinador.materias.index') }}"
                   class="text-sm text-slate-600 hover:underline">
                    Cancelar
                </a>
            </div>
        </form>
    </div>

    {{-- Bloque: Gestión de grupos asignados --}}
    <div class="bg-white rounded-2xl border p-6">
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-slate-900">
                Grupos asignados a {{ $materia->sigla }}
            </h2>
            <p class="text-sm text-slate-600 mt-1">
                Activa o desactiva la materia dentro de cada grupo, o quítala del grupo.
            </p>
        </div>

        {{-- Lista de grupos actuales --}}
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="text-left text-slate-500 border-b">
                        <th class="py-2 pr-4">Grupo</th>
                        <th class="py-2 pr-4">Estado en el grupo</th>
                        <th class="py-2 pr-4 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($materia->grupos as $grupo)
                        <tr class="border-b last:border-b-0">
                            {{-- Nombre del grupo --}}
                            <td class="py-3 pr-4 text-slate-800 font-medium">
                                {{ $grupo->nombre }}
                            </td>

                            {{-- Estado activo/inactivo dentro de ese grupo --}}
                            <td class="py-3 pr-4">
                                @if($grupo->pivot->activo)
                                  <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 text-emerald-700 px-2 py-0.5 text-xs ring-1 ring-emerald-200">
                                    ● Activa
                                  </span>
                                @else
                                  <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 text-slate-600 px-2 py-0.5 text-xs ring-1 ring-slate-200">
                                    ● Inactiva
                                  </span>
                                @endif
                            </td>

                            <td class="py-3 pr-4">
                                <div class="flex items-center justify-end gap-3">

                                    {{-- Toggle activa/inactiva --}}
                                    <form method="POST"
                                          action="{{ route('coordinador.materias.grupos.toggle', [$materia->sigla, $grupo->id]) }}">
                                        @csrf
                                        @method('PATCH')
                                        @if($grupo->pivot->activo)
                                            <button class="text-rose-700 hover:underline text-sm"
                                                    onclick="return confirm('¿Desactivar {{ $materia->sigla }} en el grupo {{ $grupo->nombre }}?');">
                                                Desactivar
                                            </button>
                                        @else
                                            <button class="text-emerald-700 hover:underline text-sm">
                                                Activar
                                            </button>
                                        @endif
                                    </form>

                                    {{-- Quitar vínculo --}}
                                    <form method="POST"
                                          action="{{ route('coordinador.materias.grupos.detach', [$materia->sigla, $grupo->id]) }}"
                                          onsubmit="return confirm('¿Quitar el grupo {{ $grupo->nombre }} de {{ $materia->sigla }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-rose-700 hover:underline text-sm">
                                            Quitar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-6 text-center text-slate-500">
                                Esta materia no tiene grupos asignados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Asignar nuevo grupo a esta materia --}}
        <div class="mt-8 max-w-md">
            <h3 class="text-sm font-semibold text-slate-900 mb-2">
                Asignar esta materia a un nuevo grupo
            </h3>
            <p class="text-sm text-slate-600 mb-4">
                Solo se muestran los grupos donde esta materia todavía no está asignada.
            </p>

            <form method="POST"
                  action="{{ route('coordinador.materias.storeGroupAssignment') }}"
                  class="flex flex-col sm:flex-row sm:items-end gap-3">
                @csrf
                <input type="hidden" name="materia_sigla" value="{{ $materia->sigla }}">

                <div class="flex-1">
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        Grupo
                    </label>
                    <select name="grupo_id"
                            class="w-full rounded-xl bg-white ring-1 ring-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-emerald-400"
                            required>
                        @forelse($grupos as $grupo)
                            <option value="{{ $grupo->id }}">{{ $grupo->nombre }}</option>
                        @empty
                            <option value="">(No hay grupos disponibles)</option>
                        @endforelse
                    </select>
                </div>

                <button type="submit"
                        class="rounded-xl bg-slate-800 text-white px-4 py-2 text-sm hover:bg-slate-900">
                    Asignar grupo
                </button>
            </form>
        </div>
    </div>

</div>
@endsection
