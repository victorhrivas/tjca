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
        Schema::create('tarifa_rutas', function (Blueprint $table) {
            $table->id();
            $table->string('origen');
            $table->string('destino');
            $table->integer('km')->nullable();
            $table->integer('cama_baja_25_ton');
            $table->integer('rampla_autodescargable');
            $table->integer('rampla_plana');
            $table->integer('autodescargable_10_ton');
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
        Schema::drop('tarifa_rutas');
    }
};
