<?php

namespace App\Http\Controllers;

use App\Exports\DashboardOtExport;
use App\Models\Ot;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $hoy = Carbon::today();

        $otsQuery = $this->buildDashboardQuery($request);

        $user = auth()->user();

        if ($user->hasRole('chofer')) {
            $nombreUsuario = trim($user->name);

            $otsQuery->where(function ($q) use ($nombreUsuario) {
                $q->where('conductor', $nombreUsuario);
            });
        }

        $ots = (clone $otsQuery)
            ->orderBy('created_at', 'desc')
            ->paginate(25)
            ->withQueryString();

        $stats = (clone $otsQuery)
            ->select('estado', DB::raw('COUNT(*) as total'))
            ->groupBy('estado')
            ->pluck('total', 'estado');

        $estadoOptions = [
            'all'            => 'Todos',
            'pendiente'      => 'Pendiente',
            'inicio_carga'   => 'Inicio carga',
            'en_transito'    => 'En tránsito',
            'con_incidencia' => 'Con incidencia',
            'entregada'      => 'Entregada',
        ];

        $statusOptions = [
            'all'         => 'Todos',
            'pendiente'   => 'Pendiente',
            'en_transito' => 'En tránsito',
            'entregado'   => 'Entregado',
        ];

        return view('home', compact(
            'ots',
            'stats',
            'estadoOptions',
            'statusOptions',
            'hoy'
        ));
    }

    public function exportExcel(Request $request)
    {
        $query = $this->buildDashboardQuery($request)
            ->orderBy('created_at', 'desc');

        $filename = 'dashboard_ot_' . now()->format('Y-m-d_H-i-s') . '.xlsx';

        return Excel::download(new DashboardOtExport($query), $filename);
    }

    private function buildDashboardQuery(Request $request)
    {
        $q        = trim((string) $request->get('q', ''));
        $estado   = $request->get('estado');
        $status   = $request->get('status');
        $traslado = $request->get('traslado');
        $from     = $request->get('from');
        $to       = $request->get('to');

        $columns = Schema::getColumnListing('ots');

        $otsQuery = Ot::query()
            ->with([
                'cotizacion.solicitud.cliente',
                'inicioCargas',
            ]);

        if ($from) {
            $otsQuery->whereDate('created_at', '>=', $from);
        }

        if ($to) {
            $otsQuery->whereDate('created_at', '<=', $to);
        }

        if (!empty($estado) && $estado !== 'all') {
            $otsQuery->where('estado', $estado);
        }

        if (!empty($status) && $status !== 'all' && in_array('status', $columns)) {
            $otsQuery->where('status', $status);
        }

        if (!empty($traslado) && $traslado !== 'all') {
            $otsQuery->where('traslado', $traslado);
        }

        if ($q !== '') {
            $otsQuery->where(function ($qq) use ($q, $columns) {
                if (is_numeric($q)) {
                    $qq->where('id', (int) $q);
                }

                $qq->orWhere('folio', 'like', "%{$q}%")
                    ->orWhere('conductor', 'like', "%{$q}%")
                    ->orWhere('equipo', 'like', "%{$q}%")
                    ->orWhere('solicitante', 'like', "%{$q}%");

                if (in_array('gdd', $columns)) {
                    $qq->orWhere('gdd', 'like', "%{$q}%");
                }

                if (in_array('afid_interno', $columns)) {
                    $qq->orWhere('afid_interno', 'like', "%{$q}%");
                }

                if (in_array('factura', $columns)) {
                    $qq->orWhere('factura', 'like', "%{$q}%");
                }

                if (in_array('factura_externo', $columns)) {
                    $qq->orWhere('factura_externo', 'like', "%{$q}%");
                }

                if (in_array('oc', $columns)) {
                    $qq->orWhere('oc', 'like', "%{$q}%");
                }

                $qq->orWhereHas('cotizacion', function ($c) use ($q) {
                    $c->where('cliente', 'like', "%{$q}%")
                        ->orWhere('origen', 'like', "%{$q}%")
                        ->orWhere('destino', 'like', "%{$q}%")
                        ->orWhere('solicitante', 'like', "%{$q}%");
                })
                ->orWhereHas('cotizacion.solicitud.cliente', function ($c) use ($q) {
                    $c->where('razon_social', 'like', "%{$q}%");
                });
            });
        }

        return $otsQuery;
    }
}