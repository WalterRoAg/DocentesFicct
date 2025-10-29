<!doctype html>
<html lang="es" class="h-full">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Docente – {{ config('app.name') }}</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <style>
    html, body { height: 100%; }
    body { font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial; }
  </style>
</head>
<body class="h-full bg-slate-100 text-slate-800">
  <div class="min-h-full" x-data="{ open:false }">
    {{-- Topbar --}}
    <header class="bg-white shadow sticky top-0 z-40">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
        <div class="flex items-center gap-3">
          <button class="lg:hidden inline-flex items-center justify-center rounded-md p-2 hover:bg-slate-100"
                  @click="open = !open" aria-label="Abrir menú">
            <svg x-show="!open" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
            <svg x-show="open" x-cloak class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
          <div class="flex items-center gap-2">
            <div class="h-9 w-9 rounded-xl bg-emerald-600 text-white grid place-items-center shadow">
              <span class="font-semibold">DC</span>
            </div>
            <span class="font-semibold">Panel Docente</span>
          </div>
        </div>

        <div class="flex items-center gap-4">
          <div class="text-sm text-slate-600">
            Bienvenide, <span class="font-semibold">{{ auth()->user()->nombre }}</span>
          </div>
          <a href="{{ route('logout') }}"
             class="rounded-lg bg-slate-800 text-white px-3 py-2 text-sm hover:bg-slate-700">Salir</a>
        </div>
      </div>
    </header>

    {{-- Layout con sidebar --}}
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6 grid grid-cols-1 lg:grid-cols-12 gap-6"
         x-data="{ tab: 'hoy' }">

      {{-- Sidebar --}}
      <aside class="lg:col-span-3">
        <nav :class="open ? 'block' : 'hidden lg:block'" class="bg-white rounded-2xl border border-slate-200 p-2">
          <p class="px-3 py-2 text-xs uppercase tracking-wide text-slate-500">Navegación</p>
          <ul class="space-y-1">
            @php
              $items = [
                ['id'=>'hoy','label'=>'Mi día','icon'=>'M8 7V3m8 4V3M3 11h18M5 19h14'],
                ['id'=>'agenda','label'=>'Agenda','icon'=>'M3 7h18M5 10h14M7 13h10M9 16h6'],
                ['id'=>'cursos','label'=>'Mis cursos','icon'=>'M12 14l9-5-9-5-9 5 9 5z'],
                ['id'=>'asistencias','label'=>'Asistencias','icon'=>'M5 12l5 5L20 7'],
                ['id'=>'reportes','label'=>'Reportes','icon'=>'M12 6v6l4 2'],
                ['id'=>'perfil','label'=>'Perfil','icon'=>'M15 11a3 3 0 11-6 0 3 3 0 016 0z M4 20a8 8 0 1116 0'],
              ];
            @endphp
            @foreach($items as $it)
              <li>
                <button
                  @click="tab = '{{ $it['id'] }}'; open=false"
                  :class="tab === '{{ $it['id'] }}'
                    ? 'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-200'
                    : 'text-slate-700 hover:bg-slate-50'"
                  class="w-full flex items-center gap-3 rounded-xl px-3 py-2 transition">
                  <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $it['icon'] }}"/>
                  </svg>
                  <span class="text-sm font-medium">{{ $it['label'] }}</span>
                </button>
              </li>
            @endforeach
          </ul>
        </nav>
      </aside>

      {{-- Contenido principal --}}
      <main class="lg:col-span-9 space-y-6">
        @yield('content')
      </main>
    </div>
  </div>
</body>
</html>
