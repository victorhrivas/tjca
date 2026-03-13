@extends('layouts.app')

@push('styles')
<style>
    /* =========================================================
       COTIZACIONES INDEX
       Corporativo + compacto + dark mode friendly
    ========================================================= */

    .cot-page{
        --cot-bg-card: #ffffff;
        --cot-bg-soft: #f8fafc;
        --cot-bg-head: #f6f8fb;
        --cot-border: #e5e7eb;
        --cot-border-soft: #edf1f5;

        --cot-text: #4b5563;
        --cot-text-strong: #1f2937;
        --cot-text-muted: #6b7280;

        --cot-input-bg: #ffffff;
        --cot-input-border: #d1d5db;
        --cot-input-text: #111827;
        --cot-placeholder: #9ca3af;

        --cot-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
        --cot-radius: 14px;
    }

    body.dark-mode .cot-page,
    .dark-mode .cot-page,
    body[class*="dark"] .cot-page{
        --cot-bg-card: #232a31;
        --cot-bg-soft: #1f252b;
        --cot-bg-head: #2a323a;
        --cot-border: #3a434d;
        --cot-border-soft: #414b55;

        --cot-text: #d7dee5;
        --cot-text-strong: #f3f6f9;
        --cot-text-muted: #aab4bf;

        --cot-input-bg: #2b333b;
        --cot-input-border: #4b5662;
        --cot-input-text: #f3f6f9;
        --cot-placeholder: #93a0ad;

        --cot-shadow: 0 12px 28px rgba(0, 0, 0, 0.22);
    }

    .cot-page .cot-title{
        font-size: 1.7rem;
        font-weight: 800;
        letter-spacing: -.02em;
        color: var(--cot-text-strong);
        margin-bottom: .15rem;
    }

    .cot-page .cot-subtitle{
        color: var(--cot-text-muted);
        font-size: .92rem;
        margin-bottom: 0;
    }

    .cot-page .cot-card{
        background: var(--cot-bg-card);
        border: 1px solid var(--cot-border);
        border-radius: var(--cot-radius);
        box-shadow: var(--cot-shadow);
        overflow: hidden;
    }

    .cot-page .cot-card-header{
        background: var(--cot-bg-head);
        border-bottom: 1px solid var(--cot-border);
        padding: 12px 16px;
    }

    .cot-page .cot-card-title{
        margin: 0;
        color: var(--cot-text-strong);
        font-size: .95rem;
        font-weight: 800;
        display: flex;
        align-items: center;
        gap: .5rem;
    }

    .cot-page .cot-card-body{
        padding: 16px;
    }

    .cot-page .cot-label{
        font-size: .74rem;
        font-weight: 700;
        color: var(--cot-text-muted);
        margin-bottom: 6px;
        display: inline-block;
        text-transform: uppercase;
        letter-spacing: .03em;
    }

    .cot-page .form-control,
    .cot-page .form-select,
    .cot-page select,
    .cot-page input{
        background: var(--cot-input-bg) !important;
        color: var(--cot-input-text) !important;
        border: 1px solid var(--cot-input-border) !important;
        border-radius: 10px !important;
        min-height: 38px;
        font-size: .88rem;
        box-shadow: none !important;
    }

    .cot-page input::placeholder{
        color: var(--cot-placeholder) !important;
        opacity: 1;
    }

    .cot-page .form-control:focus,
    .cot-page select:focus,
    .cot-page input:focus{
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 .15rem rgba(59, 130, 246, .15) !important;
    }

    .cot-page .btn{
        border-radius: 10px;
        font-weight: 700;
        min-height: 38px;
        box-shadow: none !important;
    }

    .cot-page .btn-primary{
        padding-left: 14px;
        padding-right: 14px;
    }

    .cot-page .btn-outline-secondary{
        border-width: 1px;
    }

    .cot-page .cot-toolbar{
        display: flex;
        justify-content: space-between;
        align-items: end;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .cot-page .cot-toolbar-right{
        display: flex;
        gap: .5rem;
        flex-wrap: wrap;
    }

    .cot-page .cot-table-wrap{
        background: var(--cot-bg-card);
    }

    .cot-page .card{
        background: var(--cot-bg-card);
        border: 1px solid var(--cot-border);
        border-radius: var(--cot-radius);
        box-shadow: var(--cot-shadow);
        overflow: hidden;
    }

    .cot-page .text-muted,
    .cot-page small.text-muted{
        color: var(--cot-text-muted) !important;
    }

    .cot-page .content-header{
        padding-bottom: 0;
    }

    .cot-page .cot-divider{
        height: 1px;
        background: var(--cot-border-soft);
        margin: 0;
    }

    body.dark-mode .cot-page input[type="date"]::-webkit-calendar-picker-indicator,
    .dark-mode .cot-page input[type="date"]::-webkit-calendar-picker-indicator,
    body[class*="dark"] .cot-page input[type="date"]::-webkit-calendar-picker-indicator{
        filter: invert(1);
    }

    @media (max-width: 767.98px){
        .cot-page .cot-toolbar{
            flex-direction: column;
            align-items: stretch;
        }

        .cot-page .cot-toolbar-right{
            width: 100%;
        }

        .cot-page .cot-toolbar-right .btn{
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid mt-4 cot-page">

    <div class="cot-toolbar">
        <div>
            <h1 class="cot-title">Cotizaciones</h1>
            <p class="cot-subtitle">Gestión comercial, seguimiento de estados y control de OT asociadas.</p>
        </div>

        <div class="cot-toolbar-right">
            <a class="btn btn-primary" href="{{ route('cotizacions.create') }}">
                <i class="fas fa-plus mr-1"></i> Nuevo
            </a>
        </div>
    </div>

    <div class="content px-0">

        @include('flash::message')

        <div class="cot-card mb-3">
            <div class="cot-card-header d-flex justify-content-between align-items-center flex-wrap" style="gap:.75rem;">
                <h3 class="cot-card-title">
                    <i class="fas fa-filter"></i>
                    Filtros de búsqueda
                </h3>

                <a href="{{ route('cotizacions.index') }}" class="btn btn-sm btn-outline-secondary">
                    Limpiar
                </a>
            </div>

            <div class="cot-divider"></div>

            <div class="cot-card-body">
                <form method="GET" action="{{ route('cotizacions.index') }}">
                    <div class="row align-items-end">

                        <div class="col-lg-2 col-md-6 mb-3">
                            <label class="cot-label">Texto libre</label>
                            <input type="text"
                                   name="q"
                                   class="form-control"
                                   placeholder="Cliente, origen, monto..."
                                   value="{{ request('q') }}">
                        </div>

                        <div class="col-lg-2 col-md-6 mb-3">
                            <label class="cot-label">Cliente</label>
                            <select name="cliente_id" class="form-control">
                                <option value="">Todos</option>
                                @foreach($clientes as $id => $nombre)
                                    <option value="{{ $id }}" {{ request('cliente_id') == $id ? 'selected' : '' }}>
                                        {{ $nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-2 col-md-4 mb-3">
                            <label class="cot-label">Estado</label>
                            <select name="estado" class="form-control">
                                <option value="">Todos</option>
                                <option value="enviada"   {{ request('estado') == 'enviada' ? 'selected' : '' }}>Enviada</option>
                                <option value="aceptada"  {{ request('estado') == 'aceptada' ? 'selected' : '' }}>Aceptada</option>
                                <option value="rechazada" {{ request('estado') == 'rechazada' ? 'selected' : '' }}>Rechazada</option>
                            </select>
                        </div>

                        <div class="col-lg-2 col-md-4 mb-3">
                            <label class="cot-label">Fecha creación</label>
                            <input type="date"
                                   name="fecha"
                                   class="form-control"
                                   value="{{ request('fecha') }}">
                        </div>

                        <div class="col-lg-2 col-md-4 mb-3">
                            <label class="cot-label">OT asociada</label>
                            <select name="ot" class="form-control">
                                <option value="">Todas</option>
                                <option value="con" {{ request('ot') === 'con' ? 'selected' : '' }}>Con OT</option>
                                <option value="sin" {{ request('ot') === 'sin' ? 'selected' : '' }}>Sin OT</option>
                            </select>
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
            <div class="cot-card-header">
                <h3 class="cot-card-title">
                    <i class="fas fa-file-invoice-dollar"></i>
                    Listado de cotizaciones
                </h3>
            </div>

            <div class="cot-table-wrap">
                @include('cotizacions.table')
            </div>
        </div>

    </div>
</div>
@endsection