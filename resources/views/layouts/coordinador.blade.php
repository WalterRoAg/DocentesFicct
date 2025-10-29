<!doctype html>
<html lang="es" class="h-full">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Panel Coordinador – {{ config('app.name') }}</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <style>[x-cloak]{display:none!important}</style>
</head>

<body class="h-full bg-slate-100 text-slate-800">
<div class="min-h-full" x-data="{ open:false }">

  {{-- HEADER --}}
  <header class="bg-white shadow sticky top-0 z-40">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
      <div class="flex items-center gap-3">
        <button class="lg:hidden p-2 rounded-md hover:bg-slate-100" @click="open=!open" aria-label="Abrir menú">
          <svg x-show="!open" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                  d="M4 6h16M4 12h16M4 18h16"/>
          </svg>
          <svg x-show="open" x-cloak class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                  d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>

        <div class="flex items-center gap-2">
          <a href="{{ route('coordinador.dashboard') }}">
            <div class="h-9 w-9 rounded-xl bg-emerald-600 text-white grid place-items-center shadow font-semibold">
              CO
            </div>
          </a>
          <span class="font-semibold">Panel Coordinador</span>
        </div>
      </div>

      <div class="flex items-center gap-4">
        <div class="text-sm text-slate-600">
          Bienvenido, <span class="font-semibold">{{ auth()->user()->nombre }}</span>
        </div>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="rounded-lg bg-slate-800 text-white px-3 py-2 text-sm hover:bg-slate-700">
            Salir
          </button>
        </form>
      </div>
    </div>
  </header>

  {{-- CUERPO PRINCIPAL --}}
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6 grid grid-cols-1 lg:grid-cols-12 gap-6">
    
    {{-- SIDEBAR --}}
    <aside class="lg:col-span-3">
      <nav :class="open ? 'block' : 'hidden lg:block'"
           class="bg-white rounded-2xl border border-slate-200 p-2 shadow-sm">
        <p class="px-3 py-2 text-xs uppercase tracking-wide text-slate-500">Navegación</p>

        <ul class="space-y-1">
          {{-- Resumen --}}
          <li>
            <a href="{{ route('coordinador.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-xl transition
                      {{ request()->routeIs('coordinador.dashboard') 
                        ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200' 
                        : 'text-slate-700 hover:bg-slate-50' }}">
              <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5"
                   viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12h18M3 6h18M3 18h18"/>
              </svg>
              <span class="text-sm font-medium">Resumen</span>
            </a>
          </li>

          {{-- Aulas --}}
          <li>
            <a href="{{ route('coordinador.aulas.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-xl transition
                      {{ request()->is('coordinador/aulas*')
                        ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200'
                        : 'text-slate-700 hover:bg-slate-50' }}">
              <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5"
                   viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
              </svg>
              <span class="text-sm font-medium">Aulas</span>
            </a>
          </li>

          {{-- Grupos --}}
          <li>
            <a href="{{ route('coordinador.grupos.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-xl transition
                      {{ request()->is('coordinador/grupos*')
                        ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200'
                        : 'text-slate-700 hover:bg-slate-50' }}">
              <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5"
                   viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/>
              </svg>
              <span class="text-sm font-medium">Grupos</span>
            </a>
          </li>

          {{-- Materias --}}
          <li>
            <a href="{{ route('coordinador.materias.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-xl transition
                      {{ request()->is('coordinador/materias*')
                        ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200'
                        : 'text-slate-700 hover:bg-slate-50' }}">
              <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5"
                   viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12l5 5L20 7"/>
              </svg>
              <span class="text-sm font-medium">Materias</span>
            </a>
          </li>

          {{-- Mi cuenta --}}
          <li>
            <a href="{{ route('coordinador.dashboard') }}#mi-cuenta"
               class="flex items-center gap-3 px-3 py-2 rounded-xl transition
                      {{ request()->is('coordinador/cuenta*')
                        ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200'
                        : 'text-slate-700 hover:bg-slate-50' }}">
              <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5"
                   viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M15 11a3 3 0 11-6 0a3 3 0 016 0zM4 20a8 8 0 1116 0"/>
              </svg>
              <span class="text-sm font-medium">Mi cuenta</span>
            </a>
          </li>
        </ul>
      </nav>
    </aside>

    {{-- CONTENIDO PRINCIPAL --}}
    <main class="lg:col-span-9 space-y-6">
      @yield('content')
    </main>

  </div>
</div>
</body>
</html>
