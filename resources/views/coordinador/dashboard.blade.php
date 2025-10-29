<!doctype html>
<html lang="es" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Panel Coordinador – {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] {
            display: none !important
        }
    </style>
</head>

<body class="h-full bg-slate-100 text-slate-800">
    <div class="min-h-full" x-data="{ open: false, tab: 'resumen' }">

        <!-- HEADER -->
        <header class="bg-white shadow sticky top-0 z-40">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <button class="lg:hidden p-2 rounded-md hover:bg-slate-100" @click="open=!open"
                        aria-label="Abrir menú">
                        <svg x-show="!open" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg x-show="open" x-cloak class="h-6 w-6" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <div class="flex items-center gap-2">
                        <div class="h-9 w-9 rounded-xl bg-emerald-600 text-white grid place-items-center shadow">CO
                        </div>
                        <span class="font-semibold">Panel Coordinador</span>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <div class="text-sm text-slate-600">
                        Bienvenido, <span class="font-semibold">{{ auth()->user()->nombre }}</span>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="rounded-lg bg-slate-800 text-white px-3 py-2 text-sm hover:bg-slate-700">
                            Salir
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <!-- LAYOUT PRINCIPAL -->
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6 grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- SIDEBAR -->
            <aside class="lg:col-span-3">
                <nav :class="open ? 'block' : 'hidden lg:block'"
                    class="bg-white rounded-2xl border border-slate-200 p-2">
                    <p class="px-3 py-2 text-xs uppercase tracking-wide text-slate-500">Navegación</p>

                    <ul class="space-y-1">
                        <template
                            x-for="item in [
                            { id: 'resumen', label: 'Resumen', icon: 'M3 12h18M3 6h18M3 18h18' },
                            { id: 'aulas', label: 'Aulas', icon: 'M4 6h16M4 12h16M4 18h16' },
                            { id: 'asistencias', label: 'Asistencias', icon: 'M8 7V3m8 4V3M3 11h18M5 19h14' },
                            { id: 'grupos', label: 'Grupos', icon: 'M12 6v6l4 2' },
                            { id: 'materias', label: 'Materias', icon: 'M5 12l5 5L20 7' },
                            { id: 'mi-cuenta', label: 'Mi cuenta', icon: 'M15 11a3 3 0 11-6 0a3 3 0 016 0z M4 20a8 8 0 1116 0' }
                        ]"
                            :key="item.id">
                            <li>
                                <button @click="tab=item.id; open=false"
                                    :class="tab === item.id ?
                                        'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200' :
                                        'text-slate-700 hover:bg-slate-50'"
                                    class="w-full flex items-center gap-3 rounded-xl px-3 py-2 transition">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            :d="item.icon" />
                                    </svg>
                                    <span class="text-sm font-medium" x-text="item.label"></span>
                                </button>
                            </li>
                        </template>
                    </ul>
                </nav>
            </aside>

            <!-- CONTENIDO -->
            <main class="lg:col-span-9 space-y-6">
                <section x-show="tab === 'resumen'">
                    <h2 class="text-xl font-semibold mb-2">Resumen General</h2>
                    <p class="text-slate-600">Aquí se muestran los datos principales del coordinador.</p>
                </section>
                <section x-show="tab === 'aulas'">
                    <a href="{{ route('coordinador.aulas.index') }}"
                        class="block p-4 border rounded-lg hover:bg-gray-50">
                        <h2 class="font-semibold">Gestionar Aulas</h2>
                        <p class="text-sm text-gray-600">Crear, editar y ver aulas.</p>
                    </a>
                </section>

                <section x-show="tab === 'grupos'">
                    <a href="{{ route('coordinador.grupos.index') }}"
                        class="block p-4 border rounded-lg hover:bg-gray-50">
                        <h2 class="font-semibold">Gestionar Grupos</h2>
                        <p class="text-sm text-gray-600">Crear, editar y activar/desactivar grupos.</p>
                    </a>
                </section>

                <section x-show="tab === 'materias'">
                    <a href="{{ route('coordinador.materias.index') }}"
                        class="block p-4 border rounded-lg hover:bg-gray-50">
                        <h2 class="font-semibold">Gestionar Materias</h2>
                        <p class="text-sm text-gray-600">
                            Crear, editar, activar/desactivar y eliminar (solo si no tiene horarios asignados).
                        </p>
                    </a>
                </section>

                <section x-show="tab === 'mi-cuenta'">
                    <h2 class="text-xl font-semibold mb-2">Mi Cuenta</h2>
                    <p class="text-slate-600 mb-3">Actualiza tus datos personales.</p>

                    {{-- Alertas --}}
                    @if (session('ok'))
                        <div class="mb-3 rounded-lg bg-emerald-50 text-emerald-800 px-4 py-2">
                            {{ session('ok') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="mb-3 rounded-lg bg-red-50 text-red-800 px-4 py-2">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $e)
                                    <li>{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="grid md:grid-cols-2 gap-6">

                        {{-- 1) Nombre y Correo --}}
                        <form method="POST" action="{{ route('account.update.profile') }}"
                            class="space-y-4 bg-white rounded-xl p-4 ring-1 ring-slate-200">
                            @csrf
                            @method('PUT')

                            <div>
                                <label class="text-sm text-slate-700">Nombre</label>
                                <input type="text" name="nombre" value="{{ old('nombre', auth()->user()->nombre) }}"
                                    required
                                    class="mt-1 w-full rounded-xl bg-slate-50 ring-1 ring-slate-200 focus:ring-2 focus:ring-emerald-500 px-4 py-3">
                            </div>

                            <div>
                                <label class="text-sm text-slate-700">Correo (usuario)</label>
                                <input type="email" name="correo"
                                    value="{{ old('correo', auth()->user()->correo) }}" required
                                    class="mt-1 w-full rounded-xl bg-slate-50 ring-1 ring-slate-200 focus:ring-2 focus:ring-emerald-500 px-4 py-3">
                            </div>

                            <button class="rounded-xl bg-emerald-600 text-white px-4 py-2 text-sm hover:bg-emerald-700">
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
                                    class="mt-1 w-full rounded-xl bg-slate-50 ring-1 ring-slate-200 focus:ring-2 focus:ring-emerald-500 px-4 py-3">
                            </div>

                            <div>
                                <label class="text-sm text-slate-700">Confirmar Contraseña</label>
                                <input type="password" name="password_confirmation" required
                                    class="mt-1 w-full rounded-xl bg-slate-50 ring-1 ring-slate-200 focus:ring-2 focus:ring-emerald-500 px-4 py-3">
                            </div>

                            <button
                                class="rounded-xl bg-emerald-600 text-white px-4 py-2 text-sm hover:bg-emerald-700">
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
                                    class="mt-1 w-full rounded-xl bg-slate-50 ring-1 ring-slate-200 focus:ring-2 focus:ring-emerald-500 px-4 py-3">
                            </div>

                            <button
                                class="rounded-xl bg-emerald-600 text-white px-4 py-2 text-sm hover:bg-emerald-700">
                                Guardar teléfono
                            </button>
                        </form>

                    </div>
                </section>

            </main>
        </div>
    </div>
</body>

</html>
