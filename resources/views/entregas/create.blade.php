{{-- resources/views/entregas/create.blade.php --}}
<x-laravel-ui-adminlte::adminlte-layout>
    <head>
        <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" type="image/png">
        <meta name="viewport" content="width=device-width, initial-scale=1">

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

            .card-section{background:var(--bg-2);border-radius:14px;padding:20px;border:1px solid var(--line);}

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
            .form-control::placeholder{ color: rgba(167,173,183,.75); }

            .form-control[readonly],
            .form-control:disabled{
                background:#222834 !important;
                color:var(--ink) !important;
                opacity:1 !important;
                -webkit-text-fill-color: var(--ink) !important;
            }

            label{font-size:0.85rem;color:var(--muted);}

            .btn{border-radius:10px;font-weight:700;letter-spacing:.3px;}
            .btn-accent{background:var(--accent);border-color:var(--accent);color:var(--accent-ink);}
            .btn-accent:hover{background:var(--accent-hover);border-color:var(--accent-hover);box-shadow:0 10px 24px rgba(246,199,0,.28);transform:translateY(-1px);}

            .back-link{font-size:0.85rem;color:var(--muted);}
            .back-link a{color:var(--accent);}

            .radio-row{display:flex;gap:16px;margin-top:4px;}
            .radio-row label{color:var(--ink);font-size:0.85rem;margin-left:6px; margin-bottom:0;}

            .helper-text{font-size:0.75rem;color:var(--muted);margin-top:4px;}

            #cliente_ot { background: #1c1f24; color: var(--ink); }

            /* Fotos */
            .photo-grid{display:flex;flex-wrap:wrap;gap:16px;}
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
            .photo-card:hover{border-style:solid;border-color:var(--accent);box-shadow:0 10px 24px rgba(0,0,0,.4);transform:translateY(-1px);}
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
                margin:0;
            }
            .photo-upload-label i{font-size:1.8rem;color:var(--accent);}
            .photo-upload-label span{font-size:.8rem;}
            .photo-preview{margin-top:8px;display:none;}
            .photo-preview img{
                max-width:100%;
                max-height:140px;
                border-radius:10px;
                object-fit:cover;
                border:1px solid var(--line);
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

            /* Alert legible en dark */
            .alert-danger{
                background:#3a1f24;
                border-color:#7a2b36;
                color:#ffd6dc;
            }
            .alert-danger strong{ color:#fff; }
        </style>
    </head>

    <body>
    <div class="form-wrap">
        <div class="form-head">
            <img src="{{ url('/') }}/images/logo.png" alt="TJCA">
            <div>
                <div class="title">Entrega de servicio</div>
                <div class="subtitle">Registro público de entrega al cliente</div>
            </div>
        </div>

        <div class="card-section">
            @php
                // Por defecto, email vacío (se completa al elegir OT)
                $emailDefault = old('email_envio', '');
            @endphp

            <form method="POST" action="{{ route('entregas.store') }}" enctype="multipart/form-data" id="entrega-form" novalidate>
                @csrf

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Ocurrieron errores al registrar la entrega:</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row">
                    {{-- OT asociada (SELECT) --}}
                    <div class="col-md-6 mb-3">
                        <label>OT asociada</label>
                        <select name="ot_id" id="ot_id" class="form-control" required>
                            <option value="">Selecciona una OT...</option>

                            @foreach($ots as $otItem)
                                @php
                                    $vehiculosPayload = $otItem->vehiculos
                                        ->filter(fn($v) => $v->entregas->isEmpty())
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

                                    $clienteNombre = optional(optional(optional($otItem->cotizacion)->solicitud)->cliente)->razon_social ?? '';
                                    $correoCliente = optional(optional(optional($otItem->cotizacion)->solicitud)->cliente)->correo ?? '';
                                    $origen = optional($otItem->cotizacion)->origen ?? '';
                                    $destino = optional($otItem->cotizacion)->destino ?? '';
                                    $conductor = $otItem->conductor ?? (optional($otItem->cotizacion)->conductor ?? '');
                                @endphp

                                <option
                                    value="{{ $otItem->id }}"
                                    data-cliente="{{ $clienteNombre }}"
                                    data-origen="{{ $origen }}"
                                    data-destino="{{ $destino }}"
                                    data-conductor="{{ $conductor }}"
                                    data-correo="{{ $correoCliente }}"
                                    {{ old('ot_id') == $otItem->id ? 'selected' : '' }}
                                >
                                    OT #{{ $otItem->folio ?? $otItem->id }}
                                    @if($otItem->cotizacion)
                                        · {{ $otItem->cotizacion->cliente ?? '' }}
                                        @if($origen || $destino)
                                            · {{ $origen }} → {{ $destino }}
                                        @endif
                                    @endif
                                </option>

                                <script type="application/json" id="vehiculos_ot_{{ $otItem->id }}">
                                    {!! $vehiculosPayload->toJson() !!}
                                </script>
                            @endforeach
                        </select>
                        <div class="helper-text">
                            Selecciona la OT sobre la cual se está registrando esta entrega.
                        </div>
                    </div>

                    {{-- VEHÍCULO --}}
                    <div class="col-md-6 mb-3" id="vehiculo_block" style="display:none;">
                        <label>Vehículo</label>
                        <select name="ot_vehiculo_id" id="ot_vehiculo_id" class="form-control" required>
                            <option value="">Selecciona un vehículo...</option>
                        </select>
                        <div class="helper-text">
                            Solo se muestran vehículos que aún no registran entrega.
                        </div>
                        @error('ot_vehiculo_id')
                            <div style="color:#ff6b6b; margin-top:8px; font-size:.85rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Conductor --}}
                    <div class="col-md-6 mb-3">
                        <label>Conductor que entrega</label>
                        <select name="conductor_id" id="conductor_id" class="form-control" required>
                            <option value="">Selecciona un conductor...</option>
                            @foreach($conductores as $conductor)
                                <option value="{{ $conductor->id }}" {{ old('conductor_id') == $conductor->id ? 'selected' : '' }}>
                                    {{ $conductor->nombre }}
                                </option>
                            @endforeach
                        </select>
                        <div class="helper-text">Conductor responsable de la entrega al cliente.</div>
                        @error('conductor_id')
                            <div style="color:#ff6b6b; margin-top:8px; font-size:.85rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Cliente visual --}}
                    <div class="col-md-12 mb-3">
                        <label>Cliente</label>
                        <input type="text" id="cliente_ot" class="form-control" value="" readonly>
                        <div class="helper-text">Cliente asociado a la OT seleccionada.</div>
                    </div>

                    {{-- Nombre receptor --}}
                    <div class="col-md-8 mb-3">
                        <label>Nombre receptor</label>
                        <input type="text" name="nombre_receptor" class="form-control" value="{{ old('nombre_receptor') }}" required>
                        @error('nombre_receptor')
                            <div style="color:#ff6b6b; margin-top:8px; font-size:.85rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Lugar / Fecha / Hora --}}
                    <div class="col-md-6 mb-3">
                        <label>Lugar de entrega</label>
                        <input type="text" name="lugar_entrega" id="lugar_entrega" class="form-control"
                               value="{{ old('lugar_entrega') }}" placeholder="Dirección o referencia del lugar" required>
                        @error('lugar_entrega')
                            <div style="color:#ff6b6b; margin-top:8px; font-size:.85rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Fecha de entrega</label>
                        <input type="date" name="fecha_entrega" class="form-control" value="{{ old('fecha_entrega') }}" required>
                        @error('fecha_entrega')
                            <div style="color:#ff6b6b; margin-top:8px; font-size:.85rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Hora de entrega</label>
                        <input type="time" name="hora_entrega" class="form-control" value="{{ old('hora_entrega') }}">
                        @error('hora_entrega')
                            <div style="color:#ff6b6b; margin-top:8px; font-size:.85rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Guía / Interno --}}
                    <div class="col-md-3 mb-3">
                        <label>N° Guía</label>
                        <input type="text" name="numero_guia" class="form-control" value="{{ old('numero_guia') }}" placeholder="Ej: 123456">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>N° Interno</label>
                        <input type="text" name="numero_interno" class="form-control" value="{{ old('numero_interno') }}" placeholder="Ej: INT-00123">
                    </div>

                    {{-- Conforme --}}
                    <div class="col-md-12 mb-3">
                        <label>Conforme</label>
                        <div class="radio-row">
                            <div class="d-flex align-items-center">
                                <input type="radio" id="conforme_si" name="conforme" value="1" {{ old('conforme', '1') == '1' ? 'checked' : '' }}>
                                <label for="conforme_si">Sí, conforme</label>
                            </div>
                            <div class="d-flex align-items-center">
                                <input type="radio" id="conforme_no" name="conforme" value="0" {{ old('conforme') === '0' ? 'checked' : '' }}>
                                <label for="conforme_no">No conforme</label>
                            </div>
                        </div>
                    </div>

                    {{-- Observaciones --}}
                    <div class="col-md-12 mb-3">
                        <label>Observaciones</label>
                        <textarea name="observaciones" rows="3" class="form-control"
                                  placeholder="Comentarios adicionales de la entrega">{{ old('observaciones') }}</textarea>
                    </div>

                    {{-- ✅ Correo de envío (modal) --}}
                    <div class="col-md-12 mb-3">
                        <input type="hidden" name="email_envio" id="email_envio" value="{{ $emailDefault }}">

                        <label>Correo de envío</label>
                        <div style="display:flex; gap:8px; align-items:center;">
                            <input type="text" class="form-control" id="email_envio_preview" value="{{ $emailDefault }}" readonly>
                            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modalEmailEnvio">
                                Cambiar
                            </button>
                        </div>

                        @error('email_envio')
                            <div style="color:#ff6b6b; margin-top:8px; font-size:.85rem;">{{ $message }}</div>
                        @enderror

                        <div class="helper-text">
                            Por defecto se usa el correo del cliente (desde Cliente). Puedes cambiarlo solo para este envío.
                        </div>
                    </div>

                    {{-- Fotos opcionales --}}
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
                            Formatos permitidos: JPG, PNG. Máx 5 MB por archivo.
                        </small>
                    </div>

                    {{-- Foto guía (requerida por tu input actual) --}}
                    <div class="col-md-12 mb-3">
                        <label>Foto guía de despacho <span style="color:#ff6b6b">*</span></label>

                        <div class="photo-grid">
                            <div class="photo-card">
                                <label class="photo-upload-label" for="foto_guia_despacho">
                                    <i class="fas fa-camera"></i>
                                    <strong>Tomar / subir guía de despacho</strong>
                                    <span>Foto clara donde se lea el documento.</span>

                                    <input type="file" name="foto_guia_despacho" id="foto_guia_despacho"
                                           class="d-none" accept="image/*" required
                                           onchange="previewPhoto(this, 'preview_foto_guia_despacho')">
                                </label>

                                <div id="preview_foto_guia_despacho" class="photo-preview">
                                    <img src="#" alt="Vista previa guía despacho">
                                </div>
                            </div>
                        </div>

                        @error('foto_guia_despacho')
                            <div style="color:#ff6b6b; margin-top:8px; font-size:.85rem;">{{ $message }}</div>
                        @enderror

                        <small class="text-muted" style="color: var(--muted);">
                            Formatos permitidos: JPG, PNG. Máx 5 MB por archivo.
                        </small>
                    </div>
                </div>

                {{-- Modal correo --}}
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

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="back-link">
                        <a href="{{ route('login') }}">Volver al portal</a>
                    </div>
                    <button type="submit" class="btn btn-accent" id="btnSubmitEntrega">
                        Registrar entrega
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- JS base (para modal y compat) --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const form            = document.getElementById('entrega-form');

            const otSelect        = document.getElementById('ot_id');
            const clienteInput    = document.getElementById('cliente_ot');
            const lugarInput      = document.getElementById('lugar_entrega');

            const vehiculoBlock   = document.getElementById('vehiculo_block');
            const vehiculoSelect  = document.getElementById('ot_vehiculo_id');

            const conductorSelect = document.getElementById('conductor_id');

            // Email envío (hidden + preview + modal input)
            const emailHidden  = document.getElementById('email_envio');
            const emailPreview = document.getElementById('email_envio_preview');
            const emailInput   = document.getElementById('email_envio_input');

            function resetVehiculos() {
                vehiculoSelect.innerHTML = '<option value="">Selecciona un vehículo...</option>';
                vehiculoBlock.style.display = 'none';
            }

            function getVehiculosFromOt(otId) {
                const el = document.getElementById(`vehiculos_ot_${otId}`);
                if (!el) return [];
                try { return JSON.parse(el.textContent || '[]') || []; }
                catch (e) { return []; }
            }

            function syncEmailFromOt(opt){
                if (!emailHidden || !emailPreview || !emailInput) return;
                const correo = opt.getAttribute('data-correo') || '';
                emailHidden.value = correo;
                emailPreview.value = correo;
                emailInput.value = correo;
            }

            function syncFromOt() {
                const opt = otSelect.options[otSelect.selectedIndex];
                if (!opt) return;

                const otId      = otSelect.value;
                const cliente   = opt.getAttribute('data-cliente')   || '';
                const destino   = opt.getAttribute('data-destino')   || '';
                const conductor = opt.getAttribute('data-conductor') || '';

                // Cliente OT visual
                clienteInput.value = cliente;

                // Lugar entrega: si está vacío, se sugiere destino
                if (!lugarInput.value || lugarInput.value.length === 0) {
                    lugarInput.value = destino;
                }

                // Email envío: se sincroniza por defecto al correo del cliente
                syncEmailFromOt(opt);

                // Vehículos pendientes de entrega
                resetVehiculos();
                if (otId) {
                    const vehiculos = getVehiculosFromOt(otId);

                    if (vehiculos.length > 0) {
                        vehiculos.forEach(v => {
                            const parts = [];
                            parts.push(`Vehículo ${v.orden ?? ''}`.trim());
                            if (v.rol) parts.push(`(${v.rol})`);
                            if (v.patente_camion) parts.push(`· ${v.patente_camion}`);
                            if (v.patente_remolque) parts.push(`· Rem: ${v.patente_remolque}`);
                            if (v.conductor) parts.push(`· ${v.conductor}`);

                            const o = document.createElement('option');
                            o.value = v.id;
                            o.textContent = parts.join(' ');
                            o.dataset.conductor = v.conductor || '';
                            vehiculoSelect.appendChild(o);
                        });

                        vehiculoBlock.style.display = 'block';

                        if (vehiculos.length === 1) {
                            vehiculoSelect.value = String(vehiculos[0].id);
                            vehiculoSelect.dispatchEvent(new Event('change'));
                        }
                    }
                }

                // Seleccionar conductor automáticamente por nombre si coincide
                if (conductorSelect && conductor) {
                    [...conductorSelect.options].forEach(o => {
                        if ((o.text || '').trim() === conductor.trim()) o.selected = true;
                    });
                }
            }

            // Si cambian vehículo, setear conductor por nombre si coincide
            vehiculoSelect.addEventListener('change', function () {
                const optVeh = vehiculoSelect.options[vehiculoSelect.selectedIndex];
                const vConductor = optVeh?.dataset?.conductor || '';
                if (!vConductor || !conductorSelect) return;

                [...conductorSelect.options].forEach(o => {
                    if ((o.text || '').trim() === vConductor.trim()) o.selected = true;
                });
            });

            otSelect.addEventListener('change', syncFromOt);

            // Guardar email desde modal
            const btnGuardarEmail = document.getElementById('btnGuardarEmailEnvio');
            if (btnGuardarEmail) {
                function forceModalCleanup() {
                    // limpia backdrop y estado del body si quedó pegado
                    document.body.classList.remove('modal-open');
                    document.body.style.removeProperty('padding-right');
                    document.body.style.removeProperty('overflow');

                    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                }

                btnGuardarEmail.addEventListener('click', function () {
                    const email = (emailInput?.value || '').trim();
                    if (!email || !email.includes('@')) {
                        alert('Ingresa un correo válido.');
                        return;
                    }

                    emailHidden.value = email;
                    emailPreview.value = email;

                    const $modal = $('#modalEmailEnvio');
                    $modal.modal('hide');

                    // ✅ si por conflicto no se limpia bien, lo forzamos
                    setTimeout(forceModalCleanup, 150);
                });

                // ✅ cada vez que el modal se cierre, dejamos el DOM limpio
                $('#modalEmailEnvio').on('hidden.bs.modal', function () {
                    forceModalCleanup();
                });

            }

            // Evitar doble submit y forzar validación HTML5 visible
            if (form) {
                form.addEventListener('submit', function () {
                    const btn = document.getElementById('btnSubmitEntrega');
                    if (btn) {
                        btn.disabled = true;
                        btn.textContent = 'Enviando...';
                    }
                });
            }

            // Inicial
            resetVehiculos();
            syncFromOt();
        });
    </script>

    <script>
        // Comprime y escala una imagen a un máximo de ancho/alto
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

                const maxBytes = 5 * 1024 * 1024;
                if (compressedFile.size > maxBytes) {
                    alert('La imagen sigue pesando más de 5MB. Intenta con una foto más liviana.');
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

    </body>
</x-laravel-ui-adminlte::adminlte-layout>
