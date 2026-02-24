<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inicio_cargas', function (Blueprint $table) {
            $table->string('foto_guia_despacho')->nullable()->after('foto_3');
        });
    }

    public function down(): void
    {
        Schema::table('inicio_cargas', function (Blueprint $table) {
            $table->dropColumn('foto_guia_despacho');
        });
    }
};
