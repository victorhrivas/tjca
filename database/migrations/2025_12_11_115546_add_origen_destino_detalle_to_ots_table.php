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
        Schema::table('ots', function (Blueprint $table) {
            // Detalle de contacto y dirección ORIGEN
            $table->string('telefono_origen')->nullable()->after('contacto_origen');
            $table->string('direccion_origen')->nullable()->after('telefono_origen');
            $table->string('link_mapa_origen')->nullable()->after('direccion_origen');

            // Detalle de contacto y dirección DESTINO
            $table->string('telefono_destino')->nullable()->after('contacto_destino');
            $table->string('direccion_destino')->nullable()->after('telefono_destino');
            $table->string('link_mapa_destino')->nullable()->after('direccion_destino');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ots', function (Blueprint $table) {
            $table->dropColumn([
                'telefono_origen',
                'direccion_origen',
                'link_mapa_origen',
                'telefono_destino',
                'direccion_destino',
                'link_mapa_destino',
            ]);
        });
    }
};
