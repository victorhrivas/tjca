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

                    <button type="button" class="btn btn-danger btn-sm ml-1" data-toggle="modal" data-target="#modalEnviarPdf">
                        <i class="fas fa-file-pdf mr-1"></i> PDF
                    </button>

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

    @php
        $correoCliente = optional($cotizacion->cliente_obj)->correo;
    @endphp

    <div class="modal fade" id="modalEnviarPdf" tabindex="-1" role="dialog" aria-labelledby="modalEnviarPdfLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="formEnviarPdf" class="modal-content">
        @csrf

        <div class="modal-header">
            <h5 class="modal-title" id="modalEnviarPdfLabel">Enviar cotización PDF</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">
            <div class="form-group">
            <label for="emailPdf">Correo destino</label>
            <input
                type="email"
                class="form-control"
                id="emailPdf"
                name="email"
                value="{{ $correoCliente }}"
                placeholder="correo@cliente.com"
                required
            >
            @if(!$correoCliente)
                <small class="text-warning d-block mt-2">
                No se encontró correo del cliente. Ingresa uno manualmente.
                </small>
            @endif
            </div>

            <div id="pdfSendError" class="alert alert-danger d-none mb-0"></div>
            <div id="pdfSendOk" class="alert alert-success d-none mb-0"></div>
        </div>

        <div class="modal-footer">
            <a href="{{ route('cotizacions.pdf', $cotizacion->id) }}" target="_blank" class="btn btn-outline-secondary">
            Solo descargar
            </a>

            <button type="submit" class="btn btn-danger" id="btnEnviarPdf">
            Enviar y descargar
            </button>
        </div>
        </form>
    </div>
    </div>

    @push('scripts')
    <script>
    $(function () {
    $('#formEnviarPdf').on('submit', function (e) {
        e.preventDefault();

        const $btn = $('#btnEnviarPdf');
        const $err = $('#pdfSendError');
        const $ok  = $('#pdfSendOk');

        $err.addClass('d-none').text('');
        $ok.addClass('d-none').text('');

        $btn.prop('disabled', true).text('Enviando...');

        $.ajax({
        url: @json(route('cotizacions.pdf.send', $cotizacion->id)),
        method: 'POST',
        data: {
            _token: @json(csrf_token()),
            email: $('#emailPdf').val()
        },
        success: function (res) {
            $ok.removeClass('d-none').text('Correo enviado. Se abrirá el PDF para descargar.');

            if (res && res.download_url) {
            window.open(res.download_url, '_blank');
            }

            setTimeout(() => {
            $('#modalEnviarPdf').modal('hide');
            }, 700);
        },
        error: function (xhr) {
            let msg = 'Error enviando el correo.';
            if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;

            // errores de validación
            if (xhr.responseJSON && xhr.responseJSON.errors) {
            const errors = xhr.responseJSON.errors;
            if (errors.email && errors.email.length) msg = errors.email[0];
            }

            $err.removeClass('d-none').text(msg);
        },
        complete: function () {
            $btn.prop('disabled', false).text('Enviar y descargar');
        }
        });
    });
    });
    </script>
    @endpush

@endsection
