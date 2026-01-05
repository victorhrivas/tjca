<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Para cada OT sin registros en ot_vehiculos, crea uno usando los campos legacy de ots
        $ots = DB::table('ots')
            ->leftJoin('ot_vehiculos', 'ot_vehiculos.ot_id', '=', 'ots.id')
            ->whereNull('ot_vehiculos.id')
            ->select('ots.id', 'ots.patente_camion', 'ots.conductor')
            ->get();

        foreach ($ots as $ot) {
            // si no hay patente, igual puedes crear el registro o saltarlo. Recomiendo crearlo igual.
            DB::table('ot_vehiculos')->insert([
                'ot_id'          => $ot->id,
                'patente_camion' => $ot->patente_camion,
                'conductor'      => $ot->conductor,
                'orden'          => 1,
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }
    }

    public function down(): void
    {
        // Normalmente no se revierte un backfill automáticamente.
    }
};
