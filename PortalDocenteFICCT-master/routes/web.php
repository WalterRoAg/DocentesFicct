<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountController;

use App\Http\Controllers\Admin\HomeController as AdminHome;
use App\Http\Controllers\Docente\HomeController as DocenteHome;

use App\Http\Controllers\PermisoController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Admin\PersonaController;
use App\Http\Controllers\RolPermisoController;
use App\Http\Controllers\Admin\DocenteController;
use App\Http\Controllers\Admin\AdministrativoController;

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Redirige la raíz al login
Route::redirect('/', '/login');

// --- ADMINISTRADOR ---
Route::middleware(['auth', 'role:administrador'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\HomeController::class, 'index'])->name('dashboard');
    
    // Usuarios
    Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
    Route::get('/usuarios/create', [UsuarioController::class, 'create'])->name('usuarios.create');
    Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
    Route::get('/usuarios/{usuario}/edit', [UsuarioController::class, 'edit'])->name('usuarios.edit');
    Route::put('/usuarios/{usuario}', [UsuarioController::class, 'update'])->name('usuarios.update');
    Route::delete('/usuarios/{usuario}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');
});

// --- DOCENTE ---
Route::middleware(['auth', 'role:docente'])->group(function () {
    Route::get('/docente', [\App\Http\Controllers\Docente\HomeController::class, 'index'])->name('docente.dashboard');
    // aquí irán rutas exclusivas del docente
});

// --- COORDINADOR (VERSIÓN CORREGIDA) ---
use App\Http\Controllers\Coordinador\AulaController;
use App\Http\Controllers\Coordinador\GrupoController;
use App\Http\Controllers\Coordinador\MateriaController;

Route::middleware(['auth', 'role:coordinador'])
    ->prefix('coordinador')
    ->name('coordinador.')
    ->group(function () {
        // Dashboard
        Route::get('/', [\App\Http\Controllers\Coordinador\HomeController::class, 'index'])
            ->name('dashboard');

        // AULAS
        Route::resource('aulas', AulaController::class)
            ->only(['index', 'create', 'store', 'edit', 'update']);
        
        Route::put('aulas/{aula}/activar', [AulaController::class, 'activar'])->name('aulas.activar');
        Route::put('aulas/{aula}/desactivar', [AulaController::class, 'desactivar'])->name('aulas.desactivar');

        // GRUPOS
        Route::middleware('permiso:gestionar-grupos')->group(function () {
            Route::resource('grupos', GrupoController::class)->except(['show']);
        });

        // MATERIAS
        Route::resource('materias', MateriaController::class)->except(['show']);
        Route::get('materias/asignar', [MateriaController::class, 'assignGroup'])->name('materias.assignGroup');
        Route::post('materias/asignar', [MateriaController::class, 'storeGroupAssignment'])->name('materias.storeGroupAssignment');
        
        // Toggle del estado en la pivote (materia <-> grupo)
        Route::patch(
            'materias/{materia:sigla}/grupos/{grupo}/toggle',
            [MateriaController::class, 'toggleGroup']
        )->name('materias.grupos.toggle');

        // Quitar la asignación materia <-> grupo
        Route::delete(
            'materias/{materia:sigla}/grupos/{grupo}',
            [MateriaController::class, 'detachGroup']
        )->name('materias.grupos.detach');
    });

// --- RUTAS COMUNES PARA TODOS LOS USUARIOS AUTENTICADOS ---
Route::middleware('auth')->group(function () {
    Route::put('/account/profile', [AccountController::class, 'updateProfile'])->name('account.update.profile');
    Route::put('/account/password', [AccountController::class, 'updatePassword'])->name('account.update.password');
    Route::put('/account/phone', [AccountController::class, 'updatePhone'])->name('account.update.phone');
});