<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ots', function (Blueprint $table) {
            if (!Schema::hasColumn('ots', 'oc')) {
                $table->string('oc')->nullable()->after('conductor');
            }

            if (!Schema::hasColumn('ots', 'status')) {
                $table->string('status')->nullable()->after('oc');
            }

            if (!Schema::hasColumn('ots', 'gdd')) {
                $table->string('gdd')->nullable()->after('status');
            }

            if (!Schema::hasColumn('ots', 'afid_interno')) {
                $table->string('afid_interno')->nullable()->after('gdd');
            }

            if (!Schema::hasColumn('ots', 'factura_externo')) {
                $table->string('factura_externo')->nullable()->after('afid_interno');
            }

            if (!Schema::hasColumn('ots', 'factura')) {
                $table->string('factura')->nullable()->after('factura_externo');
            }

            if (!Schema::hasColumn('ots', 'fecha_factura')) {
                $table->date('fecha_factura')->nullable()->after('factura');
            }
        });
    }

    public function down(): void
    {
        Schema::table('ots', function (Blueprint $table) {
            $columns = [
                'oc',
                'status',
                'gdd',
                'afid_interno',
                'factura_externo',
                'factura',
                'fecha_factura',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('ots', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};