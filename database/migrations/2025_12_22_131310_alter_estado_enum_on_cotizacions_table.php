<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE cotizacions
            MODIFY estado ENUM('pendiente','enviada','aceptada','rechazada')
            NOT NULL DEFAULT 'pendiente'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE cotizacions
            MODIFY estado ENUM('enviada','aceptada','rechazada')
            NOT NULL DEFAULT 'enviada'
        ");
    }
};
