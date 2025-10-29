<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('aulas', function (Blueprint $table) {
            if (!Schema::hasColumn('aulas', 'capacidad')) {
                $table->unsignedInteger('capacidad')->default(30);
            }
        });
    }

    public function down(): void
    {
        Schema::table('aulas', function (Blueprint $table) {
            if (Schema::hasColumn('aulas', 'capacidad')) {
                $table->dropColumn('capacidad');
            }
        });
    }
};
