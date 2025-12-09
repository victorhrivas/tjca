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
            .form-control{background:#2a2f38;border:1px solid var(--line);color:var(--ink);border-radius:10px;}
            .form-control:focus{background:#2d333d;border-color:var(--accent);box-shadow:0 0 0 .15rem rgba(246,199,0,.2);color:#fff}
            label{font-size:0.85rem;color:var(--muted);}
            .btn{border-radius:10px;font-weight:700;letter-spacing:.3px;}
            .btn-accent{background:var(--accent);border-color:var(--accent);color:var(--accent-ink);}
            .btn-accent:hover{background:var(--accent-hover);border-color:var(--accent-hover);box-shadow:0 10px 24px rgba(246,199,0,.28);transform:translateY(-1px);}
            .back-link{font-size:0.85rem;color:var(--muted);}
            .back-link a{color:var(--accent);}
            .radio-row{display:flex;gap:16px;margin-top:4px;}
            .radio-row label{color:var(--ink);font-size:0.85rem;margin-left:4px;}

            .helper-text{
                font-size:0.75rem;
                color:var(--muted);
                margin-top:4px;
            }

            #cliente_ot {
                background: #1c1f24;
                color: var(--ink);
            }
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
                $otIdDefault = old('ot_id', isset($ot) ? $ot->id : '');
            @endphp

            <form method="POST" action="{{ route('entregas.store') }}" enctype="multipart/form-data">
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
                                <option
                                    value="{{ $otItem->id }}"
                                    data-cliente="{{ $otItem->cotizacion->solicitud->cliente->razon_social ?? '' }}"
                                    data-origen="{{ $otItem->cotizacion->origen ?? '' }}"
                                    data-destino="{{ $otItem->cotizacion->destino ?? '' }}"
                                    data-conductor="{{ $otItem->conductor ?? ($otItem->cotizacion->conductor ?? '') }}"
                                >
                                    OT #{{ $otItem->folio ?? $otItem->id }}
                                    @if($otItem->cotizacion)
                                        · {{ $otItem->cotizacion->cliente ?? '' }}
                                        @if($otItem->cotizacion->origen || $otItem->cotizacion->destino)
                                            · {{ $otItem->cotizacion->origen ?? '' }} → {{ $otItem->cotizacion->destino ?? '' }}
                                        @endif
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        <div class="helper-text">
                            Selecciona la OT sobre la cual se está registrando esta entrega.
                        </div>
                    </div>

                    {{-- Conductor que entrega (SELECT) --}}
                    <div class="col-md-6 mb-3">
                        <label>Conductor que entrega</label>
                        <select name="conductor_id" class="form-control" required>
                            <option value="">Selecciona un conductor...</option>
                            @foreach($conductores as $conductor)
                                <option value="{{ $conductor->id }}"
                                    {{ old('conductor_id') == $conductor->id ? 'selected' : '' }}>
                                    {{ $conductor->nombre }}
                                </option>
                            @endforeach
                        </select>
                        <div class="helper-text">
                            Conductor responsable de la entrega al cliente.
                        </div>
                    </div>

                    {{-- Cliente asociado a la OT (solo visual) --}}
                    <div class="col-md-12 mb-3">
                        <label>Cliente</label>
                        <input type="text"
                               id="cliente_ot"
                               class="form-control"
                               value=""
                               readonly>
                        <div class="helper-text">
                            Cliente asociado a la OT seleccionada.
                        </div>
                    </div>

                    {{-- Nombre receptor --}}
                    <div class="col-md-8 mb-3">
                        <label>Nombre receptor</label>
                        <input type="text"
                               name="nombre_receptor"
                               class="form-control"
                               value="{{ old('nombre_receptor') }}"
                               required>
                    </div>

                    {{-- RUT / Teléfono / Correo --}}
                    <div class="col-md-4 mb-3">
                        <label>RUT receptor</label>
                        <input type="text"
                               name="rut_receptor"
                               class="form-control"
                               value="{{ old('rut_receptor') }}"
                               placeholder="11.111.111-1">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Teléfono receptor</label>
                        <input type="text"
                               name="telefono_receptor"
                               class="form-control"
                               value="{{ old('telefono_receptor') }}"
                               placeholder="+56 9 xxxx xxxx">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Correo receptor</label>
                        <input type="email"
                               name="correo_receptor"
                               class="form-control"
                               value="{{ old('correo_receptor') }}"
                               placeholder="correo@ejemplo.cl">
                    </div>

                    {{-- Lugar / Fecha --}}
                    <div class="col-md-6 mb-3">
                        <label>Lugar de entrega</label>
                        <input type="text"
                               name="lugar_entrega"
                               id="lugar_entrega"
                               class="form-control"
                               value="{{ old('lugar_entrega') }}"
                               placeholder="Dirección o referencia del lugar"
                               required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Fecha de entrega</label>
                        <input type="date"
                               name="fecha_entrega"
                               class="form-control"
                               value="{{ old('fecha_entrega') }}"
                               required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>N° Guía</label>
                        <input type="text"
                            name="numero_guia"
                            class="form-control"
                            value="{{ old('numero_guia') }}"
                            placeholder="Ej: 123456">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>N° Interno</label>
                        <input type="text"
                            name="numero_interno"
                            class="form-control"
                            value="{{ old('numero_interno') }}"
                            placeholder="Ej: INT-00123">
                    </div>

                    {{-- Conforme --}}
                    <div class="col-md-12 mb-3">
                        <label>Conforme</label>
                        <div class="radio-row">
                            <div class="d-flex align-items-center">
                                <input type="radio"
                                       id="conforme_si"
                                       name="conforme"
                                       value="1"
                                       {{ old('conforme', '1') == '1' ? 'checked' : '' }}>
                                <label for="conforme_si">Sí, conforme</label>
                            </div>
                            <div class="d-flex align-items-center">
                                <input type="radio"
                                       id="conforme_no"
                                       name="conforme"
                                       value="0"
                                       {{ old('conforme') === '0' ? 'checked' : '' }}>
                                <label for="conforme_no">No conforme</label>
                            </div>
                        </div>
                    </div>

                    {{-- Observaciones --}}
                    <div class="col-md-12 mb-3">
                        <label>Observaciones</label>
                        <textarea name="observaciones"
                                  rows="3"
                                  class="form-control"
                                  placeholder="Comentarios adicionales de la entrega">{{ old('observaciones') }}</textarea>
                    </div>

                    {{-- Fotos (hasta 3 imágenes) --}}
                    <div class="col-md-12 mb-3">
                        <label>Fotos de la entrega (opcional)</label>
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <input type="file"
                                    name="foto_1"
                                    class="form-control"
                                    accept="image/*">
                                <small class="helper-text">Foto 1</small>
                            </div>
                            <div class="col-md-4 mb-2">
                                <input type="file"
                                    name="foto_2"
                                    class="form-control"
                                    accept="image/*">
                                <small class="helper-text">Foto 2</small>
                            </div>
                            <div class="col-md-4 mb-2">
                                <input type="file"
                                    name="foto_3"
                                    class="form-control"
                                    accept="image/*">
                                <small class="helper-text">Foto 3</small>
                            </div>
                        </div>
                        <div class="helper-text">
                            Las imágenes se almacenan como respaldo de la entrega (máx. ~3MB por foto).
                        </div>
                    </div>  
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="back-link">
                        <a href="{{ route('login') }}">Volver al portal</a>
                    </div>
                    <button type="submit" class="btn btn-accent">
                        Registrar entrega
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

        const otSelect       = document.getElementById('ot_id');
        const clienteInput   = document.getElementById('cliente_ot');
        const lugarInput     = document.getElementById('lugar_entrega');

        function syncFromOt() {
            const opt = otSelect.options[otSelect.selectedIndex];
            if (!opt) return;

            const cliente   = opt.getAttribute('data-cliente')   || '';
            const destino   = opt.getAttribute('data-destino')   || '';
            const origen    = opt.getAttribute('data-origen')    || '';
            const conductor = opt.getAttribute('data-conductor') || '';

            // Cliente OT visual
            clienteInput.value = cliente;

            // Cargar destino como lugar de entrega (se puede editar)
            if (!lugarInput.value || lugarInput.value.length === 0) {
                lugarInput.value = destino;
            }

            // Seleccionar conductor automáticamente si coincide
            const conductorSelect = document.querySelector('select[name="conductor_id"]');
            if (conductorSelect && conductor) {
                [...conductorSelect.options].forEach(opt => {
                    if (opt.text.trim() === conductor.trim()) {
                        opt.selected = true;
                    }
                });
            }
        }

        otSelect.addEventListener('change', syncFromOt);
        syncFromOt(); // inicial
    });
    </script>
    </body>
</x-laravel-ui-adminlte::adminlte-layout>
