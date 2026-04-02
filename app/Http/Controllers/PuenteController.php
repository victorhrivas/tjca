<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreatePuenteRequest;
use App\Http\Requests\UpdatePuenteRequest;
use App\Repositories\PuenteRepository;
use Illuminate\Http\Request;
use App\Models\Puente;
use App\Models\Ot;
use App\Models\Conductor;
use Flash;

class PuenteController extends AppBaseController
{
    /** @var PuenteRepository */
    private $puenteRepository;

    public function __construct(PuenteRepository $puenteRepo)
    {
        $this->puenteRepository = $puenteRepo;
    }

    private function authorizePuente(): void
    {
        abort_unless(
            auth()->check() && auth()->user()->hasAnyRole(['superAdmin', 'administrador', 'desarrollador']),
            403,
            'No autorizado para usar puentes.'
        );
    }

    public function index(Request $request)
    {
        $this->authorizePuente();

        $puentes = Puente::with([
                'ot',
                'otVehiculo',
            ])
            ->orderByDesc('id')
            ->paginate(10);

        return view('puentes.index', compact('puentes'));
    }

    public function create(Request $request)
    {
        $this->authorizePuente();

        $ots = Ot::with([
                'cotizacion.solicitud.cliente',
                'vehiculos' => fn ($q) => $q->orderBy('orden'),
            ])
            ->orderByDesc('id')
            ->get()
            ->map(function ($ot) {
                $cliente = optional(optional(optional($ot->cotizacion)->solicitud)->cliente);

                if (is_null($ot->cliente)) {
                    $ot->cliente = $cliente?->razon_social;
                }

                if (is_null($ot->origen)) {
                    $ot->origen = optional($ot->cotizacion)->origen;
                }

                if (is_null($ot->destino)) {
                    $ot->destino = optional($ot->cotizacion)->destino;
                }

                return $ot;
            });

        $conductores = Conductor::where('activo', true)
            ->orderBy('nombre')
            ->pluck('nombre', 'nombre');

        $ot = null;

        if ($request->filled('ot_id')) {
            $ot = $ots->firstWhere('id', (int) $request->get('ot_id'));
        }

        return view('puentes.create', compact('ots', 'ot', 'conductores'));
    }

    public function store(CreatePuenteRequest $request)
    {
        $this->authorizePuente();

        $data = $request->validate([
            'ot_id'                  => ['required', 'integer', 'exists:ots,id'],
            'ot_vehiculo_id'         => ['nullable', 'integer', 'exists:ot_vehiculos,id'],
            'fase'                   => ['required', 'in:general,inicio_carga,en_transito,entrega'],
            'motivo'                 => ['required', 'in:cambio_carga,cambio_conductor,cambio_camion,accidente,incidencia_operativa,otro'],
            'detalle'                => ['nullable', 'string'],
            'notificar_cliente'      => ['nullable', 'boolean'],
            'nuevo_conductor'        => ['nullable', 'string', 'max:255'],
            'nueva_patente_camion'   => ['nullable', 'string', 'max:50'],
            'nueva_patente_remolque' => ['nullable', 'string', 'max:50'],
        ]);

        $data['notificar_cliente'] = $request->has('notificar_cliente')
            ? (bool) $request->input('notificar_cliente')
            : false;

        $ot = Ot::with('vehiculos')->findOrFail($data['ot_id']);

        if ($ot->vehiculos->count() > 0 && empty($data['ot_vehiculo_id'])) {
            return back()->withInput()->withErrors([
                'ot_vehiculo_id' => 'Debes seleccionar un vehículo para esta OT.',
            ]);
        }

        if (!empty($data['ot_vehiculo_id'])) {
            $pertenece = $ot->vehiculos->contains('id', (int) $data['ot_vehiculo_id']);

            if (!$pertenece) {
                return back()->withInput()->withErrors([
                    'ot_vehiculo_id' => 'El vehículo seleccionado no pertenece a la OT.',
                ]);
            }
        }

        $data['reportado_por'] = auth()->user()->name;

        $puente = $this->puenteRepository->create($data);

        if (!empty($data['ot_vehiculo_id'])) {
            $vehiculo = $ot->vehiculos->firstWhere('id', (int) $data['ot_vehiculo_id']);

            if ($vehiculo) {
                if ($data['motivo'] === 'cambio_conductor' && !empty($data['nuevo_conductor'])) {
                    $vehiculo->conductor = $data['nuevo_conductor'];
                    $vehiculo->save();
                }

                if ($data['motivo'] === 'cambio_camion') {
                    if (!empty($data['nueva_patente_camion'])) {
                        $vehiculo->patente_camion = strtoupper(trim($data['nueva_patente_camion']));
                    }

                    $vehiculo->patente_remolque = !empty($data['nueva_patente_remolque'])
                        ? strtoupper(trim($data['nueva_patente_remolque']))
                        : null;

                    $vehiculo->save();
                }
            }
        }

        $ot->estado = 'con_incidencia';
        $ot->save();

        Flash::success('Puente registrado correctamente.');

        return redirect(route('puentes.show', $puente->id));
    }

    public function show($id)
    {
        $this->authorizePuente();

        $puente = Puente::with([
            'ot.cotizacion.solicitud.cliente',
            'otVehiculo',
        ])->find($id);

        if (empty($puente)) {
            Flash::error('Puente no encontrado.');
            return redirect(route('puentes.index'));
        }

        return view('puentes.show', compact('puente'));
    }

    public function edit($id)
    {
        $this->authorizePuente();

        $puente = Puente::with(['ot', 'otVehiculo'])->find($id);

        if (empty($puente)) {
            Flash::error('Puente no encontrado.');
            return redirect(route('puentes.index'));
        }

        $ots = Ot::with([
                'cotizacion.solicitud.cliente',
                'vehiculos' => fn ($q) => $q->orderBy('orden'),
            ])
            ->orderByDesc('id')
            ->get()
            ->map(function ($ot) {
                $cliente = optional(optional(optional($ot->cotizacion)->solicitud)->cliente);

                if (is_null($ot->cliente)) {
                    $ot->cliente = $cliente?->razon_social;
                }

                if (is_null($ot->origen)) {
                    $ot->origen = optional($ot->cotizacion)->origen;
                }

                if (is_null($ot->destino)) {
                    $ot->destino = optional($ot->cotizacion)->destino;
                }

                return $ot;
            });

        $conductores = Conductor::where('activo', true)
            ->orderBy('nombre')
            ->pluck('nombre', 'nombre');

        $ot = $ots->firstWhere('id', $puente->ot_id);

        return view('puentes.edit', compact('puente', 'ot', 'ots', 'conductores'));
    }

    public function update($id, UpdatePuenteRequest $request)
    {
        $this->authorizePuente();

        $puente = Puente::find($id);

        if (empty($puente)) {
            Flash::error('Puente no encontrado.');
            return redirect(route('puentes.index'));
        }

        $data = $request->validate([
            'ot_id'                  => ['required', 'integer', 'exists:ots,id'],
            'ot_vehiculo_id'         => ['nullable', 'integer', 'exists:ot_vehiculos,id'],
            'fase'                   => ['required', 'in:general,inicio_carga,en_transito,entrega'],
            'motivo'                 => ['required', 'in:cambio_carga,cambio_conductor,cambio_camion,accidente,incidencia_operativa,otro'],
            'detalle'                => ['nullable', 'string'],
            'notificar_cliente'      => ['nullable', 'boolean'],
            'nuevo_conductor'        => ['nullable', 'string', 'max:255'],
            'nueva_patente_camion'   => ['nullable', 'string', 'max:50'],
            'nueva_patente_remolque' => ['nullable', 'string', 'max:50'],
        ]);

        $data['notificar_cliente'] = $request->has('notificar_cliente')
            ? (bool) $request->input('notificar_cliente')
            : false;

        $ot = Ot::with('vehiculos')->findOrFail($data['ot_id']);

        if ($ot->vehiculos->count() > 0 && empty($data['ot_vehiculo_id'])) {
            return back()->withInput()->withErrors([
                'ot_vehiculo_id' => 'Debes seleccionar un vehículo para esta OT.',
            ]);
        }

        if (!empty($data['ot_vehiculo_id'])) {
            $pertenece = $ot->vehiculos->contains('id', (int) $data['ot_vehiculo_id']);

            if (!$pertenece) {
                return back()->withInput()->withErrors([
                    'ot_vehiculo_id' => 'El vehículo seleccionado no pertenece a la OT.',
                ]);
            }
        }

        $this->puenteRepository->update($data, $id);

        if (!empty($data['ot_vehiculo_id'])) {
            $vehiculo = $ot->vehiculos->firstWhere('id', (int) $data['ot_vehiculo_id']);

            if ($vehiculo) {
                if ($data['motivo'] === 'cambio_conductor' && !empty($data['nuevo_conductor'])) {
                    $vehiculo->conductor = $data['nuevo_conductor'];
                    $vehiculo->save();
                }

                if ($data['motivo'] === 'cambio_camion') {
                    if (!empty($data['nueva_patente_camion'])) {
                        $vehiculo->patente_camion = strtoupper(trim($data['nueva_patente_camion']));
                    }

                    $vehiculo->patente_remolque = !empty($data['nueva_patente_remolque'])
                        ? strtoupper(trim($data['nueva_patente_remolque']))
                        : null;

                    $vehiculo->save();
                }
            }
        }

        Flash::success('Puente actualizado correctamente.');

        return redirect(route('puentes.index'));
    }

    public function destroy($id)
    {
        $this->authorizePuente();

        $puente = $this->puenteRepository->find($id);

        if (empty($puente)) {
            Flash::error('Puente no encontrado.');
            return redirect(route('puentes.index'));
        }

        $this->puenteRepository->delete($id);

        Flash::success('Puente eliminado correctamente.');

        return redirect(route('puentes.index'));
    }
}