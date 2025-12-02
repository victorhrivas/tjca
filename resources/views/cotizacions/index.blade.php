@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Cotizaciones</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-right"
                       href="{{ route('cotizacions.create') }}">
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

                <a href="{{ route('cotizacions.index') }}" class="btn btn-sm btn-outline-secondary">
                    Limpiar
                </a>
            </div>

            <div class="card-body">
                <form method="GET" action="{{ route('cotizacions.index') }}">
                    <div class="row align-items-end">

                        {{-- Texto libre --}}
                        <div class="col-md-2 mb-2">
                            <label class="small text-muted">Texto libre</label>
                            <input type="text"
                                   name="q"
                                   class="form-control"
                                   placeholder="Cliente, origen, monto..."
                                   value="{{ request('q') }}">
                        </div>

                        {{-- Cliente --}}
                        <div class="col-md-2 mb-2">
                            <label class="small text-muted">Cliente</label>
                            <select name="cliente_id" class="form-control">
                                <option value="">Todos</option>
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
                                <option value="enviada"   {{ request('estado') == 'enviada'   ? 'selected' : '' }}>Enviada</option>
                                <option value="aceptada"  {{ request('estado') == 'aceptada'  ? 'selected' : '' }}>Aceptada</option>
                                <option value="rechazada" {{ request('estado') == 'rechazada' ? 'selected' : '' }}>Rechazada</option>
                            </select>
                        </div>

                        {{-- Fecha creación --}}
                        <div class="col-md-2 mb-2">
                            <label class="small text-muted">Fecha creación</label>
                            <input type="date"
                                   name="fecha"
                                   class="form-control"
                                   value="{{ request('fecha') }}">
                        </div>

                        {{-- OT --}}
                        <div class="col-md-2 mb-2">
                            <label class="small text-muted">OT asociada</label>
                            <select name="ot" class="form-control">
                                <option value="">Todas</option>
                                <option value="con" {{ request('ot') === 'con' ? 'selected' : '' }}>Con OT</option>
                                <option value="sin" {{ request('ot') === 'sin' ? 'selected' : '' }}>Sin OT</option>
                            </select>
                        </div>

                        {{-- Botón --}}
                        <div class="col-md-2 mb-2 d-flex align-items-end">
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
            @include('cotizacions.table')
        </div>
    </div>

@endsection
