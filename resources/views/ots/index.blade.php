@extends('layouts.app')

@push('styles')
<style>
    /* =========================================================
       OTS INDEX
       Corporativo + compacto + dark mode friendly
    ========================================================= */

    .otx-page{
        --otx-bg-card: #ffffff;
        --otx-bg-soft: #f8fafc;
        --otx-bg-head: #f6f8fb;
        --otx-border: #e5e7eb;
        --otx-border-soft: #edf1f5;

        --otx-text: #4b5563;
        --otx-text-strong: #1f2937;
        --otx-text-muted: #6b7280;

        --otx-input-bg: #ffffff;
        --otx-input-border: #d1d5db;
        --otx-input-text: #111827;
        --otx-placeholder: #9ca3af;

        --otx-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
        --otx-radius: 14px;
    }

    body.dark-mode .otx-page,
    .dark-mode .otx-page,
    body[class*="dark"] .otx-page{
        --otx-bg-card: #232a31;
        --otx-bg-soft: #1f252b;
        --otx-bg-head: #2a323a;
        --otx-border: #3a434d;
        --otx-border-soft: #414b55;

        --otx-text: #d7dee5;
        --otx-text-strong: #f3f6f9;
        --otx-text-muted: #aab4bf;

        --otx-input-bg: #2b333b;
        --otx-input-border: #4b5662;
        --otx-input-text: #f3f6f9;
        --otx-placeholder: #93a0ad;

        --otx-shadow: 0 12px 28px rgba(0, 0, 0, 0.22);
    }

    .otx-page .otx-title{
        font-size: 1.7rem;
        font-weight: 800;
        letter-spacing: -.02em;
        color: var(--otx-text-strong);
        margin-bottom: .15rem;
    }

    .otx-page .otx-subtitle{
        color: var(--otx-text-muted);
        font-size: .92rem;
        margin-bottom: 0;
    }

    .otx-page .otx-card{
        background: var(--otx-bg-card);
        border: 1px solid var(--otx-border);
        border-radius: var(--otx-radius);
        box-shadow: var(--otx-shadow);
        overflow: hidden;
    }

    .otx-page .otx-card-header{
        background: var(--otx-bg-head);
        border-bottom: 1px solid var(--otx-border);
        padding: 12px 16px;
    }

    .otx-page .otx-card-title{
        margin: 0;
        color: var(--otx-text-strong);
        font-size: .95rem;
        font-weight: 800;
        display: flex;
        align-items: center;
        gap: .5rem;
    }

    .otx-page .otx-card-body{
        padding: 16px;
    }

    .otx-page .otx-label{
        font-size: .74rem;
        font-weight: 700;
        color: var(--otx-text-muted);
        margin-bottom: 6px;
        display: inline-block;
        text-transform: uppercase;
        letter-spacing: .03em;
    }

    .otx-page .form-control,
    .otx-page .form-select,
    .otx-page select,
    .otx-page input{
        background: var(--otx-input-bg) !important;
        color: var(--otx-input-text) !important;
        border: 1px solid var(--otx-input-border) !important;
        border-radius: 10px !important;
        min-height: 38px;
        font-size: .88rem;
        box-shadow: none !important;
    }

    .otx-page input::placeholder{
        color: var(--otx-placeholder) !important;
        opacity: 1;
    }

    .otx-page .form-control:focus,
    .otx-page select:focus,
    .otx-page input:focus{
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 .15rem rgba(59, 130, 246, .15) !important;
    }

    .otx-page .btn{
        border-radius: 10px;
        font-weight: 700;
        min-height: 38px;
        box-shadow: none !important;
    }

    .otx-page .btn-primary{
        padding-left: 14px;
        padding-right: 14px;
    }

    .otx-page .btn-outline-secondary{
        border-width: 1px;
    }

    .otx-page .otx-toolbar{
        display: flex;
        justify-content: space-between;
        align-items: end;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .otx-page .otx-toolbar-right{
        display: flex;
        gap: .5rem;
        flex-wrap: wrap;
    }

    .otx-page .otx-table-wrap{
        background: var(--otx-bg-card);
    }

    .otx-page .card{
        background: var(--otx-bg-card);
        border: 1px solid var(--otx-border);
        border-radius: var(--otx-radius);
        box-shadow: var(--otx-shadow);
        overflow: hidden;
    }

    .otx-page .text-muted,
    .otx-page small.text-muted{
        color: var(--otx-text-muted) !important;
    }

    .otx-page .content-header{
        padding-bottom: 0;
    }

    .otx-page .otx-divider{
        height: 1px;
        background: var(--otx-border-soft);
        margin: 0;
    }

    body.dark-mode .otx-page input[type="date"]::-webkit-calendar-picker-indicator,
    .dark-mode .otx-page input[type="date"]::-webkit-calendar-picker-indicator,
    body[class*="dark"] .otx-page input[type="date"]::-webkit-calendar-picker-indicator{
        filter: invert(1);
    }

    @media (max-width: 767.98px){
        .otx-page .otx-toolbar{
            flex-direction: column;
            align-items: stretch;
        }

        .otx-page .otx-toolbar-right{
            width: 100%;
        }

        .otx-page .otx-toolbar-right .btn{
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid mt-4 otx-page">

    <div class="otx-toolbar">
        <div>
            <h1 class="otx-title">OTs</h1>
            <p class="otx-subtitle">Seguimiento operativo de órdenes de trabajo, estados y asignaciones.</p>
        </div>

        <div class="otx-toolbar-right">
            <a class="btn btn-primary" href="{{ route('ots.create') }}">
                <i class="fas fa-plus mr-1"></i> Nuevo
            </a>
        </div>
    </div>

    <div class="content px-0">

        @include('flash::message')

        <div class="otx-card mb-3">
            <div class="otx-card-header d-flex justify-content-between align-items-center flex-wrap" style="gap:.75rem;">
                <h3 class="otx-card-title">
                    <i class="fas fa-filter"></i>
                    Filtros de búsqueda
                </h3>

                <a href="{{ route('ots.index') }}" class="btn btn-sm btn-outline-secondary">
                    Limpiar
                </a>
            </div>

            <div class="otx-divider"></div>

            <div class="otx-card-body">
                <form method="GET" action="{{ route('ots.index') }}">
                    <div class="row align-items-end">

                        <div class="col-lg-3 col-md-6 mb-3">
                            <label class="otx-label">Texto libre</label>
                            <input type="text"
                                name="q"
                                class="form-control"
                                placeholder="Folio, cliente, origen, destino, conductor..."
                                value="{{ request('q') }}">
                        </div>

                        <div class="col-lg-3 col-md-6 mb-3">
                            <label class="otx-label">Cliente</label>
                            <input type="text"
                                   name="cliente"
                                   class="form-control"
                                   placeholder="Nombre cliente"
                                   value="{{ request('cliente') }}">
                        </div>

                        <div class="col-lg-3 col-md-6 mb-3">
                            <label class="otx-label">Estado</label>
                            <select name="estado" class="form-control">
                                <option value="">Todos</option>
                                <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="inicio_carga" {{ request('estado') == 'inicio_carga' ? 'selected' : '' }}>Inicio de carga</option>
                                <option value="en_transito" {{ request('estado') == 'en_transito' ? 'selected' : '' }}>En tránsito</option>
                                <option value="entregada" {{ request('estado') == 'entregada' ? 'selected' : '' }}>Entregada</option>
                                <option value="con_incidencia" {{ request('estado') == 'con_incidencia' ? 'selected' : '' }}>Con incidencia</option>
                            </select>
                        </div>

                        <div class="col-lg-3 col-md-6 mb-3">
                            <label class="otx-label">Fecha servicio</label>
                            <input type="date"
                                   name="fecha"
                                   class="form-control"
                                   value="{{ request('fecha') }}">
                        </div>

                        <div class="col-lg-3 col-md-6 mb-3">
                            <button class="btn btn-primary btn-block">
                                <i class="fas fa-search mr-1"></i> Filtrar
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="otx-card-header">
                <h3 class="otx-card-title">
                    <i class="fas fa-truck-loading"></i>
                    Listado de órdenes de trabajo
                </h3>
            </div>

            <div class="otx-table-wrap">
                @include('ots.table')
            </div>
        </div>

    </div>
</div>
@endsection