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

        Schema::create('horario_clases', function (Blueprint $t) {
            $t->id();
            $t->foreignId('horario_id')->constrained('horarios')->cascadeOnUpdate()->cascadeOnDelete();
            $t->foreignId('aula_id')->constrained('aulas')->cascadeOnUpdate()->cascadeOnDelete();

            // FK compuesta -> grupo_materia
            $t->unsignedBigInteger('grupo_materia_grupo_id');
            $t->string('grupo_materia_materia_sigla', 20);

            $t->foreign(['grupo_materia_grupo_id', 'grupo_materia_materia_sigla'])
                ->references(['grupo_id', 'materia_sigla'])->on('grupo_materias')
                ->cascadeOnUpdate()->cascadeOnDelete();

            $t->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horario_clases');
    }
};
