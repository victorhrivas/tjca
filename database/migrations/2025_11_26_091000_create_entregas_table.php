<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('entregas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ot_id');

            $table->string('cliente')->nullable();
            $table->string('nombre_receptor');
            $table->string('rut_receptor')->nullable();
            $table->string('telefono_receptor')->nullable();
            $table->string('correo_receptor')->nullable();

            $table->string('lugar_entrega')->nullable();
            $table->date('fecha_entrega')->nullable();
            $table->string('hora_entrega')->nullable();

            $table->string('numero_guia')->nullable();
            $table->string('numero_interno')->nullable();

            $table->boolean('conforme')->default(true);
            $table->string('conductor')->nullable();
            $table->text('observaciones')->nullable();

            // Igual que inicio_cargas
            $table->string('foto_1')->nullable();
            $table->string('foto_2')->nullable();
            $table->string('foto_3')->nullable();

            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('entregas');
    }
};
