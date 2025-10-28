{{-- resources/views/partials/account.blade.php --}}
<section>
  <h2 class="text-xl font-semibold mb-2">Mi Cuenta</h2>
  <p class="text-slate-600 mb-3">Actualiza tus datos personales.</p>

  {{-- Alertas --}}
  @if(session('ok'))
    <div class="mb-3 rounded-lg bg-emerald-50 text-emerald-800 px-4 py-2">{{ session('ok') }}</div>
  @endif
  @if($errors->any())
    <div class="mb-3 rounded-lg bg-red-50 text-red-800 px-4 py-2">
      <ul class="list-disc pl-5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
  @endif

  <div class="grid md:grid-cols-2 gap-6">
    {{-- 1) Perfil: nombre y correo --}}
    <form method="POST" action="{{ route('account.update.profile') }}" class="space-y-4 bg-white rounded-xl p-4 ring-1 ring-slate-200">
      @csrf @method('PUT')
      <div>
        <label class="text-sm text-slate-700">Nombre</label>
        <input type="text" name="nombre" value="{{ old('nombre', auth()->user()->nombre) }}" required
               class="mt-1 w-full rounded-xl bg-slate-50 ring-1 ring-slate-200 focus:ring-2 focus:ring-emerald-500 px-4 py-3">
      </div>
      <div>
        <label class="text-sm text-slate-700">Correo (usuario)</label>
        <input type="email" name="correo" value="{{ old('correo', auth()->user()->correo) }}" required
               class="mt-1 w-full rounded-xl bg-slate-50 ring-1 ring-slate-200 focus:ring-2 focus:ring-emerald-500 px-4 py-3">
      </div>
      <button class="rounded-xl bg-emerald-600 text-white px-4 py-2 text-sm hover:bg-emerald-700">Guardar cambios</button>
    </form>

    {{-- 2) Contraseña --}}
    <form method="POST" action="{{ route('account.update.password') }}" class="space-y-4 bg-white rounded-xl p-4 ring-1 ring-slate-200">
      @csrf @method('PUT')
      <div>
        <label class="text-sm text-slate-700">Nueva Contraseña</label>
        <input type="password" name="password" required
               class="mt-1 w-full rounded-xl bg-slate-50 ring-1 ring-slate-200 focus:ring-2 focus:ring-emerald-500 px-4 py-3">
      </div>
      <div>
        <label class="text-sm text-slate-700">Confirmar Contraseña</label>
        <input type="password" name="password_confirmation" required
               class="mt-1 w-full rounded-xl bg-slate-50 ring-1 ring-slate-200 focus:ring-2 focus:ring-emerald-500 px-4 py-3">
      </div>
      <button class="rounded-xl bg-emerald-600 text-white px-4 py-2 text-sm hover:bg-emerald-700">Cambiar Contraseña</button>
    </form>

    {{-- 3) Teléfono (Persona) --}}
    <form method="POST" action="{{ route('account.update.phone') }}" class="space-y-4 bg-white rounded-xl p-4 ring-1 ring-slate-200 md:col-span-2">
      @csrf @method('PUT')
      <div class="max-w-md">
        <label class="text-sm text-slate-700">Teléfono</label>
        <input type="text" name="telefono" value="{{ old('telefono', optional(auth()->user()->persona)->telefono) }}"
               class="mt-1 w-full rounded-xl bg-slate-50 ring-1 ring-slate-200 focus:ring-2 focus:ring-emerald-500 px-4 py-3">
      </div>
      <button class="rounded-xl bg-emerald-600 text-white px-4 py-2 text-sm hover:bg-emerald-700">Guardar teléfono</button>
    </form>
  </div>
</section>
