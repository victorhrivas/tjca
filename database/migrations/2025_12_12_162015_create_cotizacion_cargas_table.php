<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cotizacion_cargas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cotizacion_id')->constrained('cotizacions')->onDelete('cascade');

            $table->string('descripcion');                 // Ej: "Flete Santiago -> Rancagua"
            $table->decimal('cantidad', 12, 2)->default(1); // permite 1.5, 2.25, etc
            $table->integer('precio_unitario')->default(0); // CLP
            $table->integer('subtotal')->default(0);        // CLP cacheado

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cotizacion_cargas');
    }
};
