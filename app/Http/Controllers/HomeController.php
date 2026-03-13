<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\Ot;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $hoy = Carbon::today();

        // =========================
        // Filtros (GET)
        // =========================
        $q         = trim((string) $request->get('q', ''));
        $estado    = $request->get('estado');     // ej: pendiente, inicio_carga, en_transito, entregada, con_incidencia
        $status    = $request->get('status');     // (si es distinto a "estado" en tu modelo)
        $traslado  = $request->get('traslado');   // INT / EXT (cuando exista)
        $from      = $request->get('from');       // YYYY-MM-DD
        $to        = $request->get('to');         // YYYY-MM-DD

        // =========================
        // Query base OT
        // =========================
        $otsQuery = Ot::query()
            ->with(['cotizacion.solicitud.cliente']);

        // Rango de fecha (usa created_at como "Fecha OT")
        if ($from) {
            $otsQuery->whereDate('created_at', '>=', $from);
        }
        if ($to) {
            $otsQuery->whereDate('created_at', '<=', $to);
        }

        // Estado (columna existente en tu OT)
        if (!empty($estado) && $estado !== 'all') {
            $otsQuery->where('estado', $estado);
        }

        // Status (si existe como columna distinta a estado; si no existe, no lo filtres)
        // Actívalo cuando tengas la columna `status` en ots:
        if (!empty($status) && $status !== 'all') {
            // Evita romper si aún no existe la columna: comenta hasta migrar
            // $otsQuery->where('status', $status);
        }

        // Traslado (INT/EXT) - Actívalo cuando exista la columna
        if (!empty($traslado) && $traslado !== 'all') {
            // $otsQuery->where('traslado_tipo', $traslado); // ej: traslado_tipo = INT|EXT
        }

        // Búsqueda (por id OT, cliente, conductor, desde/hasta, equipo)
        if ($q !== '') {
            $otsQuery->where(function ($qq) use ($q) {
                $qq->where('id', $q)
                   ->orWhere('conductor', 'like', "%{$q}%")
                   // Campos futuros: si hoy no existen, no los uses aquí
                   //->orWhere('equipo', 'like', "%{$q}%")
                   //->orWhere('desde', 'like', "%{$q}%")
                   //->orWhere('hasta', 'like', "%{$q}%")
                   ->orWhereHas('cotizacion.solicitud.cliente', function ($c) use ($q) {
                       $c->where('razon_social', 'like', "%{$q}%");
                   });
            });
        }

        // =========================
        // Datos para dashboard
        // =========================
        $ots = (clone $otsQuery)
            ->orderBy('created_at', 'desc')
            ->paginate(25)
            ->withQueryString();

        // Stats rápidos (con mismos filtros)
        $stats = (clone $otsQuery)
            ->select('estado', DB::raw('COUNT(*) as total'))
            ->groupBy('estado')
            ->pluck('total', 'estado');

        // Para selects (puedes ajustar a tus valores reales)
        $estadoOptions = [
            'all'           => 'Todos',
            'pendiente'     => 'Pendiente',
            'inicio_carga'  => 'Inicio carga',
            'en_transito'   => 'En tránsito',
            'con_incidencia'=> 'Con incidencia',
            'entregada'     => 'Entregada',
        ];

        // StatusOptions (cuando exista status real)
        $statusOptions = [
            'all'        => 'Todos',
            'pendiente'  => 'Pendiente',
            'en_transito'=> 'En tránsito',
            'entregado'  => 'Entregado',
        ];

        return view('home', compact(
            'ots',
            'stats',
            'estadoOptions',
            'statusOptions',
            'hoy'
        ));
    }
}