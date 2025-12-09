{{-- resources/views/inicio_cargas/show.blade.php --}}
@extends('layouts.app')

@section('content')
    <style>
        /* Overlay tipo modal para imágenes */
        .image-overlay {
            position: fixed;
            inset: 0;
            z-index: 1050;
            display: none;              /* se muestra con display:flex desde JS */
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

    {{-- Header --}}
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="mb-0">Detalle inicio de carga</h1>
                    <small class="text-muted d-block">
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
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">
                    <i class="fas fa-truck-loading mr-1"></i>
                    Información general
                </h3>

                <div class="text-right">
                    <small class="text-muted d-block">
                        Registrado el:
                        {{ optional($inicioCarga->created_at)->format('d/m/Y H:i') ?? '-' }}
                    </small>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    {{-- Columna izquierda --}}
                    <div class="col-md-6 border-right">
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
                                    <span class="text-muted d-block">
                                        <i class="fas fa-phone mr-1"></i>{{ $inicioCarga->telefono_contacto }}
                                    </span>
                                @endif
                                @if($inicioCarga->correo_contacto)
                                    <span class="text-muted d-block">
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
                                @if($inicioCarga->fecha_carga)
                                    {{ \Carbon\Carbon::parse($inicioCarga->fecha_carga)->format('d/m/Y') }}
                                @else
                                    -
                                @endif
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

                {{-- Fotos de la carga --}}
                @if($inicioCarga->foto_1 || $inicioCarga->foto_2 || $inicioCarga->foto_3)
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
                                    @if(!empty($inicioCarga->$foto))
                                        <div class="col-md-4 mb-3">
                                            <div class="card bg-dark border-0 shadow-sm h-100">
                                                <div class="card-body p-2 d-flex align-items-center justify-content-center">
                                                    <img src="{{ asset('storage/'.$inicioCarga->$foto) }}"
                                                         alt="Foto de inicio de carga"
                                                         class="img-fluid rounded"
                                                         style="max-height: 220px; object-fit: cover; cursor:pointer;"
                                                         onclick="openImageOverlay('{{ asset('storage/'.$inicioCarga->$foto) }}')">
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
            </div>

            <div class="card-footer text-right">
                <a href="{{ route('operacion.inicio-carga.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Volver
                </a>
            </div>
        </div>
    </div>

    {{-- Overlay propio para ver imagen en grande --}}
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
            document.body.style.overflow = 'hidden'; // bloquear scroll de fondo
        }

        function closeImageOverlay() {
            var overlay = document.getElementById('imageOverlay');
            var img = document.getElementById('overlayImage');

            overlay.style.display = 'none';
            img.src = '';
            document.body.style.overflow = ''; // restaurar scroll
        }

        // Cerrar haciendo clic fuera del cuadro
        function overlayBackdropClick(event) {
            // si se hace clic directamente en el overlay (fondo) y no en el contenido interno
            if (event.target.id === 'imageOverlay') {
                closeImageOverlay();
            }
        }
    </script>
@endsection
