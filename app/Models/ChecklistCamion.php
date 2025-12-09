<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChecklistCamion extends Model
{
    public $table = 'checklist_camions';

    public $fillable = [
        'fecha_checklist',   // NUEVO
        'nombre_conductor',
        'patente',
        'kilometraje',
        'nivel_aceite',
        'luces_altas_bajas',
        'intermitentes',
        'luces_posicion',
        'luces_freno',
        'estado_neumaticos',
        'sistema_frenos',
        'estado_espejos',
        'parabrisas',
        'calefaccion_ac',
        'estado_tablones',
        'acumulacion_aire',
        'extintor',
        'neumatico_repuesto',
        'asiento_conductor',
        'conos_cunas',
        'trinquetes_cadenas',
        'ruidos_motor',
        'detalle_mal_estado'
    ];

    protected $casts = [
        'fecha_checklist'     => 'datetime',   // NUEVO
        'nombre_conductor'    => 'string',
        'patente'             => 'string',
        'kilometraje'         => 'string',
        'nivel_aceite'        => 'string',
        'luces_altas_bajas'   => 'string',
        'intermitentes'       => 'string',
        'luces_posicion'      => 'string',
        'luces_freno'         => 'string',
        'estado_neumaticos'   => 'string',
        'sistema_frenos'      => 'string',
        'estado_espejos'      => 'string',
        'parabrisas'          => 'string',
        'calefaccion_ac'      => 'string',
        'estado_tablones'     => 'string',
        'acumulacion_aire'    => 'string',
        'extintor'            => 'string',
        'neumatico_repuesto'  => 'string',
        'asiento_conductor'   => 'string',
        'conos_cunas'         => 'string',
        'trinquetes_cadenas'  => 'string',
        'ruidos_motor'        => 'string',
        'detalle_mal_estado'  => 'string',
    ];

    public static array $rules = [
        'nombre_conductor'   => 'required|string|max:255',
        'patente'            => 'required|string|max:50',
        'kilometraje'        => 'nullable|string|max:50',

        // nivel de aceite: bajo, 1,2,3,4,5,normal (como el form de Google)
        'nivel_aceite'       => 'required|in:bajo,1,2,3,4,5,normal',

        // Todos estos con * en el formulario
        'luces_altas_bajas'  => 'required|in:buen_estado,mal_estado',
        'intermitentes'      => 'required|in:buen_estado,mal_estado',
        'luces_posicion'     => 'required|in:buen_estado,mal_estado',
        'luces_freno'        => 'required|in:buen_estado,mal_estado',
        'estado_neumaticos'  => 'required|string|max:255',
        'sistema_frenos'     => 'required|in:buen_estado,mal_estado',
        'estado_espejos'     => 'required|in:buen_estado,mal_estado',
        'parabrisas'         => 'required|in:buen_estado,mal_estado',
        'calefaccion_ac'     => 'required|in:buen_estado,mal_estado',
        'estado_tablones'    => 'nullable|in:buen_estado,mal_estado',
        'acumulacion_aire'   => 'required|in:buen_estado,mal_estado',
        'extintor'           => 'required|in:vigente,vencido',
        'neumatico_repuesto' => 'required|in:buen_estado,mal_estado',
        'asiento_conductor'  => 'required|in:buen_estado,mal_estado',
        'conos_cunas'        => 'required|in:buen_estado,mal_estado',
        'trinquetes_cadenas' => 'required|in:buen_estado,mal_estado',

        'ruidos_motor'       => 'nullable|string|max:255',
        'detalle_mal_estado' => 'nullable|string',
    ];
}
