<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('solicituds', function (Blueprint $table) {
            $table->string('estado')->default('pendiente'); 
            // 'pendiente', 'aprobada', 'fallida'
        });
    }

    public function down()
    {
        Schema::table('solicituds', function (Blueprint $table) {
            $table->dropColumn('estado');
        });
    }

};
