@extends('layouts.coordinador')

@section('title', 'Registrar grupo')

@section('content')
<div class="bg-white rounded-2xl border border-slate-200 p-6">
  <div class="flex items-center justify-between mb-4">
    <h1 class="text-xl font-semibold">Registrar grupo</h1>
    <a href="{{ route('coordinador.grupos.index') }}"
       class="text-sm text-slate-600 hover:underline">
      Volver a la lista
    </a>
  </div>

  @if ($errors->any())
    <div class="mb-4 rounded-lg bg-red-50 text-red-800 px-4 py-3">
      <ul class="list-disc pl-5">
        @foreach ($errors->all() as $e)
          <li>{{ $e }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('coordinador.grupos.store') }}" class="space-y-4 max-w-md">
    @csrf

    <div>
      <label class="text-sm text-slate-700">Nombre / Sigla del grupo</label>
      <input type="text" name="nombre" value="{{ old('nombre') }}" required
             class="mt-1 w-full rounded-xl bg-slate-50 ring-1 ring-slate-200 focus:ring-2 focus:ring-emerald-500 px-4 py-3">
      <p class="text-xs text-slate-500 mt-1">Ej.: SA, SB, G1, etc.</p>
    </div>

    <div class="flex items-center gap-3">
      <button class="rounded-xl bg-emerald-600 text-white px-4 py-2 text-sm hover:bg-emerald-700">
        Guardar
      </button>
      <a href="{{ route('coordinador.grupos.index') }}"
         class="text-sm text-slate-700 hover:underline">Cancelar</a>
    </div>
  </form>
</div>
@endsection
