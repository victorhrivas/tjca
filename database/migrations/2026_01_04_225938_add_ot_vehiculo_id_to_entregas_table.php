<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('entregas', function (Blueprint $table) {
            $table->unsignedBigInteger('ot_vehiculo_id')->nullable()->after('ot_id');

            $table->foreign('ot_vehiculo_id')
                ->references('id')
                ->on('ot_vehiculos')
                ->onDelete('cascade');

            $table->index(['ot_id', 'ot_vehiculo_id'], 'entregas_ot_vehiculo_idx');
            $table->unique(['ot_id', 'ot_vehiculo_id'], 'entregas_ot_vehiculo_unique');
        });
    }

    public function down(): void
    {
        Schema::table('entregas', function (Blueprint $table) {
            $table->dropUnique('entregas_ot_vehiculo_unique');
            $table->dropIndex('entregas_ot_vehiculo_idx');

            $table->dropForeign(['ot_vehiculo_id']);
            $table->dropColumn('ot_vehiculo_id');
        });
    }
};
