{{-- resources/views/ots/show.blade.php --}}
@extends('layouts.app')

@section('content')
    {{-- Estilos para overlay de imágenes (mismo estilo que entregas) --}}
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

    {{-- Header --}}
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="mb-0">Detalle de OT</h1>
                    <small class="text-muted">
                        OT #{{ $ot->id }}
                    </small>
                </div>
                <div class="col-sm-6 text-sm-right mt-3 mt-sm-0">
                    <a href="{{ route('ots.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left mr-1"></i> Volver al listado
                    </a>

                    <a href="{{ route('ots.edit', $ot->id) }}" class="btn btn-primary btn-sm ml-1">
                        <i class="fas fa-edit mr-1"></i> Editar
                    </a>

                    <a href="{{ route('ots.pdf', $ot->id) }}" class="btn btn-danger btn-sm ml-1" target="_blank">
                        <i class="fas fa-file-pdf mr-1"></i> PDF
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Contenido principal --}}
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <div class="card shadow-sm border-0">
                        <div class="card-header d-flex justify-content-between align-items-center" style="border-bottom:1px solid #e5e5e5;">
                            <div>
                                <h3 class="card-title mb-0">
                                    Orden de trabajo #{{ $ot->id }}
                                </h3>
                                <small class="text-muted">
                                    Creada el {{ optional($ot->created_at)->format('d/m/Y H:i') }}
                                </small>
                            </div>
                            <span class="badge badge-pill {{ $ot->estado_badge_class ?? 'badge-secondary' }} px-3 py-2">
                                {{ $ot->estado_label ?? ucwords(str_replace('_',' ',$ot->estado)) }}
                            </span>
                        </div>

                        <div class="card-body">
                            @include('ots.show_fields')
                        </div>

                        <div class="card-footer d-flex justify-content-between align-items-center" style="border-top:1px solid #e5e5e5;">
                            <small class="text-muted">
                                Última actualización: {{ optional($ot->updated_at)->format('d/m/Y H:i') }}
                            </small>
                            <div>
                                <a href="{{ route('ots.index') }}" class="btn btn-sm btn-outline-secondary">
                                    Volver
                                </a>
                                <a href="{{ route('ots.edit', $ot->id) }}" class="btn btn-sm btn-primary ml-1">
                                    Editar OT
                                </a>
                                <a href="{{ route('ots.pdf', $ot->id) }}" class="btn btn-sm btn-danger ml-1" target="_blank">
                                    PDF
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Aquí puedes agregar otras tarjetas relacionadas si lo necesitas --}}
                </div>
            </div>
        </div>
    </section>

    {{-- Overlay de imagen reutilizable (igual patrón que entregas/inicio_cargas) --}}
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
