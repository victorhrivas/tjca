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
        Schema::create('inicio_cargas', function (Blueprint $table) {
            $table->id(); // recomendado
            $table->unsignedBigInteger('ot_id');
            $table->string('cliente');
            $table->string('contacto');
            $table->string('telefono_contacto');
            $table->string('correo_contacto');
            $table->string('origen');
            $table->string('destino');
            $table->string('tipo_carga');
            $table->string('peso_aproximado')->nullable();
            $table->date('fecha_carga')->nullable();
            $table->string('hora_presentacion')->nullable();
            $table->string('conductor')->nullable(); // NUEVO
            $table->text('observaciones')->nullable();
            $table->timestamps();

            // opcional, si quieres FK:
            // $table->foreign('ot_id')->references('id')->on('ots')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('inicio_cargas');
    }
};
