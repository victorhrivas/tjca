@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Solicitudes</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-right"
                       href="{{ route('solicituds.create') }}">
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

                {{-- Botón limpiar filtros --}}
                <a href="{{ route('solicituds.index') }}" class="btn btn-sm btn-outline-secondary">
                    Limpiar
                </a>
            </div>

            <div class="card-body">
                <form method="GET" action="{{ route('solicituds.index') }}">
                    <div class="row align-items-end">

                        {{-- Búsqueda general --}}
                        <div class="col-md-3 mb-2">
                            <label class="small text-muted">Texto libre</label>
                            <input type="text"
                                name="q"
                                class="form-control"
                                placeholder="Cliente, origen, destino..."
                                value="{{ request('q') }}">
                        </div>

                        {{-- Cliente --}}
                        <div class="col-md-3 mb-2">
                            <label class="small text-muted">Cliente</label>
                            <select name="cliente_id" class="form-control">
                                <option value="">Todos los clientes</option>
                                @foreach($clientes as $id => $nombre)
                                    <option value="{{ $id }}" {{ request('cliente_id') == $id ? 'selected' : '' }}>
                                        {{ $nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Estado --}}
                        <div class="col-md-2 mb-2">
                            <label class="small text-muted">Estado</label>
                            <select name="estado" class="form-control">
                                <option value="">Todos</option>
                                <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="aprobada" {{ request('estado') == 'aprobada' ? 'selected' : '' }}>Aprobada</option>
                                <option value="fallida"  {{ request('estado') == 'fallida'  ? 'selected' : '' }}>Fallida</option>
                            </select>
                        </div>

                        {{-- Fecha --}}
                        <div class="col-md-2 mb-2">
                            <label class="small text-muted">Fecha creación</label>
                            <input type="date"
                                name="fecha"
                                class="form-control"
                                value="{{ request('fecha') }}">
                        </div>

                        {{-- Botón filtrar --}}
                        <div class="col-md-2 mb-2 mt-md-0 d-flex align-items-end">
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
            @include('solicituds.table')
        </div>
    </div>

@endsection
