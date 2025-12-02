<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cotizacions', function (Blueprint $table) {
            $table->id();

            // Relación con solicitud
            $table->unsignedBigInteger('solicitud_id');

            // Datos “congelados” desde solicitud
            $table->string('solicitante');
            $table->string('origen');
            $table->string('destino');
            $table->string('cliente');         // nombre cliente o razón social
            $table->string('carga')->nullable(); // tipo de carga o descripción breve

            // Monto total cotizado (copiado desde solicitud->valor, por ejemplo)
            $table->integer('monto')->default(0);

            // Estado de la cotización
            $table->enum('estado', ['enviada', 'aceptada', 'rechazada'])->default('enviada');

            $table->timestamps();

            // Opcional: FK
            // $table->foreign('solicitud_id')
            //       ->references('id')->on('solicituds')
            //       ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cotizacions');
    }
};
