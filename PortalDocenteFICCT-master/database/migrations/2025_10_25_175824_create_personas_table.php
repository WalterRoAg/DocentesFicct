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
         Schema::create('personas', function (Blueprint $t) {
            $t->id(); // bigserial en PostgreSQL
            $t->string('carnet', 50)->unique();
            $t->string('nombre', 100);
            $t->string('telefono', 20)->nullable();
            $t->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
