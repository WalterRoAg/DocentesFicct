@extends('layouts.coordinador')

@section('content')
<div class="bg-white rounded-2xl border p-6 max-w-xl">
  <h1 class="text-xl font-semibold mb-4">Registrar aula</h1>

  @if($errors->any())
    <div class="mb-4 rounded-lg bg-red-50 text-red-800 px-4 py-2">
      <ul class="list-disc pl-5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
  @endif

  <form method="POST" action="{{ route('coordinador.aulas.store') }}" class="space-y-4">
    @csrf
    <div>
      <label class="text-sm text-slate-700">Piso</label>
      <input type="number" name="piso" value="{{ old('piso') }}" min="0" max="100" required
             class="mt-1 w-full rounded-xl bg-slate-50 ring-1 ring-slate-200 focus:ring-2 focus:ring-emerald-500 px-4 py-3">
    </div>
    <div>
      <label class="text-sm text-slate-700">Número</label>
      <input type="text" name="numero" value="{{ old('numero') }}" maxlength="50" required
             class="mt-1 w-full rounded-xl bg-slate-50 ring-1 ring-slate-200 focus:ring-2 focus:ring-emerald-500 px-4 py-3">
    </div>
    <div>
      <label class="text-sm text-slate-700">Capacidad</label>
      <input type="number" name="capacidad" value="{{ old('capacidad', 30) }}" min="1" max="500" required
             class="mt-1 w-full rounded-xl bg-slate-50 ring-1 ring-slate-200 focus:ring-2 focus:ring-emerald-500 px-4 py-3">
    </div>
    <div class="flex gap-2">
      <button class="rounded-xl bg-emerald-600 text-white px-4 py-2 text-sm hover:bg-emerald-700">Guardar</button>
      <a href="{{ route('coordinador.aulas.index') }}" class="text-sm text-slate-700 hover:underline">Cancelar</a>
    </div>
  </form>
</div>
@endsection
