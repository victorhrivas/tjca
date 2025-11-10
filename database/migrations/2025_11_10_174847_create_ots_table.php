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
            $table->integer('cotizacion_id')->unsigned();
            $table->string('conductor');
            $table->string('patente_camion');
            $table->string('patente_remolque');
            $table->enum('estado', ['inicio_carga', 'en_transito', 'entregada'])->default('inicio_carga');
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
        Schema::drop('ots');
    }
};
