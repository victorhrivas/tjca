<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChecklistCamion;

class ChecklistCamionController extends Controller
{
    public function create()
    {
        return view('checklist_camions.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre_conductor'   => ['required', 'string', 'max:255'],
            'patente'            => ['required', 'string', 'max:50'],
            'kilometraje'        => ['nullable', 'string', 'max:50'],

            'nivel_aceite'       => ['nullable', 'string', 'max:50'],
            'luces_altas_bajas'  => ['nullable', 'in:buen_estado,mal_estado'],
            'intermitentes'      => ['nullable', 'in:buen_estado,mal_estado'],
            'luces_posicion'     => ['nullable', 'in:buen_estado,mal_estado'],
            'luces_freno'        => ['nullable', 'in:buen_estado,mal_estado'],
            'estado_neumaticos'  => ['nullable', 'string', 'max:50'],
            'sistema_frenos'     => ['nullable', 'in:buen_estado,mal_estado'],
            'estado_espejos'     => ['nullable', 'in:buen_estado,mal_estado'],
            'parabrisas'         => ['nullable', 'in:buen_estado,mal_estado'],
            'calefaccion_ac'     => ['nullable', 'in:buen_estado,mal_estado'],
            'estado_tablones'    => ['nullable', 'in:buen_estado,mal_estado'],
            'acumulacion_aire'   => ['nullable', 'in:buen_estado,mal_estado'],
            'extintor'           => ['nullable', 'in:vigente,vencido'],
            'neumatico_repuesto' => ['nullable', 'in:buen_estado,mal_estado'],
            'asiento_conductor'  => ['nullable', 'in:buen_estado,mal_estado'],
            'conos_cunas'        => ['nullable', 'in:buen_estado,mal_estado'],
            'trinquetes_cadenas' => ['nullable', 'in:buen_estado,mal_estado'],
            'ruidos_motor'       => ['nullable', 'string', 'max:255'],
            'detalle_mal_estado' => ['nullable', 'string'],
        ]);

        $checklist = ChecklistCamion::create($data);

        return redirect()
            ->route('checklist-camions.show', $checklist->id)
            ->with('success', 'Checklist registrado correctamente.');
    }

    public function show(ChecklistCamion $checklist_camion)
    {
        return view('checklist_camions.show', ['checklist' => $checklist_camion]);
    }
}
