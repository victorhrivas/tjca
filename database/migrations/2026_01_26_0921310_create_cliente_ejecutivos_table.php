<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cliente_ejecutivos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('cliente_id')
                ->constrained('clientes')
                ->cascadeOnDelete();

            $table->string('nombre');
            $table->string('correo')->nullable();
            $table->string('telefono')->nullable();
            $table->string('cargo')->nullable();

            $table->boolean('activo')->default(true);
            $table->boolean('es_principal')->default(false);

            $table->timestamps();

            $table->index(['cliente_id', 'activo']);
            $table->unique(['cliente_id', 'correo']); // opcional
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cliente_ejecutivos');
    }
};
