@extends('layouts.admin')

@section('content')
<div class="bg-white p-6 rounded-2xl shadow">
  <h1 class="text-xl font-semibold mb-4">Registrar Usuario</h1>

  <form action="{{ route('admin.usuarios.store') }}" method="POST" class="space-y-4">
    @csrf

    <div>
      <label class="block text-sm font-medium text-slate-600">Nombre</label>
      <input type="text" name="nombre" value="{{ old('nombre') }}" class="w-full border rounded-lg p-2" required>
    </div>

    <div>
      <label class="block text-sm font-medium text-slate-600">Correo</label>
      <input type="email" name="correo" value="{{ old('correo') }}" class="w-full border rounded-lg p-2" required>
    </div>

    <div>
      <label class="block text-sm font-medium text-slate-600">Contraseña</label>
      <input type="password" name="contrasena" class="w-full border rounded-lg p-2" required>
    </div>

    <div>
      <label class="block text-sm font-medium text-slate-600">Rol</label>
      <select name="rol_id" class="w-full border rounded-lg p-2" required>
        <option value="">-- Selecciona --</option>
        @foreach($roles as $r)
          <option value="{{ $r->id }}">{{ $r->nombre }}</option>
        @endforeach
      </select>
    </div>

    <div>
      <label class="block text-sm font-medium text-slate-600">Persona</label>
      <select name="persona_id" class="w-full border rounded-lg p-2" required>
        <option value="">-- Selecciona --</option>
        @foreach($personas as $p)
          <option value="{{ $p->id }}">{{ $p->nombre }}</option>
        @endforeach
      </select>
    </div>

    <div class="pt-4">
      <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
        Registrar
      </button>
    </div>
  </form>
</div>
@endsection

