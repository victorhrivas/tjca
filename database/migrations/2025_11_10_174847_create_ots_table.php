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
        Schema::create('ots', function (Blueprint $table) {
            $table->id();

            // Relación con la cotización
            $table->unsignedBigInteger('cotizacion_id');

            // Datos operativos de la OT
            $table->string('equipo')->nullable();            // Tipo de carga / equipo
            $table->string('origen')->nullable();
            $table->string('destino')->nullable();

            // Cliente (nombre libre; si quieres podemos luego agregar cliente_id)
            $table->string('cliente')->nullable();

            $table->string('contacto_origen')->nullable();
            $table->string('contacto_destino')->nullable();

            $table->string('link_mapa')->nullable();

            // Valor / monto de la OT
            $table->integer('valor')->nullable();            // o bigInteger/decimal si lo prefieres

            // Fecha de la OT (fecha programada o de servicio)
            $table->date('fecha')->nullable();

            // Quién pidió el servicio
            $table->string('solicitante')->nullable();

            // Conductor asignado
            $table->string('conductor')->nullable();

            // Patentes (que hoy te están fallando)
            $table->string('patente_camion')->nullable();

            // Estado de la OT
            $table->string('estado')->default('endiente');

            // Observaciones generales
            $table->text('observaciones')->nullable();

            $table->timestamps();

            // Opcional: llave foránea
            // $table->foreign('cotizacion_id')
            //       ->references('id')->on('cotizacions')
            //       ->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ots');
    }
};
