@extends('layouts.app')

@push('styles')
<style>
    /* =========================================================
       OT DASHBOARD
       Compatible con modo claro / oscuro
    ========================================================= */

    .ot-page .ot-scope{
        --ot-font-body: 10px;
        --ot-font-head: 9px;
        --ot-line: 1.05;
        --ot-pad-y: 2px;
        --ot-pad-x: 5px;

        /* LIGHT */
        --ot-bg-card: #ffffff;
        --ot-bg-header: #ffffff;
        --ot-bg-table: #ffffff;
        --ot-bg-head: #f6f7f9;
        --ot-bg-zebra: #fafafa;
        --ot-bg-hover: #eef3ff;

        --ot-border: #e3e6ea;
        --ot-border-soft: #e9ecef;

        --ot-text: #495057;
        --ot-text-strong: #2d3748;
        --ot-text-soft: #6c757d;
        --ot-text-money: #1f2933;

        --ot-pill-bg: #f1f3f5;
        --ot-pill-text: #2f3943;

        --ot-input-bg: #ffffff;
        --ot-input-text: #212529;
        --ot-input-border: #ced4da;
        --ot-input-placeholder: #97a0aa;

        --ot-disabled-bg: #f3f5f7;
        --ot-disabled-text: #9aa5b1;
        --ot-disabled-border: #e2e8ee;

        --ot-traslado-empty-bg: #eef2f6;
        --ot-traslado-empty-border: #d9e0e6;
        --ot-traslado-empty-text: #5f6b76;
    }

    body.dark-mode .ot-page .ot-scope,
    .dark-mode .ot-page .ot-scope,
    body[class*="dark"] .ot-page .ot-scope{
        --ot-bg-card: #232a31;
        --ot-bg-header: #232a31;
        --ot-bg-table: #1f252b;
        --ot-bg-head: #2b333b;
        --ot-bg-zebra: #242c33;
        --ot-bg-hover: #2d3742;

        --ot-border: #3a434d;
        --ot-border-soft: #414b55;

        --ot-text: #d7dee5;
        --ot-text-strong: #f1f5f9;
        --ot-text-soft: #aab4bf;
        --ot-text-money: #f8fafc;

        --ot-pill-bg: #303841;
        --ot-pill-text: #e5edf5;

        --ot-input-bg: #2b333b;
        --ot-input-text: #f1f5f9;
        --ot-input-border: #47515c;
        --ot-input-placeholder: #9aa6b2;

        --ot-disabled-bg: #313941;
        --ot-disabled-text: #8d99a6;
        --ot-disabled-border: #47515c;

        --ot-traslado-empty-bg: #39424b;
        --ot-traslado-empty-border: #55616d;
        --ot-traslado-empty-text: #d5dde5;
    }

    .ot-page .ot-card{
        background: var(--ot-bg-card);
        border: 1px solid var(--ot-border);
        border-radius: 12px;
        overflow: hidden;
        color: var(--ot-text);
    }

    .ot-page .ot-card-header{
        background: var(--ot-bg-header);
        border-bottom: 1px solid var(--ot-border);
        padding: 10px 14px;
        color: var(--ot-text);
    }

    .ot-page h3,
    .ot-page strong{
        color: var(--ot-text-strong);
    }

    .ot-page small,
    .ot-page .text-muted{
        color: var(--ot-text-soft) !important;
    }

    .ot-page .badge-kpi{
        font-weight: 700;
        border-radius: 6px;
        padding: 4px 8px;
        font-size: .65rem;
    }

    .ot-page .form-control-sm{
        border-radius: 8px;
        font-size: .78rem;
        padding: 3px 6px;
    }

    .ot-page input.form-control,
    .ot-page select.form-control{
        background: var(--ot-input-bg) !important;
        color: var(--ot-input-text) !important;
        border-color: var(--ot-input-border) !important;
    }

    .ot-page select.form-control option,
    .ot-page select.form-control optgroup{
        background: #ffffff;
        color: #212529;
    }

    body.dark-mode .ot-page select.form-control option,
    body.dark-mode .ot-page select.form-control optgroup,
    .dark-mode .ot-page select.form-control option,
    .dark-mode .ot-page select.form-control optgroup,
    body[class*="dark"] .ot-page select.form-control option,
    body[class*="dark"] .ot-page select.form-control optgroup{
        background: #2b333b !important;
        color: #f1f5f9 !important;
    }

    body.dark-mode .ot-page select.form-control,
    .dark-mode .ot-page select.form-control,
    body[class*="dark"] .ot-page select.form-control{
        background-color: #2b333b !important;
        color: #f1f5f9 !important;
        border-color: #47515c !important;
    }

    .ot-page input.form-control::placeholder{
        color: var(--ot-input-placeholder) !important;
        opacity: 1;
    }

    .ot-page input[type="date"]::-webkit-calendar-picker-indicator{
        filter: none;
    }

    body.dark-mode .ot-page input[type="date"]::-webkit-calendar-picker-indicator,
    .dark-mode .ot-page input[type="date"]::-webkit-calendar-picker-indicator,
    body[class*="dark"] .ot-page input[type="date"]::-webkit-calendar-picker-indicator{
        filter: invert(1);
    }

    .ot-page .btn{
        border-radius: 8px;
    }

    .ot-page .input-icon{
        position: relative;
    }

    .ot-page .input-icon__prefix{
        position: absolute;
        left: 8px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--ot-input-placeholder);
        font-size: 10px;
        pointer-events: none;
    }

    .ot-page .pill-soft{
        display: inline-block;
        padding: 3px 8px;
        border-radius: 999px;
        background: var(--ot-pill-bg);
        color: var(--ot-pill-text);
        font-weight: 700;
        font-size: 10px;
    }

    .ot-page .ot-table-wrapper{
        width: 100%;
        overflow: auto;
        max-height: 70vh;
        background: var(--ot-bg-table);
    }

    .ot-page .ot-scope .ot-table,
    .ot-page .ot-scope .ot-table *{
        font-size: var(--ot-font-body) !important;
        line-height: var(--ot-line) !important;
    }

    .ot-page .ot-scope .ot-table{
        min-width: 1700px;
        border-collapse: separate;
        border-spacing: 0;
        background: var(--ot-bg-table);
        color: var(--ot-text);
    }

    .ot-page .ot-scope table.ot-table > thead > tr > th{
        font-size: var(--ot-font-head) !important;
        padding: 3px 5px !important;
        font-weight: 800 !important;
        text-transform: uppercase !important;
        letter-spacing: .02em !important;
        white-space: nowrap !important;
        background: var(--ot-bg-head) !important;
        color: var(--ot-text-strong) !important;
        border-color: var(--ot-border-soft) !important;
        border-bottom: 2px solid var(--ot-border) !important;
        position: sticky;
        top: 0;
        z-index: 5;
    }

    .ot-page .ot-scope table.ot-table > tbody > tr > td{
        font-size: var(--ot-font-body) !important;
        padding: var(--ot-pad-y) var(--ot-pad-x) !important;
        white-space: nowrap !important;
        vertical-align: middle !important;
        border-color: var(--ot-border-soft) !important;
        color: var(--ot-text) !important;
        background: transparent !important;
    }

    .ot-page .ot-scope .table.table-sm > :not(caption) > * > *{
        padding: var(--ot-pad-y) var(--ot-pad-x) !important;
    }

    .ot-page .ot-scope table.ot-table > tbody > tr:nth-child(even){
        background: var(--ot-bg-zebra) !important;
    }

    .ot-page .ot-scope table.ot-table > tbody > tr:hover{
        background: var(--ot-bg-hover) !important;
    }

    .ot-page .ot-scope .truncate{
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        white-space: normal !important;
        display: block !important;
    }

    .ot-page .ot-scope .pill{
        display: inline-block;
        padding: 0 6px !important;
        border-radius: 999px !important;
        font-size: 9px !important;
        font-weight: 700 !important;
        background: var(--ot-pill-bg) !important;
        border: 1px solid var(--ot-border) !important;
        color: var(--ot-pill-text) !important;
    }

    .ot-page .ot-scope .badge,
    .ot-page .ot-scope .badge-ot{
        font-size: 9px !important;
        padding: 1px 6px !important;
        border-radius: 6px !important;
        font-weight: 800 !important;
        line-height: 1.05 !important;
    }

    .ot-page .ot-scope .badge-light{
        background: var(--ot-pill-bg) !important;
        color: var(--ot-pill-text) !important;
        border: 1px solid var(--ot-border) !important;
    }

    .ot-page .ot-scope .col-date{ width:100px; min-width:100px; }
    .ot-page .ot-scope .col-equipo{ width:220px; min-width:220px; }
    .ot-page .ot-scope .col-carga{ width:240px; min-width:240px; }
    .ot-page .ot-scope .col-traslado{ width:115px; min-width:115px; }
    .ot-page .ot-scope .col-ubicacion{ width:140px; min-width:140px; }
    .ot-page .ot-scope .col-cliente{ width:240px; min-width:240px; }
    .ot-page .ot-scope .col-money{ width:110px; min-width:110px; font-weight:800; color:var(--ot-text-money) !important; }
    .ot-page .ot-scope .col-id{
        width: 110px;
        min-width: 110px;
        font-weight: 800;
        color: var(--ot-text-strong) !important;
    }
    .ot-page .ot-scope .col-status{ width:110px; min-width:110px; }
    .ot-page .ot-scope .col-solicitante{ width:170px; min-width:170px; }
    .ot-page .ot-scope .col-conductor{ width:220px; min-width:220px; }
    .ot-page .ot-scope .col-oc{ width:100px; min-width:100px; }
    .ot-page .ot-scope .col-estado{ width:120px; min-width:120px; }
    .ot-page .ot-scope .col-gdd{ width:100px; min-width:100px; }
    .ot-page .ot-scope .col-afid{ width:240px; min-width:240px; }
    .ot-page .ot-scope .col-fact{ width:130px; min-width:130px; }

    .ot-page .ot-scope .col-cliente-text{
        font-weight: 900;
        color: var(--ot-text-strong) !important;
    }

    .ot-page .ot-scope .col-conductor-text{
        color: var(--ot-text-soft) !important;
    }

    .ot-page .ot-scope .nowrap{
        white-space: nowrap !important;
    }

    .ot-page .ot-scope .two-lines{
        white-space: normal !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        display: -webkit-box !important;
        -webkit-box-orient: vertical !important;
        -webkit-line-clamp: 2 !important;
        line-height: 1.1 !important;
        max-height: calc(2 * 1.1em) !important;
    }

    .ot-page .ot-scope .traslado-form,
    .ot-page .ot-scope .costo-ext-form{
        margin: 0;
    }

    .ot-page .ot-scope .traslado-select{
        width: 92px;
        min-width: 92px;
        max-width: 92px;
        border-radius: 999px !important;
        font-size: 9px !important;
        font-weight: 800 !important;
        text-align: center !important;
        text-align-last: center !important;
        padding: 1px 20px 1px 8px !important;
        height: 24px !important;
        outline: none !important;
        box-shadow: none !important;
        cursor: pointer;
        appearance: auto;
    }

    .ot-page .ot-scope .traslado-select.traslado-int{
        background: #d9efe0 !important;
        border: 1px solid #b7d8c1 !important;
        color: #245c37 !important;
    }

    .ot-page .ot-scope .traslado-select.traslado-ext{
        background: #f4ebc8 !important;
        border: 1px solid #e5d89b !important;
        color: #7a5a00 !important;
    }

    .ot-page .ot-scope .traslado-select.traslado-mix{
        background: #e4dcfa !important;
        border: 1px solid #cbbcf6 !important;
        color: #5b3aa8 !important;
    }

    .ot-page .ot-scope .traslado-select.traslado-empty{
        background: var(--ot-traslado-empty-bg) !important;
        border: 1px solid var(--ot-traslado-empty-border) !important;
        color: var(--ot-traslado-empty-text) !important;
    }

    .ot-page .ot-scope .costo-ext-wrap{
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .ot-page .ot-scope .costo-ext-prefix{
        font-size: 9px !important;
        font-weight: 800 !important;
        color: var(--ot-text-soft) !important;
    }

    .ot-page .ot-scope .costo-ext-input{
        width: 100%;
        min-width: 90px;
        height: 22px !important;
        padding: 1px 6px !important;
        border-radius: 8px !important;
        border: 1px solid var(--ot-input-border) !important;
        background: var(--ot-input-bg) !important;
        color: var(--ot-input-text) !important;
        text-align: right !important;
        font-size: 9px !important;
        font-weight: 700 !important;
        outline: none !important;
        box-shadow: none !important;
    }

    .ot-page .ot-scope .costo-ext-input.is-disabled{
        background: var(--ot-disabled-bg) !important;
        color: var(--ot-disabled-text) !important;
        border-color: var(--ot-disabled-border) !important;
        cursor: not-allowed;
    }

    .ot-page .pagination{
        margin-bottom: 0;
    }

    body.dark-mode .ot-page .page-link,
    .dark-mode .ot-page .page-link,
    body[class*="dark"] .ot-page .page-link{
        background-color: #2b333b;
        border-color: #47515c;
        color: #e5edf5;
    }

    body.dark-mode .ot-page .page-item.active .page-link,
    .dark-mode .ot-page .page-item.active .page-link,
    body[class*="dark"] .ot-page .page-item.active .page-link{
        background-color: #3b82f6;
        border-color: #3b82f6;
        color: #fff;
    }

    body.dark-mode .ot-page .page-item.disabled .page-link,
    .dark-mode .ot-page .page-item.disabled .page-link,
    body[class*="dark"] .ot-page .page-item.disabled .page-link{
        background-color: #232a31;
        border-color: #414b55;
        color: #7f8b97;
    }

    .ot-page .quick-actions .btn{
        min-width: 180px;
        font-weight: 700;
        border-radius: 10px;
        padding: 10px 14px;
    }

    .ot-page .home-topbar{
        gap: 1rem;
    }

    .ot-page .home-topbar__title{
        min-width: 0;
    }

    .ot-page .home-topbar__stats{
        min-width: 260px;
    }

    .ot-page .quick-actions .quick-actions-grid{
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: .75rem;
    }

    .ot-page .quick-actions .quick-action-btn{
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        min-height: 48px;
        font-weight: 700;
        border-radius: 10px;
        white-space: normal;
        line-height: 1.15;
        padding: .75rem .9rem;
    }

    .ot-page .quick-actions .quick-action-btn i{
        margin-right: .45rem;
    }

    @media (max-width: 991.98px){
        .ot-page .home-topbar{
            flex-direction: column;
            align-items: stretch !important;
        }

        .ot-page .home-topbar__stats{
            min-width: 0;
            width: 100%;
            text-align: left !important;
        }

        .ot-page .home-topbar__stats .d-flex{
            justify-content: flex-start !important;
        }

        .ot-page .quick-actions .quick-actions-grid{
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 575.98px){
        .ot-page .home-topbar{
            margin-bottom: 1rem !important;
        }

        .ot-page .home-topbar h3{
            font-size: 1.35rem;
        }

        .ot-page .home-topbar small{
            display: block;
            line-height: 1.35;
        }

        .ot-page .quick-actions .quick-actions-grid{
            grid-template-columns: 1fr;
        }

        .ot-page .quick-actions .quick-action-btn{
            width: 100%;
            justify-content: flex-start;
        }
    }
</style>
@endpush

@section('content')
@php
    $esChofer = auth()->user()->hasRole('chofer');
    $colspanTabla = $esChofer ? 11 : 20;
@endphp

<div class="container-fluid mt-4 ot-page">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-end mb-3 home-topbar">
        <div class="home-topbar__title">
            <h3 class="mb-0">
                @role('chofer')
                    Panel del conductor
                @else
                    Dashboard OT
                @endrole
            </h3>
            <small class="text-muted">
                @role('chofer')
                    Accesos rápidos y listado de tus órdenes de trabajo.
                @else
                    Listado operativo de Órdenes de Trabajo.
                @endrole
            </small>
        </div>

        <div class="text-right home-topbar__stats">
            <small class="text-muted d-block">Totales por estado (según filtros)</small>
            <div class="d-flex flex-wrap justify-content-end" style="gap:.35rem;">
                @foreach(($stats ?? []) as $k => $v)
                    @php
                        $badge = match($k) {
                            'pendiente'       => 'badge-warning',
                            'inicio_carga'    => 'badge-info',
                            'en_transito'     => 'badge-primary',
                            'con_incidencia'  => 'badge-danger',
                            'entregada'       => 'badge-success',
                            default           => 'badge-secondary'
                        };
                        $label = ucfirst(str_replace('_',' ',$k));
                    @endphp
                    <span class="badge badge-kpi {{ $badge }}">{{ $label }}: {{ number_format($v) }}</span>
                @endforeach
            </div>
        </div>
    </div>

    @role('chofer')
    <div class="card shadow-sm mb-3 ot-card quick-actions">
        <div class="card-body">
            <div class="mb-3">
                <h5 class="mb-0">Acciones rápidas</h5>
                <small class="text-muted">Accesos directos para registrar operaciones del conductor.</small>
            </div>

            <div class="quick-actions-grid">
                <a href="{{ route('inicio-cargas.create') }}" class="btn btn-primary quick-action-btn">
                    <i class="fas fa-dolly-flatbed"></i>
                    <span>Inicio de carga</span>
                </a>

                <a href="{{ route('entregas.create') }}" class="btn btn-success quick-action-btn">
                    <i class="fas fa-box-open"></i>
                    <span>Entrega</span>
                </a>

                <a href="{{ route('checklist-camions.create') }}" class="btn btn-warning quick-action-btn">
                    <i class="fas fa-clipboard-check"></i>
                    <span>Checklist camión</span>
                </a>

                <a href="{{ route('puentes.create') }}" class="btn btn-danger quick-action-btn">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>Incidencia</span>
                </a>
            </div>
        </div>
    </div>
    @endrole

    {{-- Filtros --}}
    <div class="card shadow-sm mb-3 ot-card">
        <div class="card-body">
            <form method="GET" action="{{ route('home') }}">
                <div class="form-row">
                    <div class="col-lg-4 col-md-6 mb-2">
                        <label class="small text-muted mb-1">Buscar</label>
                        <div class="input-icon">
                            <span class="input-icon__prefix"><i class="fas fa-search"></i></span>
                            <input type="text" name="q" value="{{ request('q') }}"
                                   class="form-control form-control-sm pl-4"
                                   placeholder="OT ID, cliente, conductor...">
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-6 mb-2">
                        <label class="small text-muted mb-1">Traslado</label>
                        <select name="traslado" class="form-control form-control-sm">
                            <option value="all" @selected(request('traslado', 'all') == 'all')>Todos</option>
                            <option value="interno" @selected(request('traslado') == 'interno')>Interno</option>
                            <option value="externo" @selected(request('traslado') == 'externo')>Externo</option>
                            <option value="interno_externo" @selected(request('traslado') == 'interno_externo')>Interno / Externo</option>
                        </select>
                    </div>

                    <div class="col-lg-2 col-md-6 mb-2">
                        <label class="small text-muted mb-1">Estado OC</label>
                        <select name="status" class="form-control form-control-sm">
                            @foreach($statusOptions as $val => $label)
                                <option value="{{ $val }}" @selected(request('status','all') == $val)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-2 col-md-6 mb-2">
                        <label class="small text-muted mb-1">Fecha (desde)</label>
                        <input type="date" name="from" value="{{ request('from') }}"
                               class="form-control form-control-sm">
                    </div>

                    <div class="col-lg-2 col-md-6 mb-2">
                        <label class="small text-muted mb-1">Fecha (hasta)</label>
                        <input type="date" name="to" value="{{ request('to') }}"
                               class="form-control form-control-sm">
                    </div>
                </div>

                <div class="d-flex justify-content-end align-items-center flex-wrap" style="gap:.5rem;">
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">Limpiar</a>

                    @unless($esChofer)
                        <a href="{{ route('home.export.excel', request()->query()) }}" class="btn btn-success btn-sm">
                            <i class="fas fa-file-excel mr-1"></i> Exportar Excel
                        </a>
                    @endunless

                    <button class="btn btn-primary btn-sm">
                        <i class="fas fa-filter mr-1"></i> Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabla OT --}}
    <div class="card shadow-sm ot-card ot-scope">
        <div class="card-header ot-card-header">
            <div class="d-flex justify-content-between align-items-center w-100">
                <div>
                    <strong>Órdenes de Trabajo</strong>
                    <small class="text-muted d-block"></small>
                </div>

                <div class="d-none d-md-flex align-items-center" style="gap:.5rem;">
                    <span class="text-muted small">Registros:</span>
                    <span class="pill-soft">{{ number_format($ots->total()) }}</span>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="ot-table-wrapper table-responsive">
                <table class="table table-sm table-bordered mb-0 ot-table">
                    <thead>
                        <tr>
                            <th class="col-id">OT</th>
                            <th class="col-equipo">Equipo</th>
                            <th class="col-traslado text-center">Traslado</th>
                            <th class="col-status text-center">Estado</th>
                            <th class="col-ubicacion">Desde</th>
                            <th class="col-ubicacion">Hasta</th>
                            <th class="col-cliente">Cliente</th>

                            @unless($esChofer)
                                <th class="col-money text-right">Valor</th>
                                <th class="col-money text-right">Costo EXT</th>
                            @endunless

                            <th class="col-id text-right">Cotiz.</th>
                            <th class="col-date">Fecha inicio carga</th>
                            <th class="col-solicitante">Solicitante</th>
                            <th class="col-conductor">Conductor</th>

                            @unless($esChofer)
                                <th class="col-oc">OC</th>
                                <th class="col-estado text-center">Estado OC</th>
                                <th class="col-gdd">GDD</th>
                                <th class="col-afid">AF/ID interno</th>
                                <th class="col-fact">Factura EXT</th>
                                <th class="col-fact">Factura</th>
                                <th class="col-date">Fecha Fact.</th>
                            @endunless
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ots as $ot)
                            @php
                                $cotizacion = $ot->cotizacion;

                                $clienteNombre = $cotizacion->cliente
                                    ?? optional(optional(optional($cotizacion)->solicitud)->cliente)->razon_social
                                    ?? '-';

                                $estadoValue = $ot->estado ?? null;
                                $estadoBadge = match($estadoValue) {
                                    'pendiente'       => 'badge-warning',
                                    'inicio_carga'    => 'badge-info',
                                    'en_transito'     => 'badge-primary',
                                    'con_incidencia'  => 'badge-danger',
                                    'entregada'       => 'badge-success',
                                    default           => 'badge-secondary'
                                };
                                $estadoLabel = $ot->estado_label ?? ($estadoValue ? ucfirst(str_replace('_',' ',$estadoValue)) : '-');

                                $equipo        = $ot->equipo ?? '-';
                                $trasladoTipo  = $ot->traslado ?? null;

                                $trasladoClass = match($trasladoTipo) {
                                    'interno'          => 'traslado-int',
                                    'externo'          => 'traslado-ext',
                                    'interno_externo'  => 'traslado-mix',
                                    default            => 'traslado-empty'
                                };

                                $desde         = optional($cotizacion)->origen ?? '-';
                                $hasta         = optional($cotizacion)->destino ?? '-';

                                $valor         = $ot->valor ?? null;
                                $costoExt      = $ot->costo_ext ?? null;
                                $cotizacionNro = optional($cotizacion)->id ?? null;

                                $fechaInicioCarga = optional($ot->inicioCargas->sortBy('created_at')->first())->created_at
                                    ?? optional($ot->inicioCargas->sortBy('fecha')->first())->fecha
                                    ?? null;

                                $statusValue    = $ot->status ?? '-';
                                $solicitante    = $ot->solicitante ?? optional($cotizacion)->solicitante ?? '-';
                                $conductor      = $ot->conductor ?? '-';
                                $oc             = $ot->oc ?? '-';
                                $gdd            = $ot->gdd ?? '-';
                                $afidInterno    = $ot->afid_interno ?? '-';
                                $facturaExterno = $ot->factura_externo ?? '-';
                                $factura        = $ot->factura ?? '-';
                                $fechaFactura   = $ot->fecha_factura ?? null;

                                $statusBadge = match($statusValue) {
                                    'ENTREGADO', 'entregado'     => 'badge-success',
                                    'EN TRANSITO', 'en_transito' => 'badge-primary',
                                    'PENDIENTE', 'pendiente'     => 'badge-warning',
                                    default                      => 'badge-light'
                                };

                                $costoExtValue = is_null($costoExt) ? '' : (int) $costoExt;
                                $costoExtReadonly = !in_array($trasladoTipo, ['externo', 'interno_externo']);
                            @endphp

                            <tr>
                                <td class="col-id text-nowrap">
                                    @if($ot->folio)
                                        <strong>{{ $ot->folio }}</strong>
                                    @else
                                        <strong>#{{ $ot->id }}</strong>
                                    @endif
                                </td>

                                <td class="col-equipo">
                                    <div class="two-lines" title="{{ $equipo }}">{{ $equipo }}</div>
                                </td>

                                <td class="col-traslado text-center nowrap">
                                    <form method="POST" action="{{ route('ots.updateTraslado', $ot->id) }}" class="traslado-form">                                        @csrf
                                        @method('PATCH')
                                        <select name="traslado"
                                                class="form-control form-control-sm traslado-select {{ $trasladoClass }}"
                                                onchange="this.form.submit()">
                                            <option value="" @selected(blank($trasladoTipo))>-</option>
                                            <option value="interno" @selected($trasladoTipo === 'interno')>INT</option>
                                            <option value="externo" @selected($trasladoTipo === 'externo')>EXT</option>
                                            <option value="interno_externo" @selected($trasladoTipo === 'interno_externo')>INT/EXT</option>
                                        </select>
                                    </form>
                                </td>

                                <td class="col-estado text-center nowrap">
                                    <span class="badge badge-ot {{ $estadoBadge }}">{{ $estadoLabel }}</span>
                                </td>

                                <td class="col-ubicacion">
                                    <div class="truncate" title="{{ $desde }}">{{ $desde }}</div>
                                </td>

                                <td class="col-ubicacion">
                                    <div class="truncate" title="{{ $hasta }}">{{ $hasta }}</div>
                                </td>

                                <td class="col-cliente">
                                    <div class="truncate col-cliente-text" title="{{ $clienteNombre }}">{{ $clienteNombre }}</div>
                                </td>

                                @unless($esChofer)
                                    <td class="col-money text-right text-nowrap">
                                        {{ is_null($valor) ? '-' : '$'.number_format($valor,0,',','.') }}
                                    </td>

                                    <td class="col-money text-right text-nowrap">
                                        <form method="POST" action="{{ route('ots.updateCostoExt', $ot->id) }}" class="costo-ext-form">
                                            @csrf
                                            @method('PATCH')
                                            <div class="costo-ext-wrap">
                                                <span class="costo-ext-prefix">$</span>
                                                <input type="number"
                                                       name="costo_ext"
                                                       min="0"
                                                       step="1"
                                                       value="{{ $costoExtValue }}"
                                                       class="form-control form-control-sm costo-ext-input {{ $costoExtReadonly ? 'is-disabled' : '' }}"
                                                       {{ $costoExtReadonly ? 'readonly' : '' }}
                                                       onblur="if(!this.readOnly){ this.form.submit(); }"
                                                       onkeydown="if(event.key === 'Enter'){ event.preventDefault(); this.form.submit(); }">
                                            </div>
                                        </form>
                                    </td>
                                @endunless

                                <td class="col-id text-right text-nowrap">
                                    {{ is_null($cotizacionNro) ? '-' : number_format($cotizacionNro) }}
                                </td>

                                <td class="col-date text-nowrap">
                                    {{ $fechaInicioCarga ? \Carbon\Carbon::parse($fechaInicioCarga)->format('d/m/y') : '-' }}
                                </td>

                                <td class="col-solicitante">
                                    <div class="truncate" title="{{ $solicitante }}">{{ $solicitante }}</div>
                                </td>

                                <td class="col-conductor">
                                    <div class="truncate col-conductor-text" title="{{ $conductor }}">{{ $conductor }}</div>
                                </td>

                                @unless($esChofer)
                                    <td class="col-oc nowrap">
                                        <div class="truncate" title="{{ $oc }}">{{ $oc }}</div>
                                    </td>

                                    <td class="col-status text-center nowrap">
                                        <span class="badge badge-ot {{ $statusBadge }}">{{ $statusValue }}</span>
                                    </td>

                                    <td class="col-gdd">
                                        <div class="truncate" title="{{ $gdd }}">{{ $gdd }}</div>
                                    </td>

                                    <td class="col-afid">
                                        <div class="truncate" title="{{ $afidInterno }}">{{ $afidInterno }}</div>
                                    </td>

                                    <td class="col-fact">
                                        <div class="truncate" title="{{ $facturaExterno }}">{{ $facturaExterno }}</div>
                                    </td>

                                    <td class="col-fact">
                                        <div class="truncate" title="{{ $factura }}">{{ $factura }}</div>
                                    </td>

                                    <td class="col-date text-nowrap">
                                        {{ $fechaFactura ? \Carbon\Carbon::parse($fechaFactura)->format('d/m/y') : '-' }}
                                    </td>
                                @endunless
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $colspanTabla }}" class="text-muted text-center py-4">
                                    No hay OT con los filtros actuales.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer d-flex flex-wrap justify-content-between align-items-center">
            <small class="text-muted">Mostrando {{ $ots->count() }} de {{ $ots->total() }} OT.</small>
            <div>{{ $ots->links() }}</div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function () {
    $('[data-toggle="tooltip"]').tooltip();

    function pintarTraslado($el) {
        $el.removeClass('traslado-int traslado-ext traslado-mix traslado-empty');

        if ($el.val() === 'interno') {
            $el.addClass('traslado-int');
        } else if ($el.val() === 'externo') {
            $el.addClass('traslado-ext');
        } else if ($el.val() === 'interno_externo') {
            $el.addClass('traslado-mix');
        } else {
            $el.addClass('traslado-empty');
        }
    }

    $('.traslado-select').each(function () {
        pintarTraslado($(this));
    });

    $(document).on('change', '.traslado-select', function () {
        pintarTraslado($(this));
    });
});
</script>
@endpush