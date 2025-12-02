@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="mb-0">Detalle de cotización</h1>
                    <small class="text-muted">
                        Cotización #{{ $cotizacion->id }}
                    </small>
                </div>
                <div class="col-sm-6 text-sm-right mt-3 mt-sm-0">
                    <a href="{{ route('cotizacions.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left mr-1"></i> Volver al listado
                    </a>

                    <a href="{{ route('cotizacions.edit', $cotizacion->id) }}" class="btn btn-primary btn-sm ml-1">
                        <i class="fas fa-edit mr-1"></i> Editar
                    </a>

                    <a href="{{ route('cotizacions.pdf', $cotizacion->id) }}" class="btn btn-danger btn-sm ml-1" target="_blank">
                        <i class="fas fa-file-pdf mr-1"></i> PDF
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <div class="card shadow-sm border-0">
                        <div class="card-header d-flex justify-content-between align-items-center" style="border-bottom: 1px solid #e5e5e5;">
                            <div>
                                <h3 class="card-title mb-0">
                                    Cotización #{{ $cotizacion->id }}
                                </h3>
                                <small class="text-muted">
                                    Creada el {{ optional($cotizacion->created_at)->format('d/m/Y H:i') }}
                                </small>
                            </div>
                            <span class="badge badge-pill {{ $cotizacion->estado_badge_class ?? 'badge-secondary' }} px-3 py-2">
                                {{ $cotizacion->estado_label ?? ucfirst($cotizacion->estado) }}
                            </span>
                        </div>

                        <div class="card-body">
                            @include('cotizacions.show_fields')
                        </div>

                        <div class="card-footer d-flex justify-content-between align-items-center" style="border-top: 1px solid #e5e5e5;">
                            <small class="text-muted">
                                Última actualización: {{ optional($cotizacion->updated_at)->format('d/m/Y H:i') }}
                            </small>

                            <div>
                                <a href="{{ route('cotizacions.index') }}" class="btn btn-sm btn-outline-secondary">
                                    Volver
                                </a>
                                <a href="{{ route('cotizacions.edit', $cotizacion->id) }}" class="btn btn-sm btn-primary ml-1">
                                    Editar cotización
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
