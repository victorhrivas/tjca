<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOtRequest;
use App\Http\Requests\UpdateOtRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\OtRepository;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Conductor;
use Carbon\Carbon;
use App\Models\Ot;
use Flash;

class OtController extends AppBaseController
{
    /** @var OtRepository $otRepository */
    private $otRepository;

    public function __construct(OtRepository $otRepo)
    {
        $this->otRepository = $otRepo;
    }

    /**
     * Normaliza vehículos recibidos desde la vista.
     *
     * Espera por fila:
     * - tipo_conductor: interno|externo
     * - conductor: select interno
     * - conductor_externo: texto libre externo
     * - patente_camion
     * - patente_remolque
     */
    private function normalizarVehiculos(array $vehiculosInput, ?string $trasladoOt = null)
    {
        $vehiculos = collect($vehiculosInput)
            ->map(function ($v) use ($trasladoOt) {
                $tipo = isset($v['tipo_conductor']) ? trim((string) $v['tipo_conductor']) : '';

                if (!in_array($tipo, ['interno', 'externo'], true)) {
                    if ($trasladoOt === 'externo') {
                        $tipo = 'externo';
                    } elseif ($trasladoOt === 'interno') {
                        $tipo = 'interno';
                    } else {
                        $tipo = 'interno';
                    }
                }

                $conductorInterno = isset($v['conductor']) ? trim((string) $v['conductor']) : '';
                $conductorExterno = isset($v['conductor_externo']) ? trim((string) $v['conductor_externo']) : '';

                $conductorFinal = $tipo === 'externo'
                    ? $conductorExterno
                    : $conductorInterno;

                $patenteCamion = isset($v['patente_camion']) ? strtoupper(trim((string) $v['patente_camion'])) : '';
                $patenteRemolque = isset($v['patente_remolque']) ? strtoupper(trim((string) $v['patente_remolque'])) : '';

                return [
                    'tipo_conductor'   => $tipo,
                    'conductor'        => $conductorFinal !== '' ? $conductorFinal : null,
                    'patente_camion'   => $patenteCamion !== '' ? $patenteCamion : null,
                    'patente_remolque' => $patenteRemolque !== '' ? $patenteRemolque : null,
                ];
            })
            ->filter(function ($v) {
                return !empty($v['conductor'])
                    || !empty($v['patente_camion'])
                    || !empty($v['patente_remolque']);
            })
            ->values();

        if ($vehiculos->isEmpty()) {
            $vehiculos = collect([[
                'tipo_conductor'   => $trasladoOt === 'externo' ? 'externo' : 'interno',
                'conductor'        => null,
                'patente_camion'   => null,
                'patente_remolque' => null,
            ]]);
        }

        return $vehiculos;
    }

    /**
     * Sincroniza campos legacy de la tabla ots usando el vehículo principal.
     */
    private function sincronizarLegacyPrincipal(Ot $ot, $vehiculos): void
    {
        $principal = $vehiculos->first();

        $ot->update([
            'conductor'        => $principal['conductor'] ?? null,
            'patente_camion'   => $principal['patente_camion'] ?? null,
            'patente_remolque' => $principal['patente_remolque'] ?? null,
        ]);
    }

    /**
     * Display a listing of the Ot.
     */
    public function index(Request $request)
    {
        $query = Ot::with([
            'vehiculos',
            'cotizacion.solicitud.cliente',
            'inicioCargas.otVehiculo',
            'entregas.otVehiculo',
        ]);
        $user = auth()->user();

        if ($user->hasRole('chofer')) {
            $nombreUsuario = trim($user->name);

            $query->where(function ($sub) use ($nombreUsuario) {
                $sub->where('conductor', $nombreUsuario)
                    ->orWhereHas('vehiculos', function ($v) use ($nombreUsuario) {
                        $v->where('conductor', $nombreUsuario)
                          ->where(function ($q) {
                              $q->whereNull('tipo_conductor')
                                ->orWhere('tipo_conductor', 'interno');
                          });
                    });
            });
        }

        if ($request->filled('q')) {
            $q = trim($request->get('q'));

            $query->where(function ($sub) use ($q) {
                $sub->where('folio', $q)
                    ->orWhere('folio', 'like', "%{$q}%")
                    ->orWhere('id', 'like', "%{$q}%")
                    ->orWhere('cliente', 'like', "%{$q}%")
                    ->orWhere('origen', 'like', "%{$q}%")
                    ->orWhere('destino', 'like', "%{$q}%")
                    ->orWhere('equipo', 'like', "%{$q}%")
                    ->orWhere('conductor', 'like', "%{$q}%")
                    ->orWhere('patente_camion', 'like', "%{$q}%")
                    ->orWhereHas('vehiculos', function ($v) use ($q) {
                        $v->where('conductor', 'like', "%{$q}%")
                          ->orWhere('patente_camion', 'like', "%{$q}%")
                          ->orWhere('patente_remolque', 'like', "%{$q}%");
                    });
            });
        }

        if ($request->filled('cliente')) {
            $query->where('cliente', 'like', '%' . $request->cliente . '%');
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('fecha')) {
            $query->whereDate('fecha', $request->fecha);
        }

        if ($request->filled('conductor')) {
            $c = $request->conductor;

            $query->where(function ($sub) use ($c) {
                $sub->where('conductor', 'like', "%{$c}%")
                    ->orWhereHas('vehiculos', function ($v) use ($c) {
                        $v->where('conductor', 'like', "%{$c}%");
                    });
            });
        }

        if ($request->filled('patente')) {
            $p = $request->patente;

            $query->where(function ($sub) use ($p) {
                $sub->where('patente_camion', 'like', "%{$p}%")
                    ->orWhereHas('vehiculos', function ($v) use ($p) {
                        $v->where('patente_camion', 'like', "%{$p}%")
                          ->orWhere('patente_remolque', 'like', "%{$p}%");
                    });
            });
        }

        $ots = $query
            ->orderByDesc('id')
            ->paginate(15)
            ->appends($request->all());

        return view('ots.index', compact('ots'));
    }

    public function updateTraslado(Request $request, Ot $ot)
    {
        $request->validate([
            'traslado' => 'nullable|in:interno,externo,interno_externo',
        ]);

        $ot->traslado = $request->filled('traslado') ? $request->traslado : null;

        if (!in_array($ot->traslado, ['externo', 'interno_externo'])) {
            $ot->costo_ext = null;
        }

        $ot->save();

        return redirect()->back()->with('success', 'Traslado actualizado correctamente.');
    }

    public function updateCostoExt(Request $request, Ot $ot)
    {
        $request->validate([
            'costo_ext' => 'nullable|integer|min:0',
        ]);

        if (!in_array($ot->traslado, ['externo', 'interno_externo'])) {
            return redirect()->back()->with('error', 'Solo puedes editar costo_ext cuando el traslado es externo o interno/externo.');
        }

        $ot->costo_ext = $request->filled('costo_ext') ? (int) $request->costo_ext : null;
        $ot->save();

        return redirect()->back()->with('success', 'Costo externo actualizado correctamente.');
    }

    /**
     * Show the form for creating a new Ot.
     */
    public function create()
    {
        $conductores = Conductor::where('activo', true)
            ->orderBy('nombre')
            ->pluck('nombre', 'nombre');

        return view('ots.create', compact('conductores'));
    }

    /**
     * Genera y asigna el folio a una OT recién creada.
     */
    private function asignarFolio(Ot $ot): void
    {
        $fechaBase = $ot->fecha ? Carbon::parse($ot->fecha) : $ot->created_at;
        $periodo = $fechaBase->format('Ym');

        $cantidadMes = Ot::whereYear('created_at', $fechaBase->year)
            ->whereMonth('created_at', $fechaBase->month)
            ->count();

        $correlativo = str_pad($cantidadMes, 3, '0', STR_PAD_LEFT);

        $ot->folio = "{$periodo}/{$correlativo}";
        $ot->save();
    }

    public function seguimiento(Request $request)
    {
        $request->validate([
            'numero_ot' => 'required|string',
        ]);

        $folio = trim($request->numero_ot);

        $ot = Ot::with([
                'cotizacion.solicitud.cliente',
                'inicioCargas',
                'entregas',
            ])
            ->where('folio', $folio)
            ->first();

        if (!$ot) {
            return response()->json([
                'found'   => false,
                'message' => 'No se encontró una OT con ese folio.',
            ]);
        }

        $clienteNombre = optional(optional(optional($ot->cotizacion)->solicitud)->cliente)->razon_social
            ?? $ot->cliente
            ?? '-';

        $inicioCargaFotos = [];
        $inicio = $ot->inicioCargas->sortByDesc('id')->first();

        if ($inicio) {
            foreach (['foto_1', 'foto_2', 'foto_3'] as $campo) {
                $ruta = $inicio->{$campo} ?? null;
                if ($ruta) {
                    $inicioCargaFotos[] = Storage::url($ruta);
                }
            }
        }

        $entregaFotos = [];
        $entrega = $ot->entregas->sortByDesc('id')->first();

        if ($entrega) {
            foreach (['foto_1', 'foto_2', 'foto_3'] as $campo) {
                $ruta = $entrega->{$campo} ?? null;
                if ($ruta) {
                    $entregaFotos[] = Storage::url($ruta);
                }
            }
        }

        return response()->json([
            'found'             => true,
            'folio'             => $ot->folio,
            'estado'            => $ot->estado_label,
            'estado_raw'        => $ot->estado,
            'badge_class'       => $ot->estado_badge_class,
            'cliente'           => $clienteNombre,
            'origen'            => $ot->origen,
            'destino'           => $ot->destino,
            'conductor'         => $ot->conductor,
            'fecha'             => $ot->fecha ? \Carbon\Carbon::parse($ot->fecha)->format('d-m-Y') : null,
            'inicio_carga_fotos'=> $inicioCargaFotos,
            'entrega_fotos'     => $entregaFotos,
        ]);
    }

    /**
     * Store a newly created Ot in storage.
     */
    public function store(CreateOtRequest $request)
    {
        $vehiculosInput = $request->input('vehiculos', []);
        $input = $request->except('vehiculos');

        $input['estado'] = $input['estado'] ?? 'pendiente';

        $fechaBase = $request->filled('fecha')
            ? Carbon::parse($request->fecha, config('app.timezone'))
            : now(config('app.timezone'));

        $input['folio'] = Ot::generarFolioParaFecha($fechaBase);

        $ot = $this->otRepository->create($input);

        $vehiculos = $this->normalizarVehiculos(
            $vehiculosInput,
            $input['traslado'] ?? null
        );

        foreach ($vehiculos as $idx => $v) {
            $ot->vehiculos()->create([
                'tipo_conductor'   => $v['tipo_conductor'],
                'conductor'        => $v['conductor'],
                'patente_camion'   => $v['patente_camion'],
                'patente_remolque' => $v['patente_remolque'],
                'orden'            => $idx + 1,
                'rol'              => $idx === 0 ? 'principal' : null,
            ]);
        }

        $this->sincronizarLegacyPrincipal($ot, $vehiculos);

        Flash::success('OT se guardó correctamente.');
        return redirect(route('ots.index'));
    }

    public function actualizarTraslado(Request $request, Ot $ot)
    {
        $request->validate([
            'traslado' => 'nullable|in:interno,externo,interno_externo'
        ]);

        $data = [
            'traslado' => $request->traslado,
        ];

        if (!in_array($request->traslado, ['externo', 'interno_externo'], true)) {
            $data['costo_ext'] = null;
        }

        $ot->update($data);

        return back();
    }

    public function actualizarCostoExt(Request $request, Ot $ot)
    {
        $request->validate([
            'costo_ext' => 'nullable|integer|min:0',
        ]);

        if (!in_array($ot->traslado, ['externo', 'interno_externo'], true)) {
            return back()->with('error', 'Solo puedes ingresar costo externo cuando el traslado es EXT o INT/EXT.');
        }

        $ot->update([
            'costo_ext' => $request->filled('costo_ext') ? $request->costo_ext : null,
        ]);

        return back();
    }

    /**
     * Display the specified Ot.
     */
    public function show($id)
    {
        $ot = $this->otRepository->find($id);

        if (empty($ot)) {
            Flash::error('Ot not found');
            return redirect(route('ots.index'));
        }

        $ot->load([
            'cotizacion',
            'vehiculos',
            'inicioCargas.otVehiculo',
            'entregas.otVehiculo',
            'entregas.guias',
        ]);

        return view('ots.show')->with('ot', $ot);
    }

    public function pdf($id)
    {
        $ot = Ot::with([
            'cotizacion.cargas',
            'vehiculos',
        ])->findOrFail($id);

        $pdf = Pdf::loadView('ots.pdf', [
            'ot' => $ot,
        ])->setPaper('A4', 'portrait');

        $fileName = 'ot_' . $ot->id . '.pdf';

        return $pdf->stream($fileName);
    }

    /**
     * Show the form for editing the specified Ot.
     */
    public function edit($id)
    {
        $ot = $this->otRepository->find($id);

        if (empty($ot)) {
            Flash::error('OT no encontrada');
            return redirect(route('ots.index'));
        }

        $ot->load('vehiculos');

        $conductores = Conductor::where('activo', true)
            ->orderBy('nombre')
            ->pluck('nombre', 'nombre');

        return view('ots.edit', compact('ot', 'conductores'));
    }

    /**
     * Update the specified Ot in storage.
     */
    public function update($id, UpdateOtRequest $request)
    {
        $ot = $this->otRepository->find($id);

        if (empty($ot)) {
            Flash::error('Ot not found');
            return redirect(route('ots.index'));
        }

        $vehiculosInput = $request->input('vehiculos', []);
        $input = $request->except('vehiculos');

        $ot = $this->otRepository->update($input, $id);

        $vehiculos = $this->normalizarVehiculos(
            $vehiculosInput,
            $input['traslado'] ?? $ot->traslado ?? null
        );

        $ot->vehiculos()->delete();

        foreach ($vehiculos as $idx => $v) {
            $ot->vehiculos()->create([
                'tipo_conductor'   => $v['tipo_conductor'],
                'conductor'        => $v['conductor'],
                'patente_camion'   => $v['patente_camion'],
                'patente_remolque' => $v['patente_remolque'],
                'orden'            => $idx + 1,
                'rol'              => $idx === 0 ? 'principal' : null,
            ]);
        }

        $this->sincronizarLegacyPrincipal($ot, $vehiculos);

        Flash::success('Ot Actualizada Correctamente.');
        return redirect(route('ots.index'));
    }

    public function updateEstado(Request $request, Ot $ot)
    {
        $request->validate([
            'estado' => 'required|in:pendiente,inicio_carga,en_transito,entregada,con_incidencia',
        ]);

        $ot->estado = $request->estado;
        $ot->save();

        return redirect()
            ->route('ots.index')
            ->with('success', "Estado de la OT #{$ot->id} actualizado a {$ot->estado_label}.");
    }

    /**
     * Remove the specified Ot from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $ot = $this->otRepository->find($id);

        if (empty($ot)) {
            Flash::error('Ot not found');
            return redirect(route('ots.index'));
        }

        $this->otRepository->delete($id);

        Flash::success('Ot deleted successfully.');

        return redirect(route('ots.index'));
    }
}