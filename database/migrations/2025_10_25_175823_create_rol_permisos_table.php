<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rol_permisos', function (Blueprint $t) {
            $t->foreignId('rol_id')->constrained('rols')->cascadeOnUpdate()->cascadeOnDelete();
            $t->foreignId('permiso_id')->constrained('permisos')->cascadeOnUpdate()->cascadeOnDelete();
            $t->boolean('activo')->default(true);
            $t->primary(['rol_id', 'permiso_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rol_permisos');
    }
};
