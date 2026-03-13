@extends('layouts.app')

@push('styles')
<style>
    /* =========================================================
       SOLICITUDES INDEX
       Corporativo + compacto + dark mode friendly
    ========================================================= */

    .sol-page{
        --sol-bg-card: #ffffff;
        --sol-bg-soft: #f8fafc;
        --sol-bg-head: #f6f8fb;
        --sol-border: #e5e7eb;
        --sol-border-soft: #edf1f5;

        --sol-text: #4b5563;
        --sol-text-strong: #1f2937;
        --sol-text-muted: #6b7280;

        --sol-input-bg: #ffffff;
        --sol-input-border: #d1d5db;
        --sol-input-text: #111827;
        --sol-placeholder: #9ca3af;

        --sol-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
        --sol-radius: 14px;
    }

    body.dark-mode .sol-page,
    .dark-mode .sol-page,
    body[class*="dark"] .sol-page{
        --sol-bg-card: #232a31;
        --sol-bg-soft: #1f252b;
        --sol-bg-head: #2a323a;
        --sol-border: #3a434d;
        --sol-border-soft: #414b55;

        --sol-text: #d7dee5;
        --sol-text-strong: #f3f6f9;
        --sol-text-muted: #aab4bf;

        --sol-input-bg: #2b333b;
        --sol-input-border: #4b5662;
        --sol-input-text: #f3f6f9;
        --sol-placeholder: #93a0ad;

        --sol-shadow: 0 12px 28px rgba(0, 0, 0, 0.22);
    }

    .sol-page .sol-title{
        font-size: 1.7rem;
        font-weight: 800;
        letter-spacing: -.02em;
        color: var(--sol-text-strong);
        margin-bottom: .15rem;
    }

    .sol-page .sol-subtitle{
        color: var(--sol-text-muted);
        font-size: .92rem;
        margin-bottom: 0;
    }

    .sol-page .sol-card{
        background: var(--sol-bg-card);
        border: 1px solid var(--sol-border);
        border-radius: var(--sol-radius);
        box-shadow: var(--sol-shadow);
        overflow: hidden;
    }

    .sol-page .sol-card-header{
        background: var(--sol-bg-head);
        border-bottom: 1px solid var(--sol-border);
        padding: 12px 16px;
    }

    .sol-page .sol-card-title{
        margin: 0;
        color: var(--sol-text-strong);
        font-size: .95rem;
        font-weight: 800;
        display: flex;
        align-items: center;
        gap: .5rem;
    }

    .sol-page .sol-card-body{
        padding: 16px;
    }

    .sol-page .sol-label{
        font-size: .74rem;
        font-weight: 700;
        color: var(--sol-text-muted);
        margin-bottom: 6px;
        display: inline-block;
        text-transform: uppercase;
        letter-spacing: .03em;
    }

    .sol-page .form-control,
    .sol-page .form-select,
    .sol-page select,
    .sol-page input{
        background: var(--sol-input-bg) !important;
        color: var(--sol-input-text) !important;
        border: 1px solid var(--sol-input-border) !important;
        border-radius: 10px !important;
        min-height: 38px;
        font-size: .88rem;
        box-shadow: none !important;
    }

    .sol-page input::placeholder{
        color: var(--sol-placeholder) !important;
        opacity: 1;
    }

    .sol-page .form-control:focus,
    .sol-page select:focus,
    .sol-page input:focus{
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 .15rem rgba(59, 130, 246, .15) !important;
    }

    .sol-page .btn{
        border-radius: 10px;
        font-weight: 700;
        min-height: 38px;
        box-shadow: none !important;
    }

    .sol-page .btn-primary{
        padding-left: 14px;
        padding-right: 14px;
    }

    .sol-page .btn-outline-secondary{
        border-width: 1px;
    }

    .sol-page .sol-actions{
        display: flex;
        gap: .5rem;
        flex-wrap: wrap;
    }

    .sol-page .sol-toolbar{
        display: flex;
        justify-content: space-between;
        align-items: end;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .sol-page .sol-toolbar-right{
        display: flex;
        gap: .5rem;
        flex-wrap: wrap;
    }

    .sol-page .sol-table-wrap{
        background: var(--sol-bg-card);
    }

    .sol-page .card{
        background: var(--sol-bg-card);
        border: 1px solid var(--sol-border);
        border-radius: var(--sol-radius);
        box-shadow: var(--sol-shadow);
        overflow: hidden;
    }

    .sol-page .text-muted,
    .sol-page small.text-muted{
        color: var(--sol-text-muted) !important;
    }

    .sol-page .content-header{
        padding-bottom: 0;
    }

    .sol-page .sol-divider{
        height: 1px;
        background: var(--sol-border-soft);
        margin: 0;
    }

    body.dark-mode .sol-page input[type="date"]::-webkit-calendar-picker-indicator,
    .dark-mode .sol-page input[type="date"]::-webkit-calendar-picker-indicator,
    body[class*="dark"] .sol-page input[type="date"]::-webkit-calendar-picker-indicator{
        filter: invert(1);
    }

    @media (max-width: 767.98px){
        .sol-page .sol-toolbar{
            flex-direction: column;
            align-items: stretch;
        }

        .sol-page .sol-toolbar-right{
            width: 100%;
        }

        .sol-page .sol-toolbar-right .btn{
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid mt-4 sol-page">

    <div class="sol-toolbar">
        <div>
            <h1 class="sol-title">Solicitudes</h1>
            <p class="sol-subtitle">Gestión y seguimiento de solicitudes comerciales y operativas.</p>
        </div>

        <div class="sol-toolbar-right">
            <a class="btn btn-primary" href="{{ route('solicituds.create') }}">
                <i class="fas fa-plus mr-1"></i> Nuevo
            </a>
        </div>
    </div>

    <div class="content px-0">

        @include('flash::message')

        <div class="sol-card mb-3">
            <div class="sol-card-header d-flex justify-content-between align-items-center flex-wrap" style="gap:.75rem;">
                <h3 class="sol-card-title">
                    <i class="fas fa-filter"></i>
                    Filtros de búsqueda
                </h3>

                <a href="{{ route('solicituds.index') }}" class="btn btn-sm btn-outline-secondary">
                    Limpiar
                </a>
            </div>

            <div class="sol-divider"></div>

            <div class="sol-card-body">
                <form method="GET" action="{{ route('solicituds.index') }}">
                    <div class="row align-items-end">

                        <div class="col-lg-3 col-md-6 mb-3">
                            <label class="sol-label">Texto libre</label>
                            <input type="text"
                                   name="q"
                                   class="form-control"
                                   placeholder="Cliente, origen, destino..."
                                   value="{{ request('q') }}">
                        </div>

                        <div class="col-lg-3 col-md-6 mb-3">
                            <label class="sol-label">Cliente</label>
                            <select name="cliente_id" class="form-control">
                                <option value="">Todos los clientes</option>
                                @foreach($clientes as $id => $nombre)
                                    <option value="{{ $id }}" {{ request('cliente_id') == $id ? 'selected' : '' }}>
                                        {{ $nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-2 col-md-4 mb-3">
                            <label class="sol-label">Estado</label>
                            <select name="estado" class="form-control">
                                <option value="">Todos</option>
                                <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="aprobada" {{ request('estado') == 'aprobada' ? 'selected' : '' }}>Aprobada</option>
                                <option value="fallida" {{ request('estado') == 'fallida' ? 'selected' : '' }}>Fallida</option>
                            </select>
                        </div>

                        <div class="col-lg-2 col-md-4 mb-3">
                            <label class="sol-label">Fecha creación</label>
                            <input type="date"
                                   name="fecha"
                                   class="form-control"
                                   value="{{ request('fecha') }}">
                        </div>

                        <div class="col-lg-2 col-md-4 mb-3">
                            <button class="btn btn-primary btn-block">
                                <i class="fas fa-search mr-1"></i> Filtrar
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="sol-card-header">
                <h3 class="sol-card-title">
                    <i class="fas fa-list"></i>
                    Listado de solicitudes
                </h3>
            </div>

            <div class="sol-table-wrap">
                @include('solicituds.table')
            </div>
        </div>

    </div>
</div>
@endsection