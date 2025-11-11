<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSolicitudRequest;
use App\Http\Requests\UpdateSolicitudRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\SolicitudRepository;
use App\Models\Cliente;
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
        $solicituds = $this->solicitudRepository->paginate(10);

        return view('solicituds.index')
            ->with('solicituds', $solicituds);
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

        $solicitud = $this->solicitudRepository->create($input);

        Flash::success('Solicitudse guardó correctamente.');

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

        Flash::success('Solicitud updated successfully.');

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


}
