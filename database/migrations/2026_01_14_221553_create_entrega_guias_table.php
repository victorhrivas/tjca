<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('entrega_guias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('entrega_id');
            $table->string('archivo');          // ruta/filename
            $table->unsignedInteger('orden')->default(1);
            $table->timestamps();

            $table->foreign('entrega_id')
                ->references('id')->on('entregas')
                ->onDelete('cascade');

            $table->index(['entrega_id', 'orden']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entrega_guias');
    }
};
