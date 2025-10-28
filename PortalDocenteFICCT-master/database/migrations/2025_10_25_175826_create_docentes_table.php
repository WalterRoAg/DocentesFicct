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
        Schema::create('docentes', function (Blueprint $t) {
            $t->foreignId('persona_id')->primary()->constrained('personas')->cascadeOnUpdate()->cascadeOnDelete();
            $t->integer('anios_experiencia')->nullable(); // en tu SQL: "años_experiencia"
            $t->date('fecha_ingreso')->nullable();
            $t->boolean('activo')->default(true);
            $t->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('docentes');
    }
};
