@extends('layouts.admin')

@section('content')
  {{-- tarjetas de estadística arriba --}}
  <section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
    <div class="bg-white rounded-2xl border p-5">
      <p class="text-xs text-slate-500">Usuarios</p>
      <p class="mt-2 text-3xl font-semibold">{{ $stats['usuarios'] ?? '—' }}</p>
    </div>
    <div class="bg-white rounded-2xl border p-5">
      <p class="text-xs text-slate-500">Roles</p>
      <p class="mt-2 text-3xl font-semibold">{{ $stats['roles'] ?? '—' }}</p>
    </div>
    <div class="bg-white rounded-2xl border p-5">
      <p class="text-xs text-slate-500">Docentes activos</p>
      <p class="mt-2 text-3xl font-semibold">{{ $stats['docentes'] ?? '—' }}</p>
    </div>
    <div class="bg-white rounded-2xl border p-5">
      <p class="text-xs text-slate-500">Asistencias hoy</p>
      <p class="mt-2 text-3xl font-semibold">{{ $stats['asistencias_hoy'] ?? '—' }}</p>
    </div>
  </section>

  {{-- Alertas globales --}}
  @if(session('ok'))
    <div class="mt-4 rounded-lg bg-emerald-50 text-emerald-800 px-4 py-2">
      {{ session('ok') }}
    </div>
  @endif
  @if($errors->any())
    <div class="mt-4 rounded-lg bg-red-50 text-red-800 px-4 py-2">
      <ul class="list-disc pl-5 text-sm">
        @foreach($errors->all() as $e)
          <li>{{ $e }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  {{-- RESUMEN --}}
  <section x-show="tab === 'resumen'" x-cloak class="mt-6 bg-white rounded-2xl border p-6">
    <h2 class="text-lg font-semibold">Resumen</h2>
    <p class="mt-2 text-sm text-slate-600">Usa el menú de la izquierda para navegar.</p>
  </section>

  {{-- MI CUENTA --}}
  <section x-show="tab === 'cuenta'" x-cloak class="mt-6 bg-white rounded-2xl border p-6">
    <h2 class="text-lg font-semibold mb-2">Mi Cuenta</h2>
    <p class="text-slate-600 mb-4">Actualiza tus datos personales.</p>

    <div class="grid md:grid-cols-2 gap-6">

      {{-- 1) Perfil: nombre y correo --}}
      <form method="POST" action="{{ route('account.update.profile') }}"
            class="space-y-4 bg-white rounded-xl p-4 ring-1 ring-slate-200">
        @csrf
        @method('PUT')

        <div>
          <label class="text-sm text-slate-700">Nombre</label>
          <input type="text" name="nombre"
                 value="{{ old('nombre', auth()->user()->nombre) }}"
                 required
                 class="mt-1 w-full rounded-xl bg-slate-50 ring-1 ring-slate-200 focus:ring-2 focus:ring-indigo-500 px-4 py-3">
        </div>

        <div>
          <label class="text-sm text-slate-700">Correo (usuario)</label>
          <input type="email" name="correo"
                 value="{{ old('correo', auth()->user()->correo) }}"
                 required
                 class="mt-1 w-full rounded-xl bg-slate-50 ring-1 ring-slate-200 focus:ring-2 focus:ring-indigo-500 px-4 py-3">
        </div>

        <button class="rounded-xl bg-indigo-600 text-white px-4 py-2 text-sm hover:bg-indigo-700">
          Guardar cambios
        </button>
      </form>

      {{-- 2) Contraseña --}}
      <form method="POST" action="{{ route('account.update.password') }}"
            class="space-y-4 bg-white rounded-xl p-4 ring-1 ring-slate-200">
        @csrf
        @method('PUT')

        <div>
          <label class="text-sm text-slate-700">Nueva Contraseña</label>
          <input type="password" name="password" required
                 class="mt-1 w-full rounded-xl bg-slate-50 ring-1 ring-slate-200 focus:ring-2 focus:ring-indigo-500 px-4 py-3">
        </div>

        <div>
          <label class="text-sm text-slate-700">Confirmar Contraseña</label>
          <input type="password" name="password_confirmation" required
                 class="mt-1 w-full rounded-xl bg-slate-50 ring-1 ring-slate-200 focus:ring-2 focus:ring-indigo-500 px-4 py-3">
        </div>

        <button class="rounded-xl bg-indigo-600 text-white px-4 py-2 text-sm hover:bg-indigo-700">
          Cambiar Contraseña
        </button>
      </form>

      {{-- 3) Teléfono (Persona) --}}
      <form method="POST" action="{{ route('account.update.phone') }}"
            class="space-y-4 bg-white rounded-xl p-4 ring-1 ring-slate-200 md:col-span-2">
        @csrf
        @method('PUT')

        <div class="max-w-md">
          <label class="text-sm text-slate-700">Teléfono</label>
          <input type="text" name="telefono"
                 value="{{ old('telefono', optional(auth()->user()->persona)->telefono) }}"
                 class="mt-1 w-full rounded-xl bg-slate-50 ring-1 ring-slate-200 focus:ring-2 focus:ring-indigo-500 px-4 py-3">
        </div>

        <button class="rounded-xl bg-indigo-600 text-white px-4 py-2 text-sm hover:bg-indigo-700">
          Guardar teléfono
        </button>
      </form>

    </div>
  </section>

  {{-- ROLES --}}
  <section x-show="tab === 'roles'" x-cloak class="mt-6 bg-white rounded-2xl border p-6">
    <h2 class="text-lg font-semibold mb-2">Roles</h2>
    <p class="text-slate-600 text-sm">Acá más adelante puedes renderizar la gestión de roles del admin.</p>
  </section>

  {{-- PERMISOS --}}
  <section x-show="tab === 'permisos'" x-cloak class="mt-6 bg-white rounded-2xl border p-6">
    <h2 class="text-lg font-semibold mb-2">Permisos</h2>
    <p class="text-slate-600 text-sm">Acá más adelante puedes renderizar la gestión de permisos del admin.</p>
  </section>

@endsection
