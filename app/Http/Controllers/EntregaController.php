<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entrega;
use App\Models\Ot;
use App\Models\Conductor;

class EntregaController extends Controller
{
    // Panel interno usa index/store/show bajo /operacion/entrega (ya definidos en web.php)
    // Las rutas públicas usan create/store/show (resource 'entregas')

    public function create(Request $request)
    {
        // Si te pasan ?ot=ID por la URL, lo puedes usar para prellenar

        $ots = Ot::with('cotizacion')->get();
        $conductores = Conductor::where('activo', true)->orderBy('nombre')->get();

        return view('entregas.create', compact('ots', 'conductores'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ot_id'            => ['required', 'integer'],
            'nombre_receptor'  => ['required', 'string', 'max:255'],
            'rut_receptor'     => ['nullable', 'string', 'max:50'],
            'telefono_receptor'=> ['nullable', 'string', 'max:50'],
            'correo_receptor'  => ['nullable', 'string', 'max:255'],
            'lugar_entrega'    => ['nullable', 'string', 'max:255'],
            'fecha_entrega'    => ['nullable', 'date'],
            'hora_entrega'     => ['nullable', 'string', 'max:20'],
            'numero_guia'      => ['nullable', 'string', 'max:50'],
            'numero_interno'   => ['nullable', 'string', 'max:50'],
            'conforme'         => ['nullable', 'boolean'],
            'observaciones'    => ['nullable', 'string'],
            'fotos'            => ['nullable', 'string'],
        ]);

        // Normalización de boolean
        $data['conforme'] = $request->has('conforme') ? (bool)$request->conforme : null;

        // Obtiene la OT seleccionada
        $ot = \App\Models\Ot::with('cotizacion')->findOrFail($request->ot_id);

        // Cliente desde Cotización
        $data['cliente'] = $ot->cotizacion->cliente ?? 'SIN CLIENTE';

        // Guardar nombre del conductor en la entrega (opcional)
        if ($request->filled('conductor_id')) {
            $data['conductor'] = \App\Models\Conductor::find($request->conductor_id)?->nombre;
        }

        Entrega::create($data);

        return view('entregas.success')
            ->with('success', 'Entrega registrada correctamente.');
    }

    public function show(Entrega $entrega)
    {
        return view('entregas.show', compact('entrega'));
    }
}
