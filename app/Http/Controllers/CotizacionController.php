<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCotizacionRequest;
use App\Http\Requests\UpdateCotizacionRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\CotizacionRepository;
use App\Models\CotizacionCarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\CotizacionPdfMail;
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

        $query = Cotizacion::with(['solicitud.cliente', 'ot', 'cargas'])
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
        DB::transaction(function () use ($request) {

            $input = $request->except(['cargas', 'monto']);
            $input['user_id'] = $request->input('user_id', auth()->id());

            $solicitud = Solicitud::with('cliente')->findOrFail($request->solicitud_id);

            if ($solicitud->estado !== 'pendiente') {
                throw new \Exception('Solicitud no pendiente');
            }

            $input['solicitante'] = $input['solicitante']
                ?? $solicitud->solicitante
                ?? auth()->user()->name;

            $input['cliente'] = $request->input(
                'cliente',
                optional($solicitud->cliente)->razon_social
            );

            $input['monto'] = 0;

            $cotizacion = $this->cotizacionRepository->create($input);

            $total = 0;

            foreach ($request->input('cargas', []) as $row) {
                $cantidad = (float) $row['cantidad'];
                $unit     = (int) $row['precio_unitario'];
                $subtotal = (int) round($cantidad * $unit);

                $cotizacion->cargas()->create([
                    'descripcion'     => $row['descripcion'],
                    'cantidad'        => $cantidad,
                    'precio_unitario' => $unit,
                    'subtotal'        => $subtotal,
                ]);

                $total += $subtotal;
            }

            $cotizacion->update(['monto' => $total]);
            $solicitud->update(['estado' => 'aprobada']);
        });

        Flash::success('Cotización guardada y solicitud aprobada correctamente.');
        return redirect(route('cotizacions.index'));
    }

    /**
     * Display the specified Cotizacion.
     */
    public function show($id)
    {
        $cotizacion = Cotizacion::with(['solicitud.cliente', 'ot', 'cargas'])->find($id);

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
        $cotizacion = Cotizacion::with('cargas')->find($id);

        if (!$cotizacion) {
            Flash::error('Cotización no encontrada.');
            return redirect(route('cotizacions.index'));
        }

        // actualiza cabecera (no monto)
        $data = $request->except(['monto', 'cargas']);

        $this->cotizacionRepository->update($data, $id);

        // sincronizar cargas
        $enviadas = collect($request->input('cargas', []));

        $idsEnviados = $enviadas->pluck('id')->filter()->map(fn($v) => (int)$v)->values();

        // eliminar las que ya no vienen
        $cotizacion->cargas()->whereNotIn('id', $idsEnviados)->delete();

        // upsert manual
        $total = 0;

        foreach ($enviadas as $row) {
            $cantidad = (float) $row['cantidad'];
            $unit     = (int) $row['precio_unitario'];
            $subtotal = (int) round($cantidad * $unit);

            if (!empty($row['id'])) {
                $item = $cotizacion->cargas()->where('id', $row['id'])->first();
                if ($item) {
                    $item->update([
                        'descripcion'     => $row['descripcion'],
                        'cantidad'        => $cantidad,
                        'precio_unitario' => $unit,
                        'subtotal'        => $subtotal,
                    ]);
                }
            } else {
                $cotizacion->cargas()->create([
                    'descripcion'     => $row['descripcion'],
                    'cantidad'        => $cantidad,
                    'precio_unitario' => $unit,
                    'subtotal'        => $subtotal,
                ]);
            }

            $total += $subtotal;
        }

        $cotizacion->update(['monto' => $total]);

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

    public function sendPdf(Request $request, $id)
    {
        $cotizacion = Cotizacion::with(['solicitud.cliente', 'ot', 'user', 'cargas'])
            ->findOrFail($id);

        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Generar PDF (binario)
        $pdf = Pdf::loadView('cotizacions.pdf', [
            'cotizacion' => $cotizacion,
        ])->setPaper('A4', 'portrait');

        $fileName = 'cotizacion_' . $cotizacion->id . '.pdf';
        $pdfBinary = $pdf->output();

        // Enviar correo con adjunto
        Mail::to($request->input('email'))
            ->send(new CotizacionPdfMail($cotizacion, $pdfBinary, $fileName));

        // 👉 CAMBIAR ESTADO A ENVIADA (solo si no lo está)
        if ($cotizacion->estado !== 'enviada') {
            $cotizacion->update([
                'estado' => 'enviada',
            ]);
        }

        // Responder con URL para descargar/abrir el PDF
        return response()->json([
            'ok' => true,
            'download_url' => route('cotizacions.pdf', $cotizacion->id),
        ]);
    }



    /**
     * Generar OT desde una cotización.
     */
public function generarOt($id)
{
    $cotizacion = Cotizacion::with(['solicitud.cliente', 'ot', 'cargas'])->find($id);

    if (! $cotizacion) {
        Flash::error('Cotización no encontrada.');
        return redirect()->route('cotizacions.index');
    }

    if ($cotizacion->ot) {
        Flash::warning('Esta cotización ya tiene una OT asociada.');
        return redirect()->route('cotizacions.index');
    }

    if (! in_array($cotizacion->estado, ['enviada'], true)) {
        Flash::warning('Solo cotizaciones "Enviadas" pueden generar una OT.');
        return redirect()->route('cotizacions.index');
    }

    try {
        DB::transaction(function () use ($cotizacion) {

            // Lock de la cotización para evitar doble click / requests paralelas
            $cotizacion = Cotizacion::whereKey($cotizacion->id)
                ->lockForUpdate()
                ->with(['solicitud.cliente', 'ot', 'cargas'])
                ->first();

            if (! $cotizacion) {
                throw new \RuntimeException('Cotización no encontrada (lock).');
            }

            if ($cotizacion->ot) {
                return; // otro request ya la creó
            }

            $solicitud = $cotizacion->solicitud;
            $clienteRel = optional($solicitud)->cliente;

            $fechaBase = ($solicitud && $solicitud->created_at)
                ? $solicitud->created_at->copy()->addDays(2)
                : Carbon::now();

            $equipo = $cotizacion->cargas->isNotEmpty()
                ? $cotizacion->cargas->pluck('descripcion')->filter()->implode(', ')
                : ($cotizacion->carga ?? 'Servicio de transporte');

            $clienteNombre = $cotizacion->cliente
                ?? optional($clienteRel)->razon_social
                ?? 'Cliente sin nombre';

            $origen  = $cotizacion->origen  ?? optional($solicitud)->origen  ?? '-';
            $destino = $cotizacion->destino ?? optional($solicitud)->destino ?? '-';

            $solicitanteNombre = $cotizacion->solicitante
                ?? optional($solicitud)->solicitante
                ?? auth()->user()->name;

            // ✅ folio atómico (lockForUpdate en la query del modelo)
            $folio = Ot::generarFolioParaFecha($fechaBase);

            Ot::create([
                'folio'            => $folio,
                'cotizacion_id'    => $cotizacion->id,
                'equipo'           => $equipo,
                'origen'           => $origen,
                'destino'          => $destino,
                'cliente'          => $clienteNombre,
                'valor'            => (int)($cotizacion->monto ?? 0),
                'fecha'            => $fechaBase->toDateString(),
                'solicitante'      => $solicitanteNombre,
                'estado'           => 'pendiente',
                'observaciones'    => 'OT generada automáticamente desde la cotización #'.$cotizacion->id,
            ]);

            $cotizacion->update(['estado' => 'aceptada']);
        });

        Flash::success('OT generada correctamente. La cotización pasó a estado "aceptada".');
        return redirect()->route('ots.index');

    } catch (\Throwable $e) {
        report($e);
        Flash::error('No se pudo generar la OT. Revisa el log para ver el detalle.');
        return redirect()->route('cotizacions.index');
    }
}



}
