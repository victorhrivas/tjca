<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChecklistCamion;

class ChecklistCamionController extends Controller
{
    /**
     * Listado (panel interno /operacion/checklist).
     */
    public function index()
    {
        $checklistCamions = ChecklistCamion::orderBy('id', 'desc')->paginate(10);

        return view('checklist_camions.index', compact('checklistCamions'));
    }

    /**
     * Formulario público (resource 'checklist-camions') o interno si lo llamas.
     */
    public function create()
    {
        return view('checklist_camions.create');
    }

    /**
     * Guardar checklist.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre_conductor'   => ['required', 'string', 'max:255'],
            'patente'            => ['required', 'string', 'max:50'],
            'kilometraje'        => ['nullable', 'string', 'max:50'],

            'nivel_aceite'       => ['required', 'in:bajo,1,2,3,4,5,normal'],

            'luces_altas_bajas'  => ['required', 'in:buen_estado,mal_estado'],
            'intermitentes'      => ['required', 'in:buen_estado,mal_estado'],
            'luces_posicion'     => ['required', 'in:buen_estado,mal_estado'],
            'luces_freno'        => ['required', 'in:buen_estado,mal_estado'],
            'estado_neumaticos'  => ['required', 'string', 'max:255'],
            'sistema_frenos'     => ['required', 'in:buen_estado,mal_estado'],
            'estado_espejos'     => ['required', 'in:buen_estado,mal_estado'],
            'parabrisas'         => ['required', 'in:buen_estado,mal_estado'],
            'calefaccion_ac'     => ['required', 'in:buen_estado,mal_estado'],
            'estado_tablones'    => ['nullable', 'in:buen_estado,mal_estado'],
            'acumulacion_aire'   => ['required', 'in:buen_estado,mal_estado'],
            'extintor'           => ['required', 'in:vigente,vencido'],
            'neumatico_repuesto' => ['required', 'in:buen_estado,mal_estado'],
            'asiento_conductor'  => ['required', 'in:buen_estado,mal_estado'],
            'conos_cunas'        => ['required', 'in:buen_estado,mal_estado'],
            'trinquetes_cadenas' => ['required', 'in:buen_estado,mal_estado'],

            'ruidos_motor'       => ['nullable', 'string', 'max:255'],
            'detalle_mal_estado' => ['nullable', 'string'],
        ]);

        // Se setea automáticamente en el servidor
        $data['fecha_checklist'] = now();

        $checklist = ChecklistCamion::create($data);

        return view('checklist_camions.success')->with([
            'success'   => 'Checklist registrada correctamente.',
            'checklist' => $checklist,
        ]);
    }

    /**
     * Detalle (sirve tanto para /operacion/checklist/{id} como /checklist-camions/{id}).
     */
    public function show($id)
    {
        $checklist = ChecklistCamion::findOrFail($id);

        return view('checklist_camions.show', ['checklist' => $checklist]);
    }

    /**
     * Editar (panel interno).
     */
    public function edit($id)
    {
        $checklist = ChecklistCamion::findOrFail($id);

        return view('checklist_camions.edit', compact('checklist'));
    }

    /**
     * Actualizar (panel interno).
     */
    public function update($id, Request $request)
    {
        $checklist = ChecklistCamion::findOrFail($id);

        $data = $request->validate([
            'nombre_conductor'   => ['required', 'string', 'max:255'],
            'patente'            => ['required', 'string', 'max:50'],
            'kilometraje'        => ['nullable', 'string', 'max:50'],

            'nivel_aceite'       => ['required', 'in:bajo,1,2,3,4,5,normal'],

            'luces_altas_bajas'  => ['required', 'in:buen_estado,mal_estado'],
            'intermitentes'      => ['required', 'in:buen_estado,mal_estado'],
            'luces_posicion'     => ['required', 'in:buen_estado,mal_estado'],
            'luces_freno'        => ['required', 'in:buen_estado,mal_estado'],
            'estado_neumaticos'  => ['required', 'string', 'max:255'],
            'sistema_frenos'     => ['required', 'in:buen_estado,mal_estado'],
            'estado_espejos'     => ['required', 'in:buen_estado,mal_estado'],
            'parabrisas'         => ['required', 'in:buen_estado,mal_estado'],
            'calefaccion_ac'     => ['required', 'in:buen_estado,mal_estado'],
            'estado_tablones'    => ['nullable', 'in:buen_estado,mal_estado'],
            'acumulacion_aire'   => ['required', 'in:buen_estado,mal_estado'],
            'extintor'           => ['required', 'in:vigente,vencido'],
            'neumatico_repuesto' => ['required', 'in:buen_estado,mal_estado'],
            'asiento_conductor'  => ['required', 'in:buen_estado,mal_estado'],
            'conos_cunas'        => ['required', 'in:buen_estado,mal_estado'],
            'trinquetes_cadenas' => ['required', 'in:buen_estado,mal_estado'],

            'ruidos_motor'       => ['nullable', 'string', 'max:255'],
            'detalle_mal_estado' => ['nullable', 'string'],
        ]);

        $checklist->update($data);

        return redirect()
            ->route('operacion.checklist.index')
            ->with('success', 'Checklist actualizado correctamente.');
    }

    /**
     * Eliminar (panel interno).
     */
    public function destroy($id)
    {
        $checklist = ChecklistCamion::findOrFail($id);
        $checklist->delete();

        return redirect()
            ->route('operacion.checklist.index')
            ->with('success', 'Checklist eliminado correctamente.');
    }
}
