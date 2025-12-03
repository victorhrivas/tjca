{{-- resources/views/inicio_cargas/show.blade.php --}}
@extends('layouts.app')

@section('content')
    {{-- Header --}}
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="mb-0">Detalle inicio de carga</h1>
                    <small class="text-muted">
                        OT #{{ $inicioCarga->ot_id }}
                    </small>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('operacion.inicio-carga.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Volver al listado
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Content --}}
    <div class="content px-3">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title mb-0">
                    <i class="fas fa-truck-loading mr-1"></i>
                    Información general
                </h3>
            </div>

            <div class="card-body">
                <div class="row">

                    {{-- Columna izquierda --}}
                    <div class="col-md-6">

                        <div class="mb-3">
                            <h6 class="text-muted mb-1">OT asociada</h6>
                            <p class="mb-0 font-weight-bold">
                                #{{ $inicioCarga->ot_id }}
                            </p>
                        </div>

                        <div class="mb-3">
                            <h6 class="text-muted mb-1">Cliente</h6>
                            <p class="mb-0 font-weight-bold">
                                {{ $inicioCarga->cliente ?: '-' }}
                            </p>
                        </div>

                        <div class="mb-3">
                            <h6 class="text-muted mb-1">Contacto</h6>
                            <p class="mb-0">
                                {{ $inicioCarga->contacto ?: '-' }}<br>
                                @if($inicioCarga->telefono_contacto)
                                    <span class="text-muted">
                                        <i class="fas fa-phone mr-1"></i>{{ $inicioCarga->telefono_contacto }}
                                    </span><br>
                                @endif
                                @if($inicioCarga->correo_contacto)
                                    <span class="text-muted">
                                        <i class="fas fa-envelope mr-1"></i>{{ $inicioCarga->correo_contacto }}
                                    </span>
                                @endif
                                @if(
                                    !$inicioCarga->contacto &&
                                    !$inicioCarga->telefono_contacto &&
                                    !$inicioCarga->correo_contacto
                                )
                                    <span class="text-muted">Sin información de contacto</span>
                                @endif
                            </p>
                        </div>

                        <div class="mb-3">
                            <h6 class="text-muted mb-1">Tipo de carga</h6>
                            <p class="mb-0">
                                {{ $inicioCarga->tipo_carga ?: '-' }}
                            </p>
                        </div>

                        <div class="mb-0">
                            <h6 class="text-muted mb-1">Peso aproximado</h6>
                            <p class="mb-0">
                                {{ $inicioCarga->peso_aproximado ?: '-' }}
                            </p>
                        </div>

                    </div>

                    {{-- Columna derecha --}}
                    <div class="col-md-6">

                        <div class="mb-3">
                            <h6 class="text-muted mb-1">Origen</h6>
                            <p class="mb-0">
                                <i class="fas fa-warehouse mr-1 text-muted"></i>
                                {{ $inicioCarga->origen ?: '-' }}
                            </p>
                        </div>

                        <div class="mb-3">
                            <h6 class="text-muted mb-1">Destino</h6>
                            <p class="mb-0">
                                <i class="fas fa-map-marker-alt mr-1 text-muted"></i>
                                {{ $inicioCarga->destino ?: '-' }}
                            </p>
                        </div>

                        <div class="mb-3">
                            <h6 class="text-muted mb-1">Fecha de carga</h6>
                            <p class="mb-0">
                                {{ $inicioCarga->fecha_carga ?: '-' }}
                            </p>
                        </div>

                        <div class="mb-3">
                            <h6 class="text-muted mb-1">Hora de presentación</h6>
                            <p class="mb-0">
                                {{ $inicioCarga->hora_presentacion ?: '-' }}
                            </p>
                        </div>

                        <div class="mb-0">
                            <h6 class="text-muted mb-1">Observaciones</h6>
                            <p class="mb-0">
                                {{ $inicioCarga->observaciones ?: 'Sin observaciones' }}
                            </p>
                        </div>

                    </div>

                </div>
            </div>

            <div class="card-footer text-right">
                <a href="{{ route('operacion.inicio-carga.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Volver
                </a>
            </div>
        </div>
    </div>
@endsection
