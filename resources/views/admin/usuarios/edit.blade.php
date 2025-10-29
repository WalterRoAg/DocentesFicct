@extends('layouts.admin')

@section('content')
<div class="bg-white p-6 rounded-2xl shadow">
  <h1 class="text-xl font-semibold mb-4">Modificar Usuario</h1>

  <form action="{{ route('admin.usuarios.update', $usuario) }}" method="POST" class="space-y-4">
    @csrf
    @method('PUT')

    <div>
      <label class="block text-sm font-medium text-slate-600">Nombre</label>
      <input type="text" name="nombre" value="{{ old('nombre', $usuario->nombre) }}" class="w-full border rounded-lg p-2" required>
    </div>

    <div>
      <label class="block text-sm font-medium text-slate-600">Correo</label>
      <input type="email" name="correo" value="{{ old('correo', $usuario->correo) }}" class="w-full border rounded-lg p-2" required>
    </div>

    <div>
      <label class="block text-sm font-medium text-slate-600">Rol</label>
      <select name="rol_id" class="w-full border rounded-lg p-2" required>
        @foreach($roles as $r)
          <option value="{{ $r->id }}" {{ $usuario->rol_id == $r->id ? 'selected' : '' }}>
            {{ $r->nombre }}
          </option>
        @endforeach
      </select>
    </div>

    <div>
      <label class="block text-sm font-medium text-slate-600">Persona</label>
      <select name="persona_id" class="w-full border rounded-lg p-2" required>
        @foreach($personas as $p)
          <option value="{{ $p->id }}" {{ $usuario->persona_id == $p->id ? 'selected' : '' }}>
            {{ $p->nombre }}
          </option>
        @endforeach
      </select>
    </div>

    <div>
      <label class="block text-sm font-medium text-slate-600">Estado</label>
      <select name="activo" class="w-full border rounded-lg p-2">
        <option value="1" {{ $usuario->activo ? 'selected' : '' }}>Activo</option>
        <option value="0" {{ !$usuario->activo ? 'selected' : '' }}>Desactivo</option>
      </select>
    </div>

    <div class="pt-4">
      <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
        Actualizar
      </button>
    </div>
  </form>
</div>
@endsection
