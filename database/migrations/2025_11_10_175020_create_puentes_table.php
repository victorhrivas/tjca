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
        Schema::create('puentes', function (Blueprint $table) {
            $table->integer('ot_id')->unsigned();
            $table->string('fase');
            $table->string('motivo');
            $table->text('detalle');
            $table->boolean('notificar_cliente');
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
        Schema::drop('puentes');
    }
};
