<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\Solicitud;
use App\Models\Cotizacion;
use App\Models\Ot;
use App\Models\InicioCarga;
use App\Models\Entrega;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $hoy       = Carbon::today();
        $inicioMes = Carbon::now()->startOfMonth();

        // === KPIs generales (SOLO MES EN CURSO) ===
        $totales = [
            'solicitudes'   => Solicitud::whereBetween('created_at', [$inicioMes, $hoy])->count(),
            'cotizaciones'  => Cotizacion::whereBetween('created_at', [$inicioMes, $hoy])->count(),
            'ots'           => Ot::whereBetween('created_at', [$inicioMes, $hoy])->count(),
            'inicios_carga' => InicioCarga::whereBetween('created_at', [$inicioMes, $hoy])->count(),
            'entregas'      => Entrega::whereBetween('created_at', [$inicioMes, $hoy])->count(),
        ];

        // Monto cotizado en el mes actual
        $montoCotizadoMes = Cotizacion::whereBetween('created_at', [$inicioMes, $hoy])
            ->sum('monto');

        // Cotizaciones por estado (MES EN CURSO)
        $cotizacionesPorEstado = Cotizacion::select(
                'estado',
                DB::raw('COUNT(*) as total'),
                DB::raw('COALESCE(SUM(monto),0) as monto_total')
            )
            ->whereBetween('created_at', [$inicioMes, $hoy])
            ->groupBy('estado')
            ->get();

        // OT por estado (MES EN CURSO)
        $otsPorEstado = Ot::select(
                'estado',
                DB::raw('COUNT(*) as total')
            )
            ->whereBetween('created_at', [$inicioMes, $hoy])
            ->groupBy('estado')
            ->get();

        // Cotizaciones del mes para gráfico (día a día)
        $cotizacionesDias = Cotizacion::select(
                DB::raw('DATE(created_at) as fecha'),
                DB::raw('COUNT(*) as total'),
                DB::raw('COALESCE(SUM(monto),0) as monto_total')
            )
            ->whereBetween('created_at', [$inicioMes, $hoy])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('fecha')
            ->get();

        $chartCotizaciones = [
            'labels'  => $cotizacionesDias->pluck('fecha')->map(function ($fecha) {
                return Carbon::parse($fecha)->format('d-m');
            })->toArray(),
            'totales' => $cotizacionesDias->pluck('total')->toArray(),
            'montos'  => $cotizacionesDias->pluck('monto_total')->toArray(),
        ];

        // === OT en curso (cualquier fecha, NO entregadas, de más antigua a más reciente) ===
        $otsEnCursoQuery = Ot::with(['cotizacion.solicitud.cliente'])
            ->where('estado', '!=', 'entregada')
            ->orderBy('created_at', 'asc');

        $otsEnCursoTotal   = $otsEnCursoQuery->count();
        $otsEnCursoListado = (clone $otsEnCursoQuery)->limit(15)->get(); // las 15 más antiguas en curso

        // Actividad reciente SOLO del mes
        $recentSolicitudes = Solicitud::with('cliente')
            ->whereBetween('created_at', [$inicioMes, $hoy])
            ->latest()
            ->limit(5)
            ->get();

        $recentCotizaciones = Cotizacion::with(['solicitud.cliente'])
            ->whereBetween('created_at', [$inicioMes, $hoy])
            ->latest()
            ->limit(5)
            ->get();

        $recentOts = Ot::with(['cotizacion.solicitud.cliente'])
            ->whereBetween('created_at', [$inicioMes, $hoy])
            ->latest()
            ->limit(5)
            ->get();

        $recentEntregas = Entrega::with(['ot.cotizacion.solicitud.cliente'])
            ->whereBetween('created_at', [$inicioMes, $hoy])
            ->latest()
            ->limit(5)
            ->get();

        return view('home', compact(
            'totales',
            'montoCotizadoMes',
            'cotizacionesPorEstado',
            'otsPorEstado',
            'chartCotizaciones',
            'inicioMes',
            'hoy',
            'recentSolicitudes',
            'recentCotizaciones',
            'recentOts',
            'recentEntregas',
            'otsEnCursoTotal',
            'otsEnCursoListado'
        ));
    }
}
