@extends('layouts.coordinador')


@section('content')
<h1 class="text-xl font-semibold mb-4">Editar grupo #{{ $grupo->id }}</h1>

<form method="POST" action="{{ route('coordinador.grupos.update', $grupo) }}" class="bg-white rounded-2xl border p-6 max-w-lg space-y-4">
  @csrf @method('PUT')
  <div>
    <label class="block text-sm text-slate-700">Nombre / Sigla</label>
    <input name="nombre" value="{{ old('nombre', $grupo->nombre) }}" required
           class="mt-1 w-full rounded-xl bg-slate-50 ring-1 ring-slate-200 focus:ring-2 focus:ring-emerald-500 px-4 py-3">
    @error('nombre')<p class="text-sm text-rose-600 mt-1">{{ $message }}</p>@enderror
  </div>
  <div class="flex gap-3">
    <a href="{{ route('coordinador.grupos.index') }}" class="px-4 py-2 rounded-xl ring-1 ring-slate-300 text-slate-700">Volver</a>
    <button class="px-4 py-2 rounded-xl bg-emerald-600 text-white hover:bg-emerald-700">Actualizar</button>
  </div>
</form>
@endsection
