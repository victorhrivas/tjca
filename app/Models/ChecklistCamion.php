<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChecklistCamion extends Model
{
    public $table = 'checklist_camions';

    public $fillable = [
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
        'nombre_conductor' => 'string',
        'patente' => 'string',
        'kilometraje' => 'string',
        'nivel_aceite' => 'string',
        'luces_altas_bajas' => 'string',
        'intermitentes' => 'string',
        'luces_posicion' => 'string',
        'luces_freno' => 'string',
        'estado_neumaticos' => 'string',
        'sistema_frenos' => 'string',
        'estado_espejos' => 'string',
        'parabrisas' => 'string',
        'calefaccion_ac' => 'string',
        'estado_tablones' => 'string',
        'acumulacion_aire' => 'string',
        'extintor' => 'string',
        'neumatico_repuesto' => 'string',
        'asiento_conductor' => 'string',
        'conos_cunas' => 'string',
        'trinquetes_cadenas' => 'string',
        'ruidos_motor' => 'string',
        'detalle_mal_estado' => 'string'
    ];

    public static array $rules = [
        'nombre_conductor' => 'required',
        'patente' => 'required',
        'luces_altas_bajas' => 'in:buen_estado,mal_estado',
        'intermitentes' => 'in:buen_estado,mal_estado',
        'luces_posicion' => 'in:buen_estado,mal_estado',
        'luces_freno' => 'in:buen_estado,mal_estado',
        'sistema_frenos' => 'in:buen_estado,mal_estado',
        'estado_espejos' => 'in:buen_estado,mal_estado',
        'parabrisas' => 'in:buen_estado,mal_estado',
        'calefaccion_ac' => 'in:buen_estado,mal_estado',
        'estado_tablones' => 'in:buen_estado,mal_estado',
        'acumulacion_aire' => 'in:buen_estado,mal_estado',
        'extintor' => 'in:vigente,vencido',
        'neumatico_repuesto' => 'in:buen_estado,mal_estado',
        'asiento_conductor' => 'in:buen_estado,mal_estado',
        'conos_cunas' => 'in:buen_estado,mal_estado',
        'trinquetes_cadenas' => 'in:buen_estado,mal_estado'
    ];

    
}
