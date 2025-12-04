@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header border-bottom">
                    <h3 class="mb-0">
                        Bienvenido a {{ config('app.name') }}
                    </h3>
                    <small class="text-muted">Panel principal</small>
                </div>

                <div class="card-body">
                    {{-- Destacado principal --}}
                    <div class="highlight-box mb-4">
                        <h5>Resumen rápido</h5>
                        <p class="mb-0 lead font-weight-bold">
                            Este es tu tablero principal. Cuando definas métricas, aparecerán aquí.
                        </p>
                    </div>

                    {{-- Tarjetas informativas --}}
                    <div class="row text-center">
                        <div class="col-md-4 mb-4">
                            <div class="p-4 info-card">
                                <i class="fas fa-bolt fa-2x mb-2"></i>
                                <h6>Acceso rápido</h6>
                                <p class="text-muted mb-0">Agrega accesos directos a tus vistas clave.</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="p-4 info-card">
                                <i class="fas fa-chart-line fa-2x mb-2"></i>
                                <h6>Indicadores</h6>
                                <p class="text-muted mb-0">Próximamente: ventas, actividad y estado.</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="p-4 info-card">
                                <i class="fas fa-cog fa-2x mb-2"></i>
                                <h6>Configuración</h6>
                                <p class="text-muted mb-0">Define tus preferencias y notificaciones.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Tabla demo --}}
                    <div class="mt-3 p-3 rounded" style="background:var(--bg-3);border:1px solid var(--line);">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="mb-0" style="color:var(--accent);font-weight:600;">Actividad reciente</h6>
                            <span class="badge-demo">Demo</span>
                        </div>
                        <table class="table table-sm table-hover mb-0">
                            <thead>
                                <tr class="text-muted">
                                    <th>Fecha</th>
                                    <th>Detalle</th>
                                    <th class="text-right">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>—</td>
                                    <td>Sin registros por ahora</td>
                                    <td class="text-right"><span class="badge badge-secondary">N/A</span></td>
                                </tr>
                                <tr>
                                    <td>—</td>
                                    <td>Agrega tus primeras métricas</td>
                                    <td class="text-right"><span class="badge badge-secondary">N/A</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- Botones de acción --}}
                    <div class="mt-4 d-flex flex-wrap gap-2">
                        <a href="{{ url('/') }}" class="btn btn-primary btn-lg mr-2">Comenzar</a>
                        <a href="{{ route('home') }}" class="btn btn-outline-light btn-lg">Refrescar</a>
                    </div>
                </div>

                <div class="card-footer">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
