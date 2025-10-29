@extends('layouts.coordinador')

@section('content')
<div class="bg-white rounded-2xl border p-6 max-w-xl">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h1 class="text-xl font-semibold text-slate-900">Asignar grupo a materia</h1>
            <p class="text-sm text-slate-600 mt-1">
                Relaciona una materia con un grupo. Por defecto se marcará como activa.
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
          action="{{ route('coordinador.materias.storeGroupAssignment') }}"
          class="space-y-4">
        @csrf

        {{-- Materia --}}
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">
                Materia <span class="text-rose-600">*</span>
            </label>
            <select name="materia_sigla"
                    class="w-full rounded-xl bg-white ring-1 ring-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-emerald-400"
                    required>
                @foreach($materias as $m)
                    <option value="{{ $m->sigla }}">
                        {{ $m->sigla }} — {{ $m->nombre }} (Sem {{ $m->nivel }})
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Grupo --}}
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">
                Grupo <span class="text-rose-600">*</span>
            </label>
            <select name="grupo_id"
                    class="w-full rounded-xl bg-white ring-1 ring-slate-200 px-3 py-2 text-sm focus:outline-none focus:ring-emerald-400"
                    required>
                @foreach($grupos as $g)
                    <option value="{{ $g->id }}">
                        {{ $g->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex items-center gap-3 pt-4">
            <button type="submit"
                    class="rounded-xl bg-emerald-600 text-white px-4 py-2 text-sm hover:bg-emerald-700">
                Asignar
            </button>

            <a href="{{ route('coordinador.materias.index') }}"
               class="text-sm text-slate-600 hover:underline">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
