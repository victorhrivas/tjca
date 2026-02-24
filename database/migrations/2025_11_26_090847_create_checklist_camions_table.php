<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checklist_camions', function (Blueprint $table) {
            $table->id();
            $table->dateTime('fecha_checklist'); // NUEVO

            $table->string('nombre_conductor');
            $table->string('patente');
            $table->string('kilometraje');
            $table->string('nivel_aceite');
            $table->string('luces_altas_bajas');
            $table->string('intermitentes');
            $table->string('luces_posicion');
            $table->string('luces_freno');
            $table->text('estado_neumaticos');
            $table->string('sistema_frenos');
            $table->string('estado_espejos');
            $table->string('parabrisas');
            $table->string('calefaccion_ac');
            $table->string('estado_tablones')->nullable();
            $table->string('acumulacion_aire');
            $table->string('extintor');
            $table->string('neumatico_repuesto');
            $table->string('asiento_conductor');
            $table->string('conos_cunas');
            $table->string('trinquetes_cadenas');
            $table->text('ruidos_motor')->nullable();
            $table->text('detalle_mal_estado')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('checklist_camions');
    }
};
