@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm rounded bg-dark">
        {{-- Encabezado --}}
        <div class="card-header bg-success text-white">
            <h3 class="mb-0">
                <i class="fas fa-calendar-alt mr-2"></i>
                Ventas del {{ \Carbon\Carbon::parse($fecha)->format('d/m/Y') }}
            </h3>
        </div>

        <div class="card-body text-white">
            @if($ventas->isEmpty())
                <div class="alert alert-info">
                    No se registraron ventas en esta fecha.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-dark table-hover table-bordered mb-0">
                        <thead class="thead-dark">
                            <tr>
                                <th>Hora</th>
                                <th>Cliente</th>
                                <th>Producto(s)</th>
                                <th>Resumen</th>
                                <th class="text-right">Total (CLP)</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ventas as $venta)
                                <tr>
                                    <td>
                                        {{ \Carbon\Carbon::parse($venta->created_at)->format('H:i') }}
                                    </td>
                                    <td>
                                        {{ $venta->cliente->name ?? '—' }}
                                    </td>
                                    <td>
                                        <small>
                                            @foreach($venta->detalles as $detalle)
                                                {{ $detalle->producto->marca }} {{ $detalle->producto->modelo }} {{ $detalle->producto->anio }} – {{ $detalle->producto->tipo_vidrio }} <br>
                                            @endforeach
                                        </small>
                                    </td>
                                    <td>
                                        {{ $venta->resumen ?: '—' }}
                                    </td>
                                    <td class="text-right">
                                        ${{ number_format($venta->total, 0, ',', '.') }}
                                    </td>
                                    <td class="text-center">
                                        <a
                                            href="{{ route('ventas.show', $venta->id) }}"
                                            class="btn btn-sm btn-outline-light"
                                        >
                                            Ver detalles
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <div class="card-footer bg-dark text-right">
            <button type="button" class="btn btn-outline-light" onclick="history.back();">
                ← Volver
            </button>
        </div>
    </div>
</div>
@endsection
