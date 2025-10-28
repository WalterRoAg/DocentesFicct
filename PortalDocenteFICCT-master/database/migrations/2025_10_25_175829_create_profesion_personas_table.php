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

        Schema::create('profesion_personas', function (Blueprint $t) {
            $t->foreignId('persona_id')->constrained('personas')->cascadeOnUpdate()->cascadeOnDelete();
            $t->foreignId('profesion_id')->constrained('profesions')->cascadeOnUpdate()->cascadeOnDelete();
            $t->string('nivel', 50)->nullable();
            $t->primary(['persona_id', 'profesion_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profesion_personas');
    }
};
