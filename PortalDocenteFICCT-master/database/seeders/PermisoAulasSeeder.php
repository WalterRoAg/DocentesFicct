<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Permiso, Rol};

class PermisoAulasSeeder extends Seeder
{
    public function run(): void
    {
        // crea permiso si no existe
        $perm = Permiso::firstOrCreate(['nombre' => 'gestionar-aulas']);

        // asigna al rol coordinador si existe
        $coordinador = Rol::where('nombre', 'coordinador')->first();
        if ($coordinador && !$coordinador->permisos()->where('permisos.id', $perm->id)->exists()) {
            $coordinador->permisos()->attach($perm->id);
        }
    }
}
