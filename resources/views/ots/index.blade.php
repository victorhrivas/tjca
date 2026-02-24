@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>OTs</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-right"
                       href="{{ route('ots.create') }}">
                       Nuevo
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix mb-2"></div>

        {{-- CARD DE FILTROS --}}
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0" style="font-size: 0.95rem;">Filtros de búsqueda</h3>

                <a href="{{ route('ots.index') }}" class="btn btn-sm btn-outline-secondary">
                    Limpiar
                </a>
            </div>

            <div class="card-body">
                <form method="GET" action="{{ route('ots.index') }}">
                    <div class="row align-items-end">

                        {{-- Texto libre --}}
                        <div class="col-md-3 mb-2">
                            <label class="small text-muted">Texto libre</label>
                            <input type="text"
                                   name="q"
                                   class="form-control"
                                   placeholder="Cliente, origen, destino, conductor..."
                                   value="{{ request('q') }}">
                        </div>

                        {{-- Cliente (string en la OT) --}}
                        <div class="col-md-3 mb-2">
                            <label class="small text-muted">Cliente</label>
                            <input type="text"
                                   name="cliente"
                                   class="form-control"
                                   placeholder="Nombre cliente"
                                   value="{{ request('cliente') }}">
                        </div>

                        {{-- Estado --}}
                        <div class="col-md-3 mb-2">
                            <label class="small text-muted">Estado</label>
                            <select name="estado" class="form-control">
                                <option value="">Todos</option>
                                <option value="inicio_carga" {{ request('estado') == 'inicio_carga' ? 'selected' : '' }}>
                                    Inicio de carga
                                </option>
                                <option value="en_transito" {{ request('estado') == 'en_transito' ? 'selected' : '' }}>
                                    En tránsito
                                </option>
                                <option value="entregada" {{ request('estado') == 'entregada' ? 'selected' : '' }}>
                                    Entregada
                                </option>
                            </select>
                        </div>

                        {{-- Fecha servicio --}}
                        <div class="col-md-3 mb-2">
                            <label class="small text-muted">Fecha servicio</label>
                            <input type="date"
                                   name="fecha"
                                   class="form-control"
                                   value="{{ request('fecha') }}">
                        </div>

                        {{-- Botón --}}
                        <div class="col-md-3 mt-2 d-flex align-items-end">
                            <button class="btn btn-primary btn-block">
                                Filtrar
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        {{-- TABLA --}}
        <div class="card">
            @include('ots.table')
        </div>
    </div>

@endsection
