@extends('layouts.admin')

@section('content')
<div class="bg-white p-6 rounded-2xl shadow">
  <div class="flex justify-between items-center mb-4">
    <h1 class="text-xl font-semibold">Gestión de Usuarios</h1>
    <a href="{{ route('admin.usuarios.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Registrar</a>
  </div>

  @if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
      {{ session('success') }}
    </div>
  @endif

  <table class="min-w-full bg-white border border-slate-200 rounded-xl">
    <thead>
      <tr class="bg-slate-50 text-slate-600 text-sm uppercase">
        <th class="px-4 py-2 text-left">ID</th>
        <th class="px-4 py-2 text-left">Nombre</th>
        <th class="px-4 py-2 text-left">Correo</th>
        <th class="px-4 py-2 text-left">Rol</th>
        <th class="px-4 py-2 text-left">Estado</th>
        <th class="px-4 py-2 text-center">Acciones</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($usuarios as $u)
      <tr class="border-t text-sm">
        <td class="px-4 py-2">{{ $u->id }}</td>
        <td class="px-4 py-2">{{ $u->nombre }}</td>
        <td class="px-4 py-2">{{ $u->correo }}</td>
        <td class="px-4 py-2">{{ $u->rol->nombre ?? 'Sin rol' }}</td>
        <td class="px-4 py-2">
          <span class="{{ $u->activo ? 'text-green-600' : 'text-red-600' }}">
            {{ $u->activo ? 'Activo' : 'Desactivo' }}
          </span>
        </td>
        <td class="px-4 py-2 text-center">
          <a href="{{ route('admin.usuarios.edit', $u) }}" class="text-indigo-600 hover:underline">Modificar</a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
