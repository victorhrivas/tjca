{{-- resources/views/checklist_camions/show.blade.php --}}
@extends('layouts.app')

@section('content')
    {{-- Header --}}
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="mb-0">Detalle checklist de camión</h1>
                    <small class="text-muted">
                        Checklist #{{ $checklist->id }}
                    </small>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('operacion.checklist.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Volver al listado
                    </a>
                </div>
            </div>
        </div>
    </section>

    @php
        $estadoLabel = [
            'buen_estado' => 'Buen estado',
            'mal_estado'  => 'Mal estado',
            'vigente'     => 'Vigente',
            'vencido'     => 'Vencido',
        ];

        $nivelAceiteLabel = [
            'bajo'   => 'Bajo',
            '1'      => '1',
            '2'      => '2',
            '3'      => '3',
            '4'      => '4',
            '5'      => '5',
            'normal' => 'Normal',
        ];

        function labelEstado($valor, $map) {
            return $valor && isset($map[$valor]) ? $map[$valor] : ($valor ?: '-');
        }
    @endphp

    {{-- Content --}}
    <div class="content px-3">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title mb-0">
                    <i class="fas fa-clipboard-check mr-1"></i>
                    Información del checklist
                </h3>
            </div>

            <div class="card-body">
                <div class="row">
                    {{-- Columna izquierda --}}
                    <div class="col-md-6">
                        <h6 class="text-muted text-uppercase">Datos generales</h6>
                        <hr class="mt-1 mb-2">

                        <p class="mb-2">
                            <strong>Conductor:</strong><br>
                            {{ $checklist->nombre_conductor ?: '-' }}
                        </p>

                        <p class="mb-2">
                            <strong>Patente:</strong><br>
                            {{ $checklist->patente ?: '-' }}
                        </p>

                        <p class="mb-2">
                            <strong>Kilometraje:</strong><br>
                            {{ $checklist->kilometraje ?: '-' }}
                        </p>

                        <p class="mb-2">
                            <strong>Nivel de aceite:</strong><br>
                            {{ labelEstado($checklist->nivel_aceite, $nivelAceiteLabel) }}
                        </p>

                        <h6 class="text-muted text-uppercase mt-4">Iluminación y frenos</h6>
                        <hr class="mt-1 mb-2">

                        <p class="mb-1">
                            <strong>Luces altas / bajas:</strong><br>
                            {{ labelEstado($checklist->luces_altas_bajas, $estadoLabel) }}
                        </p>

                        <p class="mb-1">
                            <strong>Intermitentes:</strong><br>
                            {{ labelEstado($checklist->intermitentes, $estadoLabel) }}
                        </p>

                        <p class="mb-1">
                            <strong>Luces de posición:</strong><br>
                            {{ labelEstado($checklist->luces_posicion, $estadoLabel) }}
                        </p>

                        <p class="mb-1">
                            <strong>Luces de freno:</strong><br>
                            {{ labelEstado($checklist->luces_freno, $estadoLabel) }}
                        </p>

                        <p class="mb-1">
                            <strong>Sistema de frenos:</strong><br>
                            {{ labelEstado($checklist->sistema_frenos, $estadoLabel) }}
                        </p>
                    </div>

                    {{-- Columna derecha --}}
                    <div class="col-md-6">
                        <h6 class="text-muted text-uppercase">Neumáticos y estructura</h6>
                        <hr class="mt-1 mb-2">

                        <p class="mb-2">
                            <strong>Estado general de neumáticos:</strong><br>
                            {{ $checklist->estado_neumaticos ?: '-' }}
                        </p>

                        <p class="mb-1">
                            <strong>Neumático de repuesto:</strong><br>
                            {{ labelEstado($checklist->neumatico_repuesto, $estadoLabel) }}
                        </p>

                        <p class="mb-1">
                            <strong>Estado de tablones (camas bajas):</strong><br>
                            {{ labelEstado($checklist->estado_tablones, $estadoLabel) }}
                        </p>

                        <h6 class="text-muted text-uppercase mt-4">Visibilidad y cabina</h6>
                        <hr class="mt-1 mb-2">

                        <p class="mb-1">
                            <strong>Espejos retrovisores:</strong><br>
                            {{ labelEstado($checklist->estado_espejos, $estadoLabel) }}
                        </p>

                        <p class="mb-1">
                            <strong>Parabrisas:</strong><br>
                            {{ labelEstado($checklist->parabrisas, $estadoLabel) }}
                        </p>

                        <p class="mb-1">
                            <strong>Calefacción / A.C.:</strong><br>
                            {{ labelEstado($checklist->calefaccion_ac, $estadoLabel) }}
                        </p>

                        <p class="mb-1">
                            <strong>Asiento del conductor:</strong><br>
                            {{ labelEstado($checklist->asiento_conductor, $estadoLabel) }}
                        </p>

                        <h6 class="text-muted text-uppercase mt-4">Sistema de aire y seguridad</h6>
                        <hr class="mt-1 mb-2">

                        <p class="mb-1">
                            <strong>Acumulación sistema de aire:</strong><br>
                            {{ labelEstado($checklist->acumulacion_aire, $estadoLabel) }}
                        </p>

                        <p class="mb-1">
                            <strong>Extintor:</strong><br>
                            {{ labelEstado($checklist->extintor, $estadoLabel) }}
                        </p>

                        <p class="mb-1">
                            <strong>Conos y cuñas de seguridad:</strong><br>
                            {{ labelEstado($checklist->conos_cunas, $estadoLabel) }}
                        </p>

                        <p class="mb-1">
                            <strong>Trinquetes y cadenas:</strong><br>
                            {{ labelEstado($checklist->trinquetes_cadenas, $estadoLabel) }}
                        </p>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <h6 class="text-muted text-uppercase">Ruidos en el motor</h6>
                        <hr class="mt-1 mb-2">
                        <p class="mb-0">
                            {{ $checklist->ruidos_motor ?: 'Sin observaciones.' }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted text-uppercase">Detalle de puntos en mal estado</h6>
                        <hr class="mt-1 mb-2">
                        <p class="mb-0">
                            {{ $checklist->detalle_mal_estado ?: 'Sin detalles adicionales.' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="card-footer text-right">
                <a href="{{ route('operacion.checklist.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Volver
                </a>
            </div>
        </div>
    </div>
@endsection
