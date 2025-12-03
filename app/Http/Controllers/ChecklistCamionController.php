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
        $checklists = ChecklistCamion::orderBy('id', 'desc')->paginate(10);

        return view('checklist_camions.index', compact('checklists'));
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

        // Redirigimos al show "público"; si quieres usar el del panel, cambia a operacion.checklist.show
        return redirect()
            ->route('checklist-camions.show', $checklist->id)
            ->with('success', 'Checklist registrado correctamente.');
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
