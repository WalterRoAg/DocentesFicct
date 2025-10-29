@extends('layouts.coordinador')

@section('content')
<div class="bg-white rounded-2xl border p-6 max-w-xl">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-xl font-semibold text-slate-900">Registrar materia</h1>
        <a href="{{ route('coordinador.materias.index') }}"
           class="text-sm text-slate-600 hover:underline">
            ← Volver
        </a>
    </div>

    @if($errors->any())
      <div class="mb-4 rounded-lg bg-rose-50 text-rose-800 px-4 py-2 text-sm">
          <ul class="list-disc pl-5">
              @foreach($errors->all() as $e)
                  <li>{{ $e }}</li>
              @endforeach
          </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('coordinador.materias.store') }}" class="space-y-4">
        @csrf

        {{-- Sigla --}}
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">
                Sigla <span class="text-rose-600">*</span>
            </label>
            <input type="text" name="sigla"
                   value="{{ old('sigla') }}"
                   class="w-full rounded-xl bg-white ring-1 ring-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-emerald-400"
                   required>
            @error('sigla')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Nombre --}}
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">
                Nombre <span class="text-rose-600">*</span>
            </label>
            <input type="text" name="nombre"
                   value="{{ old('nombre') }}"
                   class="w-full rounded-xl bg-white ring-1 ring-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-emerald-400"
                   required>
            @error('nombre')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Nivel / semestre --}}
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">
                Semestre / Nivel <span class="text-rose-600">*</span>
            </label>
            <input type="number" name="nivel" min="1" max="12"
                   value="{{ old('nivel') }}"
                   class="w-full rounded-xl bg-white ring-1 ring-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-emerald-400"
                   required>
            @error('nivel')
                <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-3 pt-4">
            <button type="submit"
                    class="rounded-xl bg-emerald-600 text-white px-4 py-2 text-sm hover:bg-emerald-700">
                Guardar
            </button>

            <a href="{{ route('coordinador.materias.index') }}"
               class="text-sm text-slate-600 hover:underline">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection

