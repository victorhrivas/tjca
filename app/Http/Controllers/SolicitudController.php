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

        // Si no viene en $request, lo autocompleta con el usuario conectado
        $input['solicitante'] = $input['solicitante'] ?? auth()->user()->name;

        $solicitud = $this->solicitudRepository->create($input);

        Flash::success('Solicitud se guardó correctamente.');

        return redirect(route('solicituds.index'));
    }


    /**
     * Display the specified Solicitud.
     */
    public function show($id)
    {
        $solicitud = $this->solicitudRepository->find($id);

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
        $solicitud = $this->solicitudRepository->find($id);

        if (empty($solicitud)) {
            Flash::error('Solicitud not found');

            return redirect(route('solicituds.index'));
        }

        $solicitud = $this->solicitudRepository->update($request->all(), $id);

        Flash::success('Solicitud ACtualizada Correctamente.');

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
        $solicitud = $this->solicitudRepository->find($id);

        if (empty($solicitud)) {
            Flash::error('Solicitud no encontrada.');
            return redirect()->route('solicituds.index');
        }

        if ($solicitud->estado === 'aprobada') {
            Flash::warning('Esta solicitud ya fue aprobada.');
            return redirect()->route('solicituds.index');
        }

        $cliente = optional($solicitud->cliente); // relación solicitud->cliente

        Cotizacion::create([
            'solicitud_id' => $solicitud->id,
            'user_id'      => auth()->id(),

            // Si la solicitud trae solicitante, usamos eso; si no, el nombre del cliente;
            // como última opción, el usuario logueado
            'solicitante'  => $solicitud->solicitante
                            ?? $cliente->razon_social
                            ?? auth()->user()->name,

            'estado'       => 'enviada',
            'monto'        => $solicitud->monto ?? $solicitud->valor ?? 0,

            // Copiamos tal cual desde Solicitud
            'origen'       => $solicitud->origen,
            'destino'      => $solicitud->destino,
            'carga'        => $solicitud->carga,

            // String “congelado” del cliente
            'cliente'      => $cliente->razon_social
                            ?? $solicitud->cliente_nombre
                            ?? $solicitud->cliente_id
                            ?? 'Cliente sin nombre',
        ]);

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
