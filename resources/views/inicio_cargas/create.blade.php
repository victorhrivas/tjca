{{-- resources/views/inicio_cargas/create.blade.php --}}
<x-laravel-ui-adminlte::adminlte-layout>

    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Select2 para búsqueda de OT --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css" rel="stylesheet" />

    <style>
        :root{
            --bg-0:#101114;--bg-1:#15171b;--bg-2:#1c1f24;--bg-3:#23272e;
            --line:#2c3139;--ink:#e6e7ea;--muted:#a7adb7;
            --accent:#d4ad18;--accent-hover:#e1ba1f;--accent-ink:#0b0c0e;
            --shadow:0 14px 40px rgba(0,0,0,.45);
        }
        body{
            background: var(--bg-0);
            color: var(--ink);
            font-family: "Inter", system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial, sans-serif;
        }
        .form-wrap{
            max-width: 900px;
            margin: 40px auto;
            padding: 24px;
            background: linear-gradient(180deg, var(--bg-2), var(--bg-1));
            border: 1px solid var(--line);
            border-radius: 18px;
            box-shadow: var(--shadow);
        }
        .form-head{
            display:flex;
            align-items:center;
            gap:16px;
            background:linear-gradient(90deg,var(--accent),#f8dc3b);
            color:var(--accent-ink);
            border-radius:12px;
            padding:10px 14px;
            margin-bottom:18px;
        }
        .form-head img{height:70px;}
        .form-head .title{font-weight:800;letter-spacing:.4px;text-transform:uppercase;font-size:0.95rem;}
        .form-head .subtitle{font-size:0.85rem;}

        /* Campos que vienen desde la OT */
        .auto-from-ot { display: none; }

        .card-section{background:var(--bg-2);border-radius:14px;padding:20px;border:1px solid var(--line);}

        /* Base inputs dark */
        .form-control{
            background:#2a2f38;
            border:1px solid var(--line);
            color:var(--ink);
            border-radius:10px;
        }
        .form-control:focus{
            background:#2d333d;
            border-color:var(--accent);
            box-shadow:0 0 0 .15rem rgba(246,199,0,.2);
            color:#fff
        }

        /* OVERRIDE Bootstrap: readonly/disabled */
        .form-control[readonly],
        .form-control:disabled{
            background:#222834 !important;
            color:var(--ink) !important;
            opacity:1 !important;
            -webkit-text-fill-color: var(--ink) !important;
        }
        .form-control::placeholder{ color: rgba(167,173,183,.75); }

        label{font-size:0.85rem;color:var(--muted);}
        .btn{border-radius:10px;font-weight:700;letter-spacing:.3px;}
        .btn-accent{background:var(--accent);border-color:var(--accent);color:var(--accent-ink);}
        .btn-accent:hover{background:var(--accent-hover);border-color:var(--accent-hover);box-shadow:0 10px 24px rgba(246,199,0,.28);transform:translateY(-1px);}

        .back-link{font-size:0.85rem;color:var(--muted);}
        .back-link a{color:var(--accent);}

        /* Select2 */
        .select2-container--bootstrap4 .select2-selection--single {
            background: #2a2f38 !important;
            border-color: var(--line) !important;
            color: var(--ink) !important;
            border-radius: 10px !important;
            min-height: 42px;
            display:flex;
            align-items:center;
        }
        .select2-container--bootstrap4 .select2-selection__rendered { color: var(--ink) !important; }
        .select2-container--bootstrap4 .select2-selection__placeholder { color: var(--muted) !important; }
        .select2-container--bootstrap4 .select2-dropdown { background: #1c1f24 !important; border-color: var(--line) !important; }
        .select2-container--bootstrap4 .select2-results > .select2-results__options { background: #1c1f24 !important; }
        .select2-container--bootstrap4 .select2-results__option { color: var(--ink) !important; }
        .select2-container--bootstrap4 .select2-results__option--highlighted[aria-selected] {
            background: var(--accent) !important;
            color: var(--accent-ink) !important;
        }
        .select2-container--bootstrap4 .select2-search__field {
            background: #101114 !important;
            color: var(--ink) !important;
            border-color: var(--line) !important;
        }

        /* Modal oscuro */
        .modal-content{
            background: var(--bg-2);
            border: 1px solid var(--line);
            border-radius: 14px;
            color: var(--ink);
        }
        .modal-header, .modal-footer{ border-color: var(--line); }
        .modal-title{ color: var(--ink); }
        .modal .close{ color: var(--ink); text-shadow:none; opacity:.9; }
        .modal .text-muted{ color: var(--muted) !important; }

        /* Errores visibles */
        .text-danger{ color:#ff6b6b !important; }

        /* Alerta de errores */
        .alert-danger{
            background: rgba(255, 107, 107, .12);
            border: 1px solid rgba(255, 107, 107, .35);
            color: var(--ink);
            border-radius: 12px;
        }

        /* Fotos */
        .photo-grid{ display:flex; flex-wrap:wrap; gap:16px; }
        .photo-card{
            flex:1 1 0;
            min-width:180px;
            max-width:260px;
            background:rgba(16,17,20,.7);
            border-radius:12px;
            border:1px dashed var(--line);
            padding:12px;
            display:flex;
            flex-direction:column;
            justify-content:space-between;
            transition:.15s all ease-out;
        }
        .photo-card:hover{
            border-style:solid;
            border-color:var(--accent);
            box-shadow:0 10px 24px rgba(0,0,0,.4);
            transform:translateY(-1px);
        }
        .photo-upload-label{
            cursor:pointer;
            display:flex;
            flex-direction:column;
            align-items:center;
            justify-content:center;
            gap:8px;
            text-align:center;
            color:var(--muted);
            min-height:130px;
        }
        .photo-upload-label i{ font-size:1.8rem; color:var(--accent); }
        .photo-upload-label span{ font-size:.8rem; }
        .photo-preview{ margin-top:8px; display:none; }
        .photo-preview img{
            max-width:100%;
            max-height:140px;
            border-radius:10px;
            object-fit:cover;
            border:1px solid var(--line);
        }
    </style>

    <div class="form-wrap">
        <div class="form-head">
            <img src="{{ url('/') }}/images/logo.png" alt="TJCA">
            <div>
                <div class="title">Inicio de carga</div>
                <div class="subtitle">Formulario público de registro de servicio</div>
            </div>
        </div>

        <div class="card-section">
            {{-- ✅ SIEMPRE mostrar errores del backend --}}
            @if ($errors->any())
                <div class="alert alert-danger mb-3">
                    <strong>No se pudo enviar.</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="inicio-carga-form" method="POST" action="{{ route('inicio-cargas.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    {{-- OT --}}
                    <div class="col-md-12 mb-3">
                        <label>OT</label>
                        <select name="ot_id" id="ot_id" class="form-control" required>
                            <option value="">Selecciona una OT...</option>

                            @foreach($ots as $otItem)
                                @php
                                    $vehiculosPayload = $otItem->vehiculos
                                        ->filter(fn($v) => $v->inicioCargas->isEmpty())
                                        ->map(function($v){
                                            return [
                                                'id' => $v->id,
                                                'orden' => $v->orden,
                                                'rol' => $v->rol,
                                                'conductor' => $v->conductor,
                                                'patente_camion' => $v->patente_camion,
                                                'patente_remolque' => $v->patente_remolque,
                                            ];
                                        })->values();

                                    // correo real del cliente
                                    $correoCliente = optional(optional(optional($otItem->cotizacion)->solicitud)->cliente)->correo;
                                    $correoFinal = $correoCliente ?: ($otItem->correo_contacto ?? '');
                                @endphp

                                <option
                                    value="{{ $otItem->id }}"
                                    data-folio="{{ $otItem->folio }}"
                                    data-equipo="{{ $otItem->equipo }}"
                                    data-cliente="{{ $otItem->cliente }}"
                                    data-contacto="{{ $otItem->solicitante }}"
                                    data-telefono="{{ $otItem->telefono_contacto }}"
                                    data-correo="{{ $correoFinal }}"
                                    data-origen="{{ $otItem->origen }}"
                                    data-destino="{{ $otItem->destino }}"
                                    data-conductor="{{ $otItem->conductor }}"
                                    @isset($ot)
                                        {{ $ot->id === $otItem->id ? 'selected' : '' }}
                                    @endisset
                                >
                                    OT #{{ $otItem->folio }}
                                    @if($otItem->cliente) · {{ $otItem->cliente }} @endif
                                    @if($otItem->origen || $otItem->destino) · {{ $otItem->origen }} → {{ $otItem->destino }} @endif
                                </option>

                                <script type="application/json" id="vehiculos_ot_{{ $otItem->id }}">
                                    {!! $vehiculosPayload->toJson() !!}
                                </script>
                            @endforeach
                        </select>
                    </div>

                    {{-- VEHÍCULO --}}
                    <div class="col-md-12 mb-3" id="vehiculo_block" style="display:none;">
                        <label>Vehículo</label>
                        <select name="ot_vehiculo_id" id="ot_vehiculo_id" class="form-control">
                            <option value="">Selecciona un vehículo...</option>
                        </select>
                        <small class="text-muted" style="color: var(--muted);">
                            Si la OT tiene varios vehículos, selecciona cuál realizará este inicio de carga.
                        </small>
                    </div>

                    {{-- Campo oculto requerido por BD --}}
                    <input type="hidden" name="tipo_carga" id="tipo_carga">

                    {{-- Detalle OT (auto) --}}
                    <div class="col-md-6 mb-3 auto-from-ot">
                        <label>N° OT</label>
                        <input type="text" id="ot_folio" class="form-control" readonly>
                    </div>

                    <div class="col-md-6 mb-3 auto-from-ot">
                        <label>Equipo</label>
                        <input type="text" id="equipo_ot" class="form-control" readonly>
                    </div>

                    <div class="col-md-6 mb-3 auto-from-ot">
                        <label>Cliente</label>
                        <input type="text" name="cliente" id="cliente" class="form-control" readonly>
                    </div>

                    <div class="col-md-6 mb-3 auto-from-ot">
                        <label>Contacto / Solicitante</label>
                        <input type="text" name="contacto" id="contacto" class="form-control" readonly>
                    </div>

                    <div class="col-md-6 mb-3 auto-from-ot">
                        <label>Teléfono de contacto</label>
                        <input type="text" name="telefono_contacto" id="telefono_contacto" class="form-control" readonly>
                    </div>

                    <div class="col-md-6 mb-3 auto-from-ot">
                        <label>Correo de contacto</label>
                        <input type="email" name="correo_contacto" id="correo_contacto" class="form-control" readonly>
                    </div>

                    <div class="col-md-6 mb-3 auto-from-ot">
                        <label>Origen</label>
                        <input type="text" name="origen" id="origen" class="form-control" value="{{ old('origen') }}" required>
                    </div>

                    <div class="col-md-6 mb-3 auto-from-ot">
                        <label>Destino</label>
                        <input type="text" name="destino" id="destino" class="form-control" value="{{ old('destino') }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Fecha de carga</label>
                        <input type="date" name="fecha_carga" class="form-control" value="{{ old('fecha_carga') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Conductor</label>
                        <input type="text" name="conductor" id="conductor" class="form-control" value="{{ old('conductor') }}" placeholder="Nombre del conductor">
                    </div>

                    {{-- Fotos --}}
                    <div class="col-md-12 mb-3">
                        <label>Fotos de la carga (opcional)</label>

                        <div class="photo-grid">
                            <div class="photo-card">
                                <label class="photo-upload-label" for="foto_1">
                                    <i class="fas fa-camera"></i>
                                    <strong>Tomar / subir foto 1</strong>
                                    <span>Toca aquí para abrir la cámara o la galería.</span>
                                    <input type="file" name="foto_1" id="foto_1" class="d-none" accept="image/*"
                                           onchange="previewPhoto(this, 'preview_foto_1')">
                                </label>
                                <div id="preview_foto_1" class="photo-preview">
                                    <img src="#" alt="Vista previa foto 1">
                                </div>
                            </div>

                            <div class="photo-card">
                                <label class="photo-upload-label" for="foto_2">
                                    <i class="fas fa-camera"></i>
                                    <strong>Tomar / subir foto 2</strong>
                                    <span>Opcional, para más ángulos.</span>
                                    <input type="file" name="foto_2" id="foto_2" class="d-none" accept="image/*"
                                           onchange="previewPhoto(this, 'preview_foto_2')">
                                </label>
                                <div id="preview_foto_2" class="photo-preview">
                                    <img src="#" alt="Vista previa foto 2">
                                </div>
                            </div>

                            <div class="photo-card">
                                <label class="photo-upload-label" for="foto_3">
                                    <i class="fas fa-camera"></i>
                                    <strong>Tomar / subir foto 3</strong>
                                    <span>Opcional.</span>
                                    <input type="file" name="foto_3" id="foto_3" class="d-none" accept="image/*"
                                           onchange="previewPhoto(this, 'preview_foto_3')">
                                </label>
                                <div id="preview_foto_3" class="photo-preview">
                                    <img src="#" alt="Vista previa foto 3">
                                </div>
                            </div>
                        </div>

                        <small class="text-muted" style="color: var(--muted);">
                            Formatos permitidos: JPG, PNG. Máx 4 MB por archivo.
                        </small>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Observaciones</label>
                        <textarea name="observaciones" rows="3" class="form-control">{{ old('observaciones') }}</textarea>
                    </div>

                    {{-- Correo de envío (editable) --}}
                    @php
                        $correoClienteSelected = optional(optional(optional(optional($ot)->cotizacion)->solicitud)->cliente)->correo;
                        $emailDefault = old('email_envio', $correoClienteSelected ?? '');
                    @endphp

                    <div class="col-md-12 mb-3">
                        <input type="hidden" name="email_envio" id="email_envio" value="{{ $emailDefault }}">

                        <label>Correo de envío</label>
                        <div style="display:flex; gap:8px; align-items:center;">
                            <input type="text" class="form-control" id="email_envio_preview" value="{{ $emailDefault }}" readonly>
                            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modalEmailEnvio">
                                Cambiar
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Botonera --}}
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="back-link">
                        <a href="{{ route('login') }}">Volver al portal</a>
                    </div>
                    <button id="btn-submit" type="submit" class="btn btn-accent">
                        Enviar solicitud
                    </button>
                </div>

                {{-- Modal correo (DENTRO del form, OK) --}}
                <div class="modal fade" id="modalEmailEnvio" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title">Cambiar correo de envío</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="email_envio_input">Correo</label>
                                    <input type="email" class="form-control" id="email_envio_input" value="{{ $emailDefault }}" required>
                                    <small class="text-muted">Este correo se usará solo para este envío.</small>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary" id="btnGuardarEmailEnvio">Guardar</button>
                            </div>

                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>

    {{-- jQuery + Bootstrap (modal) + Select2 --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(function () {
            const $form      = $('#inicio-carga-form');
            const $btnSubmit = $('#btn-submit');

            const $otSelect   = $('#ot_id');
            const $autoBlock  = $('.auto-from-ot');

            const $folioOt    = $('#ot_folio');
            const $equipoOt   = $('#equipo_ot');
            const $tipoCarga  = $('#tipo_carga');

            const $cliente    = $('#cliente');
            const $contacto   = $('#contacto');
            const $tel        = $('#telefono_contacto');
            const $correo     = $('#correo_contacto');

            const $origen     = $('#origen');
            const $destino    = $('#destino');

            const $conductor  = $('#conductor');

            const $vehiculoBlock  = $('#vehiculo_block');
            const $vehiculoSelect = $('#ot_vehiculo_id');

            // Email envío
            const $emailHidden  = $('#email_envio');
            const $emailPreview = $('#email_envio_preview');
            const $emailInput   = $('#email_envio_input');

            const resetVehiculos = () => {
                $vehiculoSelect.empty().append('<option value="">Selecciona un vehículo...</option>');
                $vehiculoBlock.hide();
            };

            const resetForm = () => {
                $autoBlock.hide();

                $folioOt.val('');
                $equipoOt.val('');
                $tipoCarga.val('');

                $cliente.val('');
                $contacto.val('');
                $tel.val('');
                $correo.val('');

                $origen.val('').prop('readonly', false);
                $destino.val('').prop('readonly', false);

                $conductor.val('');

                $emailHidden.val('');
                $emailPreview.val('');
                $emailInput.val('');

                resetVehiculos();
            };

            const getVehiculosFromOt = (otId) => {
                const el = document.getElementById(`vehiculos_ot_${otId}`);
                if (!el) return [];
                try { return JSON.parse(el.textContent || '[]') || []; }
                catch (e) { return []; }
            };

            $otSelect.select2({
                theme: 'bootstrap4',
                placeholder: 'Buscar OT por número o cliente',
                width: '100%',
                allowClear: true
            });

            $vehiculoSelect.on('change', function () {
                const vehId = $(this).val();
                const $vopt = $(this).find('option:selected');

                if (!vehId) {
                    const $otOpt = $otSelect.find('option:selected');
                    $conductor.val($otOpt.data('conductor') || '');
                    return;
                }

                const vConductor = $vopt.data('conductor') || '';
                if (vConductor) $conductor.val(vConductor);
            });

            $otSelect.on('change', function () {
                const otId = $(this).val();
                const $opt = $(this).find('option:selected');

                if (!otId) { resetForm(); return; }

                const folio     = $opt.data('folio')     || '';
                const equipo    = $opt.data('equipo')    || '';
                const cliente   = $opt.data('cliente')   || '';
                const contacto  = $opt.data('contacto')  || '';
                const telefono  = $opt.data('telefono')  || '';
                const correo    = $opt.data('correo')    || '';
                const origen    = $opt.data('origen')    || '';
                const destino   = $opt.data('destino')   || '';
                const conductor = $opt.data('conductor') || '';

                $autoBlock.show();

                $folioOt.val(folio);
                $equipoOt.val(equipo);
                $tipoCarga.val(equipo);

                $cliente.val(cliente);
                $contacto.val(contacto);
                $tel.val(telefono);
                $correo.val(correo);

                // Email por defecto
                $emailHidden.val(correo);
                $emailPreview.val(correo);
                $emailInput.val(correo);

                if (origen) $origen.val(origen).prop('readonly', true);
                else $origen.val('').prop('readonly', false);

                if (destino) $destino.val(destino).prop('readonly', true);
                else $destino.val('').prop('readonly', false);

                resetVehiculos();
                const vehiculos = getVehiculosFromOt(otId);

                if (vehiculos.length > 0) {
                    vehiculos.forEach(v => {
                        const parts = [];
                        parts.push(`Vehículo ${v.orden ?? ''}`.trim());
                        if (v.rol) parts.push(`(${v.rol})`);
                        if (v.patente_camion) parts.push(`· ${v.patente_camion}`);
                        if (v.patente_remolque) parts.push(`· Rem: ${v.patente_remolque}`);
                        if (v.conductor) parts.push(`· ${v.conductor}`);

                        const $o = $('<option/>', { value: v.id, text: parts.join(' ') });
                        $o.data('conductor', v.conductor || '');
                        $vehiculoSelect.append($o);
                    });

                    $vehiculoBlock.show();

                    if (vehiculos.length === 1) {
                        $vehiculoSelect.val(String(vehiculos[0].id)).trigger('change');
                    } else {
                        $conductor.val(conductor);
                    }
                } else {
                    $conductor.val(conductor);
                }
            });

            // Inicial
            resetForm();
            if ($otSelect.val()) $otSelect.trigger('change');

            $('#modalEmailEnvio').on('hidden.bs.modal', function () {
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
                $('body').css('padding-right', '');
            });


            // Modal guardar correo
            $('#btnGuardarEmailEnvio').on('click', function () {
                const email = ($emailInput.val() || '').trim();
                if (!email || !email.includes('@')) {
                    alert('Ingresa un correo válido.');
                    return;
                }

                $emailHidden.val(email);
                $emailPreview.val(email);

                // Cerrar modal
                const $modal = $('#modalEmailEnvio');
                $modal.modal('hide');

                // ✅ Fix: si queda el backdrop pegado, lo limpiamos
                setTimeout(function () {
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                    // Por si Bootstrap dejó estilos inline
                    $('body').css('padding-right', '');
                }, 150);
            });


            // ✅ Antes de enviar, asegurar email_envio, y evitar doble submit
            $form.on('submit', function () {
                // si por alguna razón quedó vacío, usa correo_contacto
                if (!$emailHidden.val()) {
                    const fallback = ($correo.val() || '').trim();
                    if (fallback) {
                        $emailHidden.val(fallback);
                        $emailPreview.val(fallback);
                    }
                }

                $btnSubmit.prop('disabled', true).text('Enviando...');
            });
        });
    </script>

    <script>
        function compressImage(file, maxWidth = 1280, maxHeight = 1280, quality = 0.8) {
            return new Promise((resolve, reject) => {
                const img = new Image();
                const url = URL.createObjectURL(file);

                img.onload = () => {
                    let width = img.width;
                    let height = img.height;
                    const aspectRatio = width / height;

                    if (width > maxWidth) { width = maxWidth; height = Math.round(width / aspectRatio); }
                    if (height > maxHeight) { height = maxHeight; width = Math.round(height * aspectRatio); }

                    const canvas = document.createElement('canvas');
                    canvas.width = width;
                    canvas.height = height;

                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0, width, height);

                    canvas.toBlob(
                        (blob) => {
                            URL.revokeObjectURL(url);
                            if (!blob) return reject(new Error('No se pudo generar el blob'));

                            const compressedFile = new File([blob], file.name, {
                                type: 'image/jpeg',
                                lastModified: Date.now(),
                            });

                            const reader = new FileReader();
                            reader.onload = () => resolve({ file: compressedFile, dataUrl: reader.result });
                            reader.readAsDataURL(blob);
                        },
                        'image/jpeg',
                        quality
                    );
                };

                img.onerror = (err) => {
                    URL.revokeObjectURL(url);
                    reject(err);
                };

                img.src = url;
            });
        }

        async function previewPhoto(input, previewId) {
            const file = input.files && input.files[0];
            const previewWrap = document.getElementById(previewId);
            if (!file || !previewWrap) return;

            try {
                const { file: compressedFile, dataUrl } = await compressImage(file);

                const dt = new DataTransfer();
                dt.items.add(compressedFile);
                input.files = dt.files;

                const maxBytes = 4 * 1024 * 1024;
                if (compressedFile.size > maxBytes) {
                    alert('La imagen sigue pesando más de 4 MB. Intenta con una foto más liviana.');
                }

                const img = previewWrap.querySelector('img');
                img.src = dataUrl;
                previewWrap.style.display = 'block';
            } catch (e) {
                console.error(e);
                alert('No se pudo procesar la imagen seleccionada.');
            }
        }
    </script>

</x-laravel-ui-adminlte::adminlte-layout>
