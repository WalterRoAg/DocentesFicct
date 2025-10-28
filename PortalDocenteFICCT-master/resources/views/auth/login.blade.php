<!doctype html>
<html lang="es" class="h-full">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Iniciar sesión – {{ config('app.name') }}</title>

  {{-- Tailwind y Alpine (CDN, rápido para empezar) --}}
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

  {{-- Fuente opcional --}}
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
  <style>
    html, body { font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial, "Noto Sans", "Apple Color Emoji", "Segoe UI Emoji"; }
  </style>
</head>
<body class="h-full bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-slate-100">

  <div class="min-h-full flex items-center justify-center px-4 py-12">
    <div class="mx-auto w-full max-w-md">
      {{-- Tarjeta --}}
      <div class="relative overflow-hidden rounded-2xl shadow-2xl ring-1 ring-white/10 bg-slate-900/70 backdrop-blur">
        {{-- Header/logo --}}
        <div class="px-8 pt-8 pb-4 text-center">
          <div class="mx-auto mb-4 h-12 w-12 rounded-xl bg-indigo-500/20 flex items-center justify-center ring-1 ring-inset ring-indigo-400/20">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6l4 2m5-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
          <h1 class="text-xl font-semibold tracking-tight">Iniciar sesión</h1>
          <p class="mt-1 text-sm text-slate-400">Bienvenido a {{ config('app.name') }}</p>
        </div>

        {{-- Mensajes de error/estado --}}
        @if ($errors->any())
          <div class="mx-8 mb-3 rounded-lg bg-red-500/10 text-red-300 ring-1 ring-red-500/20 px-4 py-3 text-sm">
            {{ $errors->first() }}
          </div>
        @endif
        @if (session('status'))
          <div class="mx-8 mb-3 rounded-lg bg-emerald-500/10 text-emerald-300 ring-1 ring-emerald-500/20 px-4 py-3 text-sm">
            {{ session('status') }}
          </div>
        @endif

        {{-- Formulario --}}
        <form class="px-8 pb-8" method="POST" action="{{ route('login.post') }}" x-data="{ show:false, loading:false }" @submit="loading=true">
          @csrf
          {{-- Correo --}}
          <label class="block text-sm font-medium text-slate-200">Correo</label>
          <div class="mt-1">
            <input
              type="email"
              name="correo"
              value="{{ old('correo') }}"
              required
              autocomplete="email"
              class="w-full rounded-xl border-0 bg-slate-800/70 text-slate-100 placeholder-slate-400 shadow-inner focus:ring-2 focus:ring-indigo-500/60 px-4 py-3 ring-1 ring-white/10"
              placeholder="tucorreo@ejemplo.com"
            />
          </div>

          {{-- Contraseña --}}
          <div class="mt-5">
            <label class="block text-sm font-medium text-slate-200">Contraseña</label>
            <div class="mt-1 relative">
              <input
                :type="show ? 'text' : 'password'"
                name="contrasena"
                required
                autocomplete="current-password"
                class="w-full rounded-xl border-0 bg-slate-800/70 text-slate-100 placeholder-slate-400 shadow-inner focus:ring-2 focus:ring-indigo-500/60 px-4 py-3 ring-1 ring-white/10 pr-12"
                placeholder="••••••••"
              />
              <button type="button" @click="show=!show" class="absolute inset-y-0 right-0 px-3 flex items-center text-slate-400 hover:text-slate-200">
                <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.036 12.322a1 1 0 010-.644C3.423 7.51 7.36 5 12 5c4.64 0 8.577 2.51 9.964 6.678.07.213.07.431 0 .644C20.577 16.49 16.64 19 12 19c-4.64 0-8.577-2.51-9.964-6.678z"/>
                  <circle cx="12" cy="12" r="3" stroke-width="1.5" stroke="currentColor" fill="none"/>
                </svg>
                <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3l18 18M10.477 10.489A3 3 0 0113.5 13.5m5.21-1.822A10.477 10.477 0 0012 5c-1.7 0-3.31.38-4.74 1.06M6.5 6.5A10.45 10.45 0 003 12c1.387 4.168 5.324 6.678 9.964 6.678 1.28 0 2.514-.194 3.676-.558"/>
                </svg>
              </button>
            </div>
          </div>

          {{-- Recordarme + Olvidé contraseña (opcional) --}}
          <div class="mt-5 flex items-center justify-between">
            <label class="flex items-center gap-2 text-sm text-slate-300">
              <input type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-600 bg-slate-800 text-indigo-500 focus:ring-indigo-500/60">
              Recuérdame
            </label>
            {{-- <a href="#" class="text-sm text-indigo-400 hover:text-indigo-300">¿Olvidaste tu contraseña?</a> --}}
          </div>

          {{-- Botón --}}
          <button
            type="submit"
            class="mt-6 inline-flex w-full items-center justify-center gap-2 rounded-xl bg-indigo-500 px-4 py-3 font-medium text-white shadow-lg shadow-indigo-500/25 ring-1 ring-inset ring-indigo-400/30 hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-400 disabled:opacity-60"
            :disabled="loading"
          >
            <svg x-show="loading" class="h-5 w-5 animate-spin" viewBox="0 0 24 24" fill="none">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"></circle>
              <path class="opacity-75" d="M4 12a8 8 0 018-8v4" stroke="currentColor"></path>
            </svg>
            <span x-text="loading ? 'Ingresando...' : 'Ingresar'">Ingresar</span>
          </button>

          {{-- Pie de tarjeta --}}
          <p class="mt-6 text-center text-xs text-slate-400">
            Acceso restringido. Si tienes problemas para ingresar, contacta al administrador.
          </p>
        </form>
      </div>

      {{-- Marca inferior --}}
      <p class="mt-6 text-center text-xs text-slate-500/80">
        © {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.
      </p>
    </div>
  </div>

</body>
</html>
