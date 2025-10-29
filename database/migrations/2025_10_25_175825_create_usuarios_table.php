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
        Schema::create('usuarios', function (Blueprint $t) {
            $t->id();
            $t->string('nombre', 100);
            $t->string('correo', 100)->unique();
            $t->string('contrasena', 255); // en tu SQL: "contraseña"
            $t->boolean('activo')->default(true);
            $t->foreignId('rol_id')->constrained('rols')->cascadeOnUpdate()->cascadeOnDelete();
            $t->foreignId('persona_id')->constrained('personas')->cascadeOnUpdate()->cascadeOnDelete();
            $t->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
