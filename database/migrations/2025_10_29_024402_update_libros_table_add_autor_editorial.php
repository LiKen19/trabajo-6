<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('libros', function (Blueprint $table) {
            // Si antes existía 'año', la eliminamos
            if (Schema::hasColumn('libros', 'año')) {
                $table->dropColumn('año');
            }

            // Agregamos las nuevas columnas
            $table->string('autor')->after('idioma');
            $table->string('editorial')->after('autor');
        });
    }

    public function down(): void
    {
        Schema::table('libros', function (Blueprint $table) {
            // Revertir cambios
            $table->dropColumn(['autor', 'editorial']);
            $table->integer('año')->nullable();
        });
    }
};
