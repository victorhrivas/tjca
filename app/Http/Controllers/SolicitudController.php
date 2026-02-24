<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSolicitudRequest;
use App\Http\Requests\UpdateSolicitudRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\SolicitudRepository;
use App\Models\Cliente;
use App\Models\Cotizacion;
use Illuminate\Http\Request;
use Flash;

class SolicitudController extends AppBaseController
{
    /** @var SolicitudRepository $solicitudRepository*/
    private $solicitudRepository;

    public function __construct(SolicitudRepository $solicitudRepo)
    {
        $this->solicitudRepository = $solicitudRepo;
    }

    /**
     * Display a listing of the Solicitud.
     */
    public function index(Request $request)
    {
        $clientes = \App\Models\Cliente::orderBy('razon_social')->pluck('razon_social', 'id');

        $query = \App\Models\Solicitud::with('cliente')->orderBy('id', 'desc');

        // Texto libre
        if ($request->q) {
            $q = $request->q;
            $query->where(function($w) use ($q) {
                $w->where('origen', 'like', "%$q%")
                ->orWhere('destino', 'like', "%$q%")
                ->orWhere('notas', 'like', "%$q%")
                ->orWhere('carga', 'like', "%$q%")
                ->orWhere('canal', 'like', "%$q%")
                ->orWhereHas('cliente', function($c) use ($q) {
                    $c->where('razon_social', 'like', "%$q%");
                });

                if (ctype_digit($q)) {
                    $w->orWhere('id', $q);
                }
            });
        }

        // Filtro por cliente
        if ($request->cliente_id) {
            $query->where('cliente_id', $request->cliente_id);
        }

        // Filtro por estado
        if ($request->estado) {
            $query->where('estado', $request->estado);
        }

        // Filtro por fecha exacta de creación
        if ($request->fecha) {
            $query->whereDate('created_at', $request->fecha);
        }

        // Paginación con filtros persistentes
        $solicituds = $query->paginate(10)->appends($request->all());

        return view('solicituds.index', compact('solicituds', 'clientes'));
    }


    /**
     * Show the form for creating a new Solicitud.
     */
    public function create()
    {
        $clientes = Cliente::orderBy('razon_social')->pluck('razon_social', 'id');
        return view('solicituds.create', compact('clientes'));
    }

    /**
     * Store a newly created Solicitud in storage.
     */
    public function store(CreateSolicitudRequest $request)
    {
        $input = $request->all();

        $input['solicitante'] = $input['solicitante'] ?? auth()->user()->name;

        $cargas = $request->input('cargas', []);

        // compatibilidad: solicituds.carga es NOT NULL en tu tabla
        $input['carga'] = collect($cargas)->pluck('descripcion')->filter()->take(3)->implode(' | ');
        if (trim($input['carga']) === '') {
            $input['carga'] = 'Servicio';
        }

        unset($input['cargas']);

        $solicitud = $this->solicitudRepository->create($input);

        foreach ($cargas as $row) {
            $cantidad = (float) ($row['cantidad'] ?? 0);
            $unit     = (int) ($row['precio_unitario'] ?? 0);
            $subtotal = (int) round($cantidad * $unit);

            $solicitud->cargas()->create([
                'descripcion'     => $row['descripcion'],
                'cantidad'        => $cantidad,
                'precio_unitario' => $unit,
                'subtotal'        => $subtotal,
            ]);
        }

        Flash::success('Solicitud se guardó correctamente.');
        return redirect(route('solicituds.index'));
    }



    /**
     * Display the specified Solicitud.
     */
    public function show($id)
    {
        $solicitud = \App\Models\Solicitud::with(['cliente','cargas'])->find($id);

        if (empty($solicitud)) {
            Flash::error('Solicitud not found');

            return redirect(route('solicituds.index'));
        }

        return view('solicituds.show')->with('solicitud', $solicitud);
    }

    /**
     * Show the form for editing the specified Solicitud.
     */
    public function edit($id)
    {
        $solicitud = $this->solicitudRepository->find($id);
        $clientes = Cliente::orderBy('razon_social')->pluck('razon_social', 'id');

        if (empty($solicitud)) {
            Flash::error('Solicitud not found');
            return redirect(route('solicituds.index'));
        }

        return view('solicituds.edit', compact('solicitud', 'clientes'));
    }

    /**
     * Update the specified Solicitud in storage.
     */
    public function update($id, UpdateSolicitudRequest $request)
    {
        $solicitud = \App\Models\Solicitud::with('cargas')->find($id);

        if (!$solicitud) {
            Flash::error('Solicitud not found');
            return redirect(route('solicituds.index'));
        }

        $data = $request->except(['cargas']);
        $cargas = collect($request->input('cargas', []));

        // compatibilidad con solicituds.carga NOT NULL
        $data['carga'] = $cargas->pluck('descripcion')->filter()->take(3)->implode(' | ');
        if (trim($data['carga']) === '') {
            $data['carga'] = 'Servicio';
        }

        $this->solicitudRepository->update($data, $id);

        // sync cargas
        $idsEnviados = $cargas->pluck('id')->filter()->map(fn($v) => (int)$v)->values();
        $solicitud->cargas()->whereNotIn('id', $idsEnviados)->delete();

        foreach ($cargas as $row) {
            $cantidad = (float) ($row['cantidad'] ?? 0);
            $unit     = (int) ($row['precio_unitario'] ?? 0);
            $subtotal = (int) round($cantidad * $unit);

            if (!empty($row['id'])) {
                $item = $solicitud->cargas()->where('id', (int)$row['id'])->first();
                if ($item) {
                    $item->update([
                        'descripcion'     => $row['descripcion'],
                        'cantidad'        => $cantidad,
                        'precio_unitario' => $unit,
                        'subtotal'        => $subtotal,
                    ]);
                }
            } else {
                $solicitud->cargas()->create([
                    'descripcion'     => $row['descripcion'],
                    'cantidad'        => $cantidad,
                    'precio_unitario' => $unit,
                    'subtotal'        => $subtotal,
                ]);
            }
        }

        Flash::success('Solicitud actualizada correctamente.');
        return redirect(route('solicituds.index'));
    }


    /**
     * Remove the specified Solicitud from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $solicitud = $this->solicitudRepository->find($id);

        if (empty($solicitud)) {
            Flash::error('Solicitud not found');

            return redirect(route('solicituds.index'));
        }

        $this->solicitudRepository->delete($id);

        Flash::success('Solicitud deleted successfully.');

        return redirect(route('solicituds.index'));
    }

    public function select(\Illuminate\Http\Request $request)
    {
        $q = trim($request->get('q', ''));

        // intento seguro de parsear fecha
        $fecha = null;
        foreach (['d/m/Y','d-m-Y','Y-m-d'] as $fmt) {
            try {
                $tmp = \Carbon\Carbon::createFromFormat($fmt, $q);
                if ($tmp !== false) { $fecha = $tmp->format('Y-m-d'); break; }
            } catch (\Exception $e) {}
        }

        $query = \App\Models\Solicitud::query()
            ->with('cliente')
            ->orderByDesc('id');

        if ($q !== '') {
            $query->where(function ($w) use ($q, $fecha) {
                // ID exacto si es número
                if (ctype_digit($q)) {
                    $w->orWhere('id', (int)$q);
                }
                // Cliente
                $w->orWhereHas('cliente', function ($c) use ($q) {
                    $c->where('razon_social', 'like', "%{$q}%")
                    ->orWhere('rut', 'like', "%{$q}%");
                });
                // Campos libres
                $w->orWhere('origen', 'like', "%{$q}%")
                ->orWhere('destino', 'like', "%{$q}%");
                // Fecha si se pudo parsear
                if ($fecha) {
                    $w->orWhereDate('created_at', $fecha);
                }
            });
        } else {
            // sin query: últimos 25 para que TomSelect muestre algo
            $query->limit(25);
        }

        $solicitudes = $query->limit(25)->get();

        return response()->json($solicitudes->map(function ($s) {
            return [
                'id'   => $s->id,
                'text' => sprintf(
                    '#%d · %s · %s → %s · %s',
                    $s->id,
                    optional($s->cliente)->razon_social ?? 'Sin cliente',
                    $s->origen, $s->destino,
                    optional($s->created_at)?->format('d/m/Y H:i') ?? ''
                ),
            ];
        }));
    }

    public function aprobar($id)
    {
        // Cargar con relaciones reales, NO solo repository->find
        $solicitud = \App\Models\Solicitud::with(['cliente', 'cargas'])->find($id);

        if (!$solicitud) {
            Flash::error('Solicitud no encontrada.');
            return redirect()->route('solicituds.index');
        }

        if ($solicitud->estado === 'aprobada') {
            Flash::warning('Esta solicitud ya fue aprobada.');
            return redirect()->route('solicituds.index');
        }

        $cliente = optional($solicitud->cliente);

        // Crear cotización
        $cotizacion = \App\Models\Cotizacion::create([
            'solicitud_id' => $solicitud->id,
            'user_id'      => auth()->id(),
            'solicitante'  => $solicitud->solicitante
                            ?? $cliente->razon_social
                            ?? auth()->user()->name,
            'estado'       => 'pendiente',

            // por ahora lo dejamos 0, se recalcula con cargas
            'monto'        => 0,

            'origen'       => $solicitud->origen,
            'destino'      => $solicitud->destino,

            // resumen para compatibilidad
            'carga'        => $solicitud->carga,

            'cliente'      => $cliente->razon_social
                            ?? $solicitud->cliente_nombre
                            ?? $solicitud->cliente_id
                            ?? 'Cliente sin nombre',
        ]);

        // Copiar cargas solicitud -> cotización
        $total = 0;

        foreach ($solicitud->cargas as $sc) {
            $cantidad = (float) $sc->cantidad;
            $unit     = (int) ($sc->precio_unitario ?? 0);
            $subtotal = (int) round($cantidad * $unit);

            $cotizacion->cargas()->create([
                'descripcion'     => $sc->descripcion,
                'cantidad'        => $cantidad,
                'precio_unitario' => $unit,
                'subtotal'        => $subtotal,
            ]);

            $total += $subtotal;
        }

        if ($solicitud->cargas->count() === 0 && !empty($solicitud->carga)) {
            $cotizacion->cargas()->create([
                'descripcion'     => $solicitud->carga,
                'cantidad'        => 1,
                'precio_unitario' => 0,
                'subtotal'        => 0,
            ]);
        }

        $cotizacion->update(['monto' => $total]);

        $solicitud->update(['estado' => 'aprobada']);

        Flash::success('Solicitud aprobada y cotización generada.');
        return redirect()->route('solicituds.index');
    }

    
    public function fallida($id)
    {
        $solicitud = $this->solicitudRepository->find($id);

        if (empty($solicitud)) {
            Flash::error('Solicitud no encontrada.');
            return redirect()->route('solicituds.index');
        }

        // Si ya está aprobada, NO puede fallar
        if ($solicitud->estado === 'aprobada') {
            Flash::warning('No puedes marcar como fallida una solicitud aprobada.');
            return redirect()->route('solicituds.index');
        }

        $solicitud->update(['estado' => 'fallida']);

        Flash::success('Solicitud marcada como fallida.');
        return redirect()->route('solicituds.index');
    }

}
