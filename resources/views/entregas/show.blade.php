{{-- resources/views/entregas/show.blade.php --}}
@extends('layouts.app')

@section('content')
    <style>
        .image-overlay {
            position: fixed;
            inset: 0;
            z-index: 1050;
            display: none;
            align-items: center;
            justify-content: center;
        }
        .image-overlay-backdrop {
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.75);
        }
        .image-overlay-content {
            position: relative;
            z-index: 1051;
            max-width: 90vw;
            max-height: 90vh;
            background: #101114;
            border-radius: 12px;
            border: 1px solid #2c3139;
            box-shadow: 0 18px 45px rgba(0,0,0,.7);
            padding: 12px;
            display: flex;
            flex-direction: column;
        }
        .image-overlay-close {
            position: absolute;
            top: 6px;
            right: 10px;
            border: none;
            background: transparent;
            color: #e6e7ea;
            font-size: 1.6rem;
            line-height: 1;
            cursor: pointer;
        }
        .image-overlay-title {
            color: #e6e7ea;
            font-size: .95rem;
            margin-bottom: 8px;
            padding-right: 26px;
        }
        .image-overlay-img-wrap {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .image-overlay-img {
            max-width: 100%;
            max-height: 80vh;
            border-radius: 10px;
            object-fit: contain;
        }
    </style>

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
                    {{-- Información General --}}
                    <div class="col-md-6">
                        <h5><strong>Información General</strong></h5>
                        <p><strong>OT ID:</strong> {{ optional($entrega->ot)->folio ?? '-' }}</p>
                        <p><strong>Cliente:</strong> {{ $entrega->cliente }}</p>
                        <p><strong>Lugar de Entrega:</strong> {{ $entrega->lugar_entrega }}</p>
                        <p><strong>Fecha de Entrega:</strong>
                            @if($entrega->fecha_entrega)
                                {{ \Carbon\Carbon::parse($entrega->fecha_entrega)->format('d/m/Y') }}
                            @else
                                -
                            @endif
                        </p>
                        <p><strong>Hora de Entrega:</strong> {{ $entrega->hora_entrega ?? '-' }}</p>
                        <p><strong>Conforme:</strong> {{ $entrega->conforme ? 'Sí' : 'No' }}</p>
                    </div>

                    {{-- Receptor --}}
                    <div class="col-md-6">
                        <h5><strong>Receptor</strong></h5>
                        <hr>
                        <p><strong>Nombre:</strong> {{ $entrega->nombre_receptor }}</p>
                    </div>
                </div>

                {{-- Observaciones --}}
                <div class="row mt-4">
                    <div class="col-md-12">
                        <h5><strong>Observaciones</strong></h5>
                        <hr>
                        <p>{{ $entrega->observaciones ?? 'Sin observaciones.' }}</p>
                    </div>
                </div>


                {{-- Fotos de la carga --}}
                @if($entrega->foto_1 || $entrega->foto_2 || $entrega->foto_3)
                    <hr class="mt-4 mb-3">

                    <div class="card card-outline" style="border-color: rgba(255,255,255,0.06);">
                        <div class="card-header" style="border-bottom-color: rgba(255,255,255,0.06);">
                            <h3 class="card-title mb-0">
                                <i class="fas fa-images mr-1"></i>
                                Imágenes de la carga
                            </h3>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                @foreach (['foto_1', 'foto_2', 'foto_3'] as $foto)
                                    @if(!empty($entrega->$foto))
                                        <div class="col-md-4 mb-3">
                                            <div class="card bg-dark border-0 shadow-sm h-100">
                                                <div class="card-body p-2 d-flex align-items-center justify-content-center">
                                                    <img src="{{ asset('storage/'.$entrega->$foto) }}"
                                                         alt="Foto de inicio de carga"
                                                         class="img-fluid rounded"
                                                         style="max-height: 220px; object-fit: cover; cursor:pointer;"
                                                         onclick="openImageOverlay('{{ asset('storage/'.$entrega->$foto) }}')">
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <small class="text-muted">
                                Haz clic sobre una imagen para verla en grande.
                            </small>
                        </div>
                    </div>
                @endif

                {{-- Foto guía de despacho --}}
                @if(!empty($entrega->foto_guia_despacho))
                    <hr class="mt-4 mb-3">

                    <div class="card card-outline" style="border-color: rgba(255,255,255,0.06);">
                        <div class="card-header" style="border-bottom-color: rgba(255,255,255,0.06);">
                            <h3 class="card-title mb-0">
                                <i class="fas fa-file-alt mr-1"></i>
                                Guía de despacho
                            </h3>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="card bg-dark border-0 shadow-sm h-100">
                                        <div class="card-body p-2 d-flex align-items-center justify-content-center">
                                            <img src="{{ asset('storage/'.$entrega->foto_guia_despacho) }}"
                                                alt="Foto guía de despacho"
                                                class="img-fluid rounded"
                                                style="max-height: 220px; object-fit: cover; cursor:pointer;"
                                                onclick="openImageOverlay('{{ asset('storage/'.$entrega->foto_guia_despacho) }}')">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <small class="text-muted">
                                Haz clic sobre la imagen para verla en grande.
                            </small>
                        </div>
                    </div>
                @endif

            </div>

            <div class="card-footer">
                <a href="{{ route('operacion.entrega.index') }}"
                   class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Volver al listado
                </a>
            </div>
        </div>
    </div>

    {{-- Overlay de imagen (igual al de inicio_cargas) --}}
    <div id="imageOverlay" class="image-overlay" onclick="overlayBackdropClick(event)">
        <div class="image-overlay-backdrop"></div>
        <div class="image-overlay-content">
            <button type="button" class="image-overlay-close" onclick="closeImageOverlay()">
                &times;
            </button>
            <div class="image-overlay-title">
                Vista de imagen
            </div>
            <div class="image-overlay-img-wrap">
                <img id="overlayImage" src="" alt="Imagen ampliada" class="image-overlay-img">
            </div>
        </div>
    </div>

    <script>
        function openImageOverlay(src) {
            var overlay = document.getElementById('imageOverlay');
            var img = document.getElementById('overlayImage');

            img.src = src;
            overlay.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeImageOverlay() {
            var overlay = document.getElementById('imageOverlay');
            var img = document.getElementById('overlayImage');

            overlay.style.display = 'none';
            img.src = '';
            document.body.style.overflow = '';
        }

        function overlayBackdropClick(event) {
            if (event.target.id === 'imageOverlay') {
                closeImageOverlay();
            }
        }
    </script>
@endsection
