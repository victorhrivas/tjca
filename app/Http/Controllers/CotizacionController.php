<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCotizacionRequest;
use App\Http\Requests\UpdateCotizacionRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\CotizacionRepository;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Flash;
use App\Models\Ot;
use Carbon\Carbon;
use App\Models\Cotizacion;
use App\Models\Solicitud;
use App\Models\Cliente;

class CotizacionController extends AppBaseController
{
    /** @var CotizacionRepository $cotizacionRepository */
    private $cotizacionRepository;

    public function __construct(CotizacionRepository $cotizacionRepo)
    {
        $this->cotizacionRepository = $cotizacionRepo;
    }

    /**
     * Listado con filtros.
     */
    public function index(Request $request)
    {
        $clientes = Cliente::orderBy('razon_social')->pluck('razon_social', 'id');

        $query = Cotizacion::with(['solicitud.cliente', 'ot'])
            ->orderByDesc('id');

        // ---------------------------
        // Búsqueda de texto libre
        // ---------------------------
        if ($request->q) {
            $q = trim($request->q);

            $query->where(function ($w) use ($q) {
                // Si es número: buscar por id y monto exacto
                if (ctype_digit($q)) {
                    $w->orWhere('id', (int) $q)
                      ->orWhere('monto', (int) $q);
                }

                // Búsqueda parcial en monto (se castea a string)
                $w->orWhere('monto', 'like', "%$q%");

                // Por solicitud (origen/destino/notas)
                $w->orWhereHas('solicitud', function ($s) use ($q) {
                    $s->where('origen',  'like', "%$q%")
                      ->orWhere('destino','like', "%$q%")
                      ->orWhere('notas',  'like', "%$q%");
                });

                // Por cliente
                $w->orWhereHas('solicitud.cliente', function ($c) use ($q) {
                    $c->where('razon_social', 'like', "%$q%");
                });
            });
        }

        // ---------------------------
        // Filtro por cliente
        // ---------------------------
        if ($request->cliente_id) {
            $query->whereHas('solicitud', function ($s) use ($request) {
                $s->where('cliente_id', $request->cliente_id);
            });
        }

        // ---------------------------
        // Filtro por estado de cotización
        // ---------------------------
        if ($request->estado) {
            $query->where('estado', $request->estado);
        }

        // ---------------------------
        // Filtro por fecha de creación
        // ---------------------------
        if ($request->fecha) {
            $query->whereDate('created_at', $request->fecha);
        }

        // ---------------------------
        // Filtro por OT (con / sin)
        // ---------------------------
        if ($request->ot === 'con') {
            $query->whereHas('ot');
        } elseif ($request->ot === 'sin') {
            $query->whereDoesntHave('ot');
        }

        $cotizacions = $query->paginate(10)->appends($request->all());

        return view('cotizacions.index', compact('cotizacions', 'clientes'));
    }

    /**
     * Show the form for creating a new Cotizacion.
     */
    public function create()
    {
        $solicitudes = Solicitud::orderBy('id', 'desc')->get();
        return view('cotizacions.create', compact(
            'solicitudes'
        ));
    }

    /**
     * Store a newly created Cotizacion in storage.
     */
    public function store(CreateCotizacionRequest $request)
    {
        $input = $request->all();

        // Siempre el usuario logueado como dueño de la cotización
        $input['user_id'] = auth()->id();

        // Tomamos la solicitud relacionada
        $solicitud = Solicitud::with('cliente')->findOrFail($request->solicitud_id);

        // Asignar automáticamente el solicitante si no viene del formulario
        $input['solicitante'] = $input['solicitante']
            ?? $solicitud->solicitante
            ?? auth()->user()->name;

        // Asegurar cliente como string siempre
        $input['cliente'] = $request->input(
            'cliente',
            optional($solicitud->cliente)->razon_social
        );

        $cotizacion = $this->cotizacionRepository->create($input);

        Flash::success('Cotización se guardó correctamente.');

        return redirect(route('cotizacions.index'));
    }


    /**
     * Display the specified Cotizacion.
     */
    public function show($id)
    {
        $cotizacion = Cotizacion::with(['solicitud.cliente', 'ot'])->find($id);

        if (empty($cotizacion)) {
            Flash::error('Cotización no encontrada.');
            return redirect(route('cotizacions.index'));
        }

        return view('cotizacions.show')->with('cotizacion', $cotizacion);
    }

    /**
     * Show the form for editing the specified Cotizacion.
     */
    public function edit($id)
    {
        $cotizacion = $this->cotizacionRepository->find($id);

        if (empty($cotizacion)) {
            Flash::error('Cotización no encontrada.');

            return redirect(route('cotizacions.index'));
        }

        return view('cotizacions.edit')->with('cotizacion', $cotizacion);
    }

    /**
     * Update the specified Cotizacion in storage.
     */
    public function update($id, UpdateCotizacionRequest $request)
    {
        $cotizacion = $this->cotizacionRepository->find($id);

        if (empty($cotizacion)) {
            Flash::error('Cotización no encontrada.');

            return redirect(route('cotizacions.index'));
        }

        $this->cotizacionRepository->update($request->all(), $id);

        Flash::success('Cotización actualizada correctamente.');

        return redirect(route('cotizacions.index'));
    }

    /**
     * Remove the specified Cotizacion from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $cotizacion = $this->cotizacionRepository->find($id);

        if (empty($cotizacion)) {
            Flash::error('Cotización no encontrada.');

            return redirect(route('cotizacions.index'));
        }

        $this->cotizacionRepository->delete($id);

        Flash::success('Cotización eliminada correctamente.');

        return redirect(route('cotizacions.index'));
    }

    public function pdf($id)
    {
        $cotizacion = Cotizacion::with(['solicitud.cliente', 'ot', 'user'])
            ->findOrFail($id);

        $pdf = Pdf::loadView('cotizacions.pdf', [
            'cotizacion' => $cotizacion,
        ])->setPaper('A4', 'portrait');

        $fileName = 'cotizacion_' . $cotizacion->id . '.pdf';

        return $pdf->stream($fileName);
    }


    /**
     * Generar OT desde una cotización.
     */
    public function generarOt($id)
    {
        // Traemos la cotización con su cadena completa
        $cotizacion = Cotizacion::with(['solicitud.cliente', 'ot'])->find($id);

        if (!$cotizacion) {
            Flash::error('Cotización no encontrada.');
            return redirect()->route('cotizacions.index');
        }

        // Evitar duplicar OT
        if ($cotizacion->ot) {
            Flash::warning('Esta cotización ya tiene una OT asociada.');
            return redirect()->route('cotizacions.index');
        }

        // Solo 'pendiente' o 'enviada' pueden generar OT
        if (!in_array($cotizacion->estado, ['pendiente', 'enviada'])) {
            Flash::warning('Solo cotizaciones Pendientes o Enviadas pueden generar una OT.');
            return redirect()->route('cotizacions.index');
        }

        $solicitud = $cotizacion->solicitud;
        $cliente   = optional($solicitud)->cliente;

        // Fecha coherente para el servicio
        $fechaBase = $solicitud && $solicitud->created_at
            ? $solicitud->created_at->copy()->addDays(2)
            : Carbon::now();

        // Cambiar estado a aceptada
        $cotizacion->estado = 'aceptada';
        $cotizacion->save();

        // Generar folio usando la fecha de servicio
        $folio = Ot::generarFolioParaFecha($fechaBase);

        // Crear OT con folio incluido
        $ot = Ot::create([
            'folio'            => $folio,
            'cotizacion_id'    => $cotizacion->id,
            'equipo'           => $solicitud?->carga ?? 'Servicio de carga',
            'origen'           => $solicitud?->origen ?? null,
            'destino'          => $solicitud?->destino ?? null,
            'cliente'          => $cliente?->razon_social ?? 'Cliente sin nombre',
            'valor'            => $cotizacion->monto,
            'fecha'            => $fechaBase->toDateString(),
            'solicitante'      => $cliente?->razon_social ?? 'Sin solicitante',
            'conductor'        => null,
            'patente_camion'   => null,
            'estado'           => 'pendiente',
            'observaciones'    => 'OT generada automáticamente desde la cotización #'.$cotizacion->id,
        ]);

        Flash::success('OT generada correctamente. La cotización pasó a estado "aceptada".');

        return redirect()->route('ots.index');
    }

}
