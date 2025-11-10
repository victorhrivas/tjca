@extends('layouts.app')

@section('content')
<style>
    :root {
        --bg-0: #101114;
        --bg-1: #15171b;
        --bg-2: #1c1f24;
        --bg-3: #23272e;
        --line: #2c3139;
        --ink: #e6e7ea;
        --muted: #a7adb7;

        /* Mostaza elegante */
        --accent: #d4ad18;        /* tono base mostaza */
        --accent-hover: #e1ba1f;  /* hover más claro */
        --accent-ink: #0b0c0e;
        --shadow: 0 10px 30px rgba(0, 0, 0, .35);
    }


    body {
        background:
            radial-gradient(900px 520px at 80% 10%, rgba(246,199,0,.06), transparent 60%),
            radial-gradient(700px 400px at 0% 100%, rgba(255,255,255,.04), transparent 60%),
            var(--bg-0);
        color: var(--ink);
    }

    .card {
        background: linear-gradient(180deg, var(--bg-2), var(--bg-1));
        border: 1px solid var(--line);
        border-radius: 14px;
        box-shadow: var(--shadow);
    }

    .card-header {
        background: var(--bg-3);
        border-bottom: 1px solid var(--line);
        color: var(--ink);
        border-top-left-radius: 14px;
        border-top-right-radius: 14px;
    }

    .card-header h3 {
        color: var(--accent);
        font-weight: 700;
    }

    .card-body {
        color: var(--ink);
        background: transparent;
    }

    .highlight-box {
        background: var(--bg-3);
        border: 1px solid var(--line);
        border-radius: 10px;
        padding: 20px;
    }

    .highlight-box h5 {
        color: var(--accent);
        font-weight: 700;
    }

    .info-card {
        background: var(--bg-2);
        border: 1px solid var(--line);
        border-radius: 12px;
        transition: all 0.2s ease-in-out;
        height: 100%;
    }

    .info-card:hover {
        background: var(--bg-3);
        transform: translateY(-3px);
        box-shadow: 0 0 15px rgba(246,199,0,.15);
    }

    .info-card i {
        color: var(--accent);
    }

    .info-card h6 {
        color: var(--accent);
        font-weight: 600;
    }

    .table {
        color: var(--ink);
        border-color: var(--line);
    }

    .table th {
        background: var(--bg-3);
        color: var(--ink);
        border-color: var(--line);
    }

    .table td {
        background: var(--bg-2);
        border-color: var(--line);
    }

    .table-hover tbody tr:hover {
        background: var(--bg-3);
    }

    .badge-demo {
        background: var(--accent);
        color: var(--accent-ink);
        border-radius: 8px;
        padding: 4px 8px;
        font-weight: 600;
    }

    .btn-primary {
        background: var(--accent);
        border-color: var(--accent);
        color: var(--accent-ink);
        font-weight: 700;
        letter-spacing: 0.3px;
        border-radius: 8px;
        transition: all 0.2s ease-in-out;
    }

    .btn-primary:hover {
        background: var(--accent-hover);
        border-color: var(--accent-hover);
        box-shadow: 0 0 15px rgba(246,199,0,.25);
        transform: translateY(-1px);
    }

    .btn-outline-light {
        border-color: var(--line);
        color: var(--ink);
        font-weight: 600;
        border-radius: 8px;
    }

    .btn-outline-light:hover {
        background: var(--bg-3);
        border-color: var(--accent);
        color: var(--accent);
    }

    .card-footer {
        background: var(--bg-3);
        border-top: 1px solid var(--line);
        color: var(--muted);
    }

    .card-footer code {
        color: var(--accent-hover);
    }
</style>

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
                    <small>
                        Personaliza este tablero en <code>resources/views/home.blade.php</code>.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
