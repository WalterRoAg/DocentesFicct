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
        Schema::create('grupo_materias', function (Blueprint $t) {
            $t->foreignId('grupo_id')->constrained('grupos')->cascadeOnUpdate()->cascadeOnDelete();
            $t->string('materia_sigla', 20);
            $t->boolean('activo')->default(true);
            $t->primary(['grupo_id', 'materia_sigla']);
            $t->foreign('materia_sigla')->references('sigla')->on('materias')
                ->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grupo_materias');
    }
};
