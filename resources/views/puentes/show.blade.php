@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Detalle de Puente #{{ $puente->id }}</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('puentes.index') }}" class="btn btn-default">Volver</a>
                <a href="{{ route('puentes.edit', $puente->id) }}" class="btn btn-primary">Editar</a>
            </div>
        </div>
    </div>
</section>

<div class="content px-3">
    <div class="card">
        <div class="card-body">
            @php
                $ot = $puente->ot;
                $vehiculo = $puente->otVehiculo;
            @endphp

            <div class="row">
                <div class="col-md-6">
                    <strong>OT</strong>
                    <p>{{ $ot?->folio ?: ($ot ? '#'.$ot->id : '—') }}</p>
                </div>

                <div class="col-md-6">
                    <strong>Cliente</strong>
                    <p>{{ $ot?->cliente ?: optional(optional(optional($ot?->cotizacion)->solicitud)->cliente)->razon_social ?: '—' }}</p>
                </div>

                <div class="col-md-6">
                    <strong>Vehículo afectado</strong>
                    <p>
                        @if($vehiculo)
                            {{ $vehiculo->conductor ?: 'Sin conductor' }}<br>
                            Camión: {{ $vehiculo->patente_camion ?: '—' }}
                            @if($vehiculo->patente_remolque)
                                <br>Remolque: {{ $vehiculo->patente_remolque }}
                            @endif
                        @else
                            —
                        @endif
                    </p>
                </div>

                <div class="col-md-6">
                    <strong>Fase</strong>
                    <p>{{ ucfirst(str_replace('_', ' ', $puente->fase)) }}</p>
                </div>

                <div class="col-md-6">
                    <strong>Motivo</strong>
                    <p>{{ ucfirst(str_replace('_', ' ', $puente->motivo)) }}</p>
                </div>

                <div class="col-md-6">
                    <strong>Notificar cliente</strong>
                    <p>{{ $puente->notificar_cliente ? 'Sí' : 'No' }}</p>
                </div>

                <div class="col-md-6">
                    <strong>Nuevo chofer</strong>
                    <p>{{ $puente->nuevo_conductor ?: '—' }}</p>
                </div>

                <div class="col-md-6">
                    <strong>Nuevo camión / remolque</strong>
                    <p>
                        Camión: {{ $puente->nueva_patente_camion ?: '—' }}<br>
                        Remolque: {{ $puente->nueva_patente_remolque ?: '—' }}
                    </p>
                </div>

                <div class="col-md-12">
                    <strong>Detalle</strong>
                    <p style="white-space: pre-line;">{{ $puente->detalle ?: '—' }}</p>
                </div>

                <div class="col-md-6">
                    <strong>Fecha</strong>
                    <p>{{ optional($puente->created_at)->format('d-m-Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection