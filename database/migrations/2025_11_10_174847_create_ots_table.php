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

            // Folio visible por el cliente (Ej: 202512/001)
            $table->string('folio')->unique()->nullable();

            // Relación con la cotización
            $table->unsignedBigInteger('cotizacion_id');

            // Datos operativos
            $table->string('equipo')->nullable();
            $table->string('origen')->nullable();
            $table->string('destino')->nullable();
            $table->string('cliente')->nullable();

            $table->string('contacto_origen')->nullable();
            $table->string('contacto_destino')->nullable();
            $table->string('link_mapa')->nullable();

            $table->integer('valor')->nullable();
            $table->date('fecha')->nullable();

            $table->string('solicitante')->nullable();
            $table->string('conductor')->nullable();

            $table->string('patente_camion')->nullable();
            $table->string('patente_remolque')->nullable();

            // *** Corregido (antes tenía error “endiente”) ***
            $table->string('estado')->default('pendiente');

            $table->text('observaciones')->nullable();

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
        Schema::dropIfExists('ots');
    }
};
