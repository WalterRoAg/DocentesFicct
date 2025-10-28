@extends('layouts.coordinador')

@section('content')
<div class="bg-white rounded-2xl border p-6">

  {{-- Header superior --}}
  <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
    <div>
      <h1 class="text-xl font-semibold text-slate-900">Grupos</h1>
      <p class="text-sm text-slate-600 mt-1">
        Gestión de grupos académicos registrados en la facultad.
      </p>

      @if(session('success'))
        <div class="mt-3 rounded-lg bg-emerald-50 text-emerald-800 px-4 py-2 text-sm">
          {{ session('success') }}
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

    {{-- Botón principal --}}
    <a href="{{ route('coordinador.grupos.create') }}"
       class="rounded-xl bg-emerald-600 text-white px-4 py-2 text-sm hover:bg-emerald-700 transition">
      ➕ Registrar grupo
    </a>
  </div>

  {{-- Tabla de grupos --}}
  <div class="overflow-x-auto">
    <table class="min-w-full text-sm">
      <thead>
        <tr class="text-left text-slate-500 border-b">
          <th class="py-2 pr-4">ID</th>
          <th class="py-2 pr-4">Nombre</th>
          <th class="py-2 pr-4 text-right">Acciones</th>
        </tr>
      </thead>

      <tbody>
        @forelse($grupos as $grupo)
          <tr class="border-b last:border-b-0 hover:bg-slate-50">
            {{-- ID --}}
            <td class="py-3 pr-4 font-medium text-slate-700">
              {{ $grupo->id }}
            </td>

            {{-- Nombre del grupo --}}
            <td class="py-3 pr-4 text-slate-900 font-medium">
              {{ $grupo->nombre }}
            </td>

            {{-- Acciones --}}
            <td class="py-3 pr-4">
              <div class="flex items-center justify-end gap-3">
                {{-- Editar --}}
                <a href="{{ route('coordinador.grupos.edit', $grupo) }}"
                   class="text-emerald-700 hover:underline text-sm">
                  Editar
                </a>

                {{-- Eliminar --}}
                <form action="{{ route('coordinador.grupos.destroy', $grupo) }}"
                      method="POST"
                      onsubmit="return confirm('¿Eliminar el grupo {{ $grupo->nombre }}?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit"
                          class="text-rose-700 hover:underline text-sm">
                    Eliminar
                  </button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="3" class="py-6 text-center text-slate-500">
              No hay grupos registrados
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Si agregas paginación más adelante --}}
  {{-- <div class="mt-4">{{ $grupos->links() }}</div> --}}

</div>
@endsection
