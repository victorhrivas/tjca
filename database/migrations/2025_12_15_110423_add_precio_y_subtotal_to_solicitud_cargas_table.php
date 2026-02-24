<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('solicitud_cargas', function (Blueprint $table) {
            $table->integer('precio_unitario')->default(0)->after('cantidad'); // CLP
            $table->integer('subtotal')->default(0)->after('precio_unitario'); // CLP cacheado
        });
    }

    public function down(): void
    {
        Schema::table('solicitud_cargas', function (Blueprint $table) {
            $table->dropColumn(['precio_unitario', 'subtotal']);
        });
    }
};
