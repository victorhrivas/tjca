@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Detalles de Entrega</h1>
            </div>
            <div class="col-sm-6">
                <a href="{{ route('operacion.entrega.index') }}"
                   class="btn btn-secondary float-right">
                    Volver
                </a>
            </div>
        </div>
    </div>
</section>

<div class="content px-3">
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row">

                <!-- Información General -->
                <div class="col-md-6">
                    <h5><strong>Información General</strong></h5>
                    <hr>

                    <p><strong>OT ID:</strong> {{ $entrega->ot_id }}</p>
                    <p><strong>Cliente:</strong> {{ $entrega->cliente }}</p>
                    <p><strong>Lugar de Entrega:</strong> {{ $entrega->lugar_entrega }}</p>
                    <p><strong>Fecha de Entrega:</strong> {{ $entrega->fecha_entrega }}</p>
                    <p><strong>Hora de Entrega:</strong> {{ $entrega->hora_entrega }}</p>
                    <p><strong>Conforme:</strong> {{ $entrega->conforme ? 'Sí' : 'No' }}</p>
                </div>

                <!-- Receptor -->
                <div class="col-md-6">
                    <h5><strong>Receptor</strong></h5>
                    <hr>

                    <p><strong>Nombre:</strong> {{ $entrega->nombre_receptor }}</p>
                    <p><strong>RUT:</strong> {{ $entrega->rut_receptor }}</p>
                    <p><strong>Teléfono:</strong> {{ $entrega->telefono_receptor }}</p>
                    <p><strong>Correo:</strong> {{ $entrega->correo_receptor }}</p>
                </div>

            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <h5><strong>Observaciones</strong></h5>
                    <hr>
                    <p>{{ $entrega->observaciones ?? 'Sin observaciones.' }}</p>
                </div>
            </div>

        </div>

        <div class="card-footer">
            <a href="{{ route('operacion.entrega.index') }}"
               class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Volver al listado
            </a>
        </div>
    </div>
</div>
@endsection
