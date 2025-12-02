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
        Schema::create('entregas', function (Blueprint $table) {
            $table->id(); // recomendado
            $table->unsignedBigInteger('ot_id');
            $table->string('cliente')->nullable();
            $table->string('nombre_receptor');
            $table->string('rut_receptor')->nullable();
            $table->string('telefono_receptor')->nullable();
            $table->string('correo_receptor')->nullable();
            $table->string('lugar_entrega')->nullable();
            $table->date('fecha_entrega')->nullable();
            $table->date('numero_guia')->nullable();
            $table->date('numero_interno')->nullable();
            $table->string('hora_entrega')->nullable();
            $table->boolean('conforme')->default(true);
            $table->string('conductor')->nullable(); // NUEVO
            $table->text('observaciones')->nullable();
            $table->text('fotos')->nullable();
            $table->timestamps();

            // opcional FK:
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
        Schema::drop('entregas');
    }
};
