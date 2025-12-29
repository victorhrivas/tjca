<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ot_vehiculos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('ot_id');

            // Por ahora compatible con tu OT (string). Más adelante puede migrar a conductor_id.
            $table->string('conductor')->nullable();

            $table->string('patente_camion')->nullable();
            $table->string('patente_remolque')->nullable();

            // Para ordenar 1..N (principal, apoyo, etc.)
            $table->unsignedInteger('orden')->default(1);

            // Opcional pero útil
            $table->string('rol')->nullable();           // principal / apoyo / relevo
            $table->text('observaciones')->nullable();   // notas del vehículo/chofer
            $table->dateTime('desde')->nullable();       // si cambia durante la OT
            $table->dateTime('hasta')->nullable();

            $table->timestamps();

            $table->foreign('ot_id')->references('id')->on('ots')->onDelete('cascade');
            $table->index(['ot_id', 'orden']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ot_vehiculos');
    }
};
