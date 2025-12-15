<?php

// php artisan make:migration alter_solicituds_carga_nullable

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('solicituds', function (Blueprint $table) {
            $table->string('carga')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('solicituds', function (Blueprint $table) {
            $table->string('carga')->nullable(false)->change();
        });
    }
};
