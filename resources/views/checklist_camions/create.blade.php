{{-- resources/views/checklist_camions/create.blade.php --}}
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
                max-width: 1000px;
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
            .form-control,
            select{background:#2a2f38;border:1px solid var(--line);color:var(--ink);border-radius:10px;}
            .form-control:focus,
            select:focus{background:#2d333d;border-color:var(--accent);box-shadow:0 0 0 .15rem rgba(246,199,0,.2);color:#fff}
            label{font-size:0.85rem;color:var(--muted);}
            .btn{border-radius:10px;font-weight:700;letter-spacing:.3px;}
            .btn-accent{background:var(--accent);border-color:var(--accent);color:var(--accent-ink);}
            .btn-accent:hover{background:var(--accent-hover);border-color:var(--accent-hover);box-shadow:0 10px 24px rgba(246,199,0,.28);transform:translateY(-1px);}
            .back-link{font-size:0.85rem;color:var(--muted);}
            .back-link a{color:var(--accent);}
            .section-title{font-size:0.8rem;text-transform:uppercase;color:var(--muted);letter-spacing:.6px;margin:12px 0 4px;}
            .divider-line{border-top:1px solid var(--line);margin:8px 0 12px;}
            .helper-text{font-size:0.75rem;color:var(--muted);margin-top:4px;}
            .radio-inline label{margin-right:12px;}
            .req{color:#f66;margin-left:3px;}
        </style>
    </head>

    <body>
    <div class="form-wrap">
        <div class="form-head">
            <img src="{{ url('/') }}/images/logo.png" alt="TJCA">
            <div>
                <div class="title">Checklist de camión</div>
                <div class="subtitle">Control preventivo antes de la salida</div>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Ocurrieron errores al enviar el formulario:</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card-section">
            @php
                $estadoSimple = [
                    'buen_estado' => 'Buen estado',
                    'mal_estado'  => 'Mal estado',
                ];

                $conductoresFijos = [
                    'Elvis Corona',
                    'Bernardo Melendez',
                    'Luis Guerrero',
                    'Rodrigo Valenzuela',
                    'Juan Carlos Cuello',
                    'Juan Carlos Gonzalez',
                    'Francisco León',
                ];
            @endphp

            <form method="POST" action="{{ route('checklist-camions.store') }}">
                @csrf

                <div class="row">
                    {{-- DATOS GENERALES --}}
                    <div class="col-12">
                        <div class="section-title">Datos generales</div>
                        <div class="divider-line"></div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Fecha y hora checklist</label>
                        <input type="text"
                            class="form-control"
                            style="background:#2a2f38;border:1px solid var(--line);color:var(--ink);border-radius:10px;"
                            value="{{ now()->format('d/m/Y H:i') }}"
                            readonly>

                        <small class="helper-text">
                            Se registra automáticamente al guardar el checklist.
                        </small>

                        {{-- Hidden igual estilizado (aunque no se ve, por consistencia) --}}
                        <input type="hidden"
                            name="fecha_checklist"
                            value="{{ now()->format('Y-m-d H:i:s') }}">
                    </div>


                    {{-- Nombre conductor (select + otro) --}}
                    <div class="col-md-6 mb-3">
                        <label>Nombre del conductor <span class="req">*</span></label>
                        <select id="nombre_conductor_select" class="form-control">
                            <option value="">Selecciona conductor...</option>
                            @foreach($conductoresFijos as $nombre)
                                <option value="{{ $nombre }}"
                                    {{ old('nombre_conductor') === $nombre ? 'selected' : '' }}>
                                    {{ $nombre }}
                                </option>
                            @endforeach
                            <option value="__otro__"
                                {{ old('nombre_conductor') && !in_array(old('nombre_conductor'), $conductoresFijos) ? 'selected' : '' }}>
                                Otro
                            </option>
                        </select>
                        <input type="text"
                               id="nombre_conductor_otro"
                               class="form-control mt-2"
                               placeholder="Especificar otro conductor"
                               value="{{ (!in_array(old('nombre_conductor'), $conductoresFijos) ? old('nombre_conductor') : '') }}"
                               style="{{ (!in_array(old('nombre_conductor'), $conductoresFijos) && old('nombre_conductor')) ? '' : 'display:none;' }}">
                        {{-- campo real que se envía --}}
                        <input type="hidden" name="nombre_conductor" id="nombre_conductor_hidden"
                               value="{{ old('nombre_conductor') }}">
                        <div class="helper-text">Selecciona un conductor o escribe otro nombre.</div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Patente <span class="req">*</span></label>
                        <input type="text"
                               name="patente"
                               class="form-control"
                               value="{{ old('patente') }}"
                               required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Kilometraje</label>
                        <input type="text"
                               name="kilometraje"
                               class="form-control"
                               value="{{ old('kilometraje') }}"
                               placeholder="Ej: 120.500 km">
                    </div>

                    {{-- NIVEL DE ACEITE --}}
                    <div class="col-12 mt-2">
                        <div class="section-title">Nivel de aceite <span class="req">*</span></div>
                        <div class="divider-line"></div>
                    </div>

                    <div class="col-12 mb-3">
                        <div class="radio-inline">
                            @php
                                $nivelesAceite = ['bajo' => 'Bajo', '1' => '1', '2'=>'2', '3'=>'3', '4'=>'4', '5'=>'5', 'normal'=>'Normal'];
                                $oldNivel = old('nivel_aceite');
                            @endphp
                            @foreach($nivelesAceite as $value => $labelText)
                                <label class="mr-3">
                                    <input type="radio"
                                           name="nivel_aceite"
                                           value="{{ $value }}"
                                           {{ $oldNivel === $value ? 'checked' : '' }}
                                           required>
                                    {{ $labelText }}
                                </label>
                            @endforeach
                        </div>
                        <div class="helper-text">Escala desde “Bajo” hasta “Normal”.</div>
                    </div>

                    {{-- ILUMINACIÓN Y FRENOS --}}
                    <div class="col-12 mt-2">
                        <div class="section-title">Iluminación y frenos</div>
                        <div class="divider-line"></div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Luces altas y bajas <span class="req">*</span></label>
                        <select name="luces_altas_bajas" class="form-control" required>
                            <option value="">Seleccionar...</option>
                            @foreach($estadoSimple as $val => $label)
                                <option value="{{ $val }}" {{ old('luces_altas_bajas') === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Intermitentes <span class="req">*</span></label>
                        <select name="intermitentes" class="form-control" required>
                            <option value="">Seleccionar...</option>
                            @foreach($estadoSimple as $val => $label)
                                <option value="{{ $val }}" {{ old('intermitentes') === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Luces de posición <span class="req">*</span></label>
                        <select name="luces_posicion" class="form-control" required>
                            <option value="">Seleccionar...</option>
                            @foreach($estadoSimple as $val => $label)
                                <option value="{{ $val }}" {{ old('luces_posicion') === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Luces de freno <span class="req">*</span></label>
                        <select name="luces_freno" class="form-control" required>
                            <option value="">Seleccionar...</option>
                            @foreach($estadoSimple as $val => $label)
                                <option value="{{ $val }}" {{ old('luces_freno') === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Sistema de frenos <span class="req">*</span></label>
                        <select name="sistema_frenos" class="form-control" required>
                            <option value="">Seleccionar...</option>
                            @foreach($estadoSimple as $val => $label)
                                <option value="{{ $val }}" {{ old('sistema_frenos') === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- NEUMÁTICOS --}}
                    <div class="col-12 mt-2">
                        <div class="section-title">Neumáticos y estructura</div>
                        <div class="divider-line"></div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Estado general de neumáticos <span class="req">*</span></label>
                        <textarea name="estado_neumaticos"
                                  class="form-control"
                                  rows="2"
                                  placeholder="Buenos o con detalles, indicar en cuál o cuáles"
                                  required>{{ old('estado_neumaticos') }}</textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Neumático de repuesto <span class="req">*</span></label>
                        <select name="neumatico_repuesto" class="form-control" required>
                            <option value="">Seleccionar...</option>
                            @foreach($estadoSimple as $val => $label)
                                <option value="{{ $val }}" {{ old('neumatico_repuesto') === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Estado de los tablones (solo camas bajas)</label>
                        <select name="estado_tablones" class="form-control">
                            <option value="">Seleccionar...</option>
                            @foreach($estadoSimple as $val => $label)
                                <option value="{{ $val }}" {{ old('estado_tablones') === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- VISIBILIDAD / CABINA --}}
                    <div class="col-12 mt-2">
                        <div class="section-title">Visibilidad y cabina</div>
                        <div class="divider-line"></div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Estado espejos retrovisores <span class="req">*</span></label>
                        <select name="estado_espejos" class="form-control" required>
                            <option value="">Seleccionar...</option>
                            @foreach($estadoSimple as $val => $label)
                                <option value="{{ $val }}" {{ old('estado_espejos') === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Parabrisas <span class="req">*</span></label>
                        <select name="parabrisas" class="form-control" required>
                            <option value="">Seleccionar...</option>
                            @foreach($estadoSimple as $val => $label)
                                <option value="{{ $val }}" {{ old('parabrisas') === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Calefacción y aire acondicionado <span class="req">*</span></label>
                        <select name="calefaccion_ac" class="form-control" required>
                            <option value="">Seleccionar...</option>
                            @foreach($estadoSimple as $val => $label)
                                <option value="{{ $val }}" {{ old('calefaccion_ac') === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Asiento del conductor <span class="req">*</span></label>
                        <select name="asiento_conductor" class="form-control" required>
                            <option value="">Seleccionar...</option>
                            @foreach($estadoSimple as $val => $label)
                                <option value="{{ $val }}" {{ old('asiento_conductor') === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- SISTEMA DE AIRE Y SEGURIDAD --}}
                    <div class="col-12 mt-2">
                        <div class="section-title">Sistema de aire y elementos de seguridad</div>
                        <div class="divider-line"></div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Funcionamiento acumulación sistema de aire <span class="req">*</span></label>
                        <select name="acumulacion_aire" class="form-control" required>
                            <option value="">Seleccionar...</option>
                            @foreach($estadoSimple as $val => $label)
                                <option value="{{ $val }}" {{ old('acumulacion_aire') === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Extintor <span class="req">*</span></label>
                        <select name="extintor" class="form-control" required>
                            <option value="">Seleccionar...</option>
                            <option value="vigente" {{ old('extintor') === 'vigente' ? 'selected' : '' }}>Vigente</option>
                            <option value="vencido" {{ old('extintor') === 'vencido' ? 'selected' : '' }}>Vencido</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Conos y cuñas de seguridad <span class="req">*</span></label>
                        <select name="conos_cunas" class="form-control" required>
                            <option value="">Seleccionar...</option>
                            @foreach($estadoSimple as $val => $label)
                                <option value="{{ $val }}" {{ old('conos_cunas') === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Trinquetes y cadenas <span class="req">*</span></label>
                        <select name="trinquetes_cadenas" class="form-control" required>
                            <option value="">Seleccionar...</option>
                            @foreach($estadoSimple as $val => $label)
                                <option value="{{ $val }}" {{ old('trinquetes_cadenas') === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- OTRO / RUIDOS / DETALLE MAL ESTADO --}}
                    <div class="col-12 mt-2">
                        <div class="section-title">Observaciones del motor y detalles</div>
                        <div class="divider-line"></div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Ruidos en el motor (describir)</label>
                        <input type="text"
                               name="ruidos_motor"
                               class="form-control"
                               value="{{ old('ruidos_motor') }}"
                               placeholder="Describa ruidos anormales si existen">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Describir los puntos seleccionados en “mal estado”</label>
                        <textarea name="detalle_mal_estado"
                                  rows="3"
                                  class="form-control"
                                  placeholder="Describa en detalle las observaciones asociadas a los puntos en mal estado">{{ old('detalle_mal_estado') }}</textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="back-link">
                        <a href="{{ route('login') }}">Volver al portal</a>
                    </div>
                    <button type="submit" class="btn btn-accent">
                        Guardar checklist
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Lógica para manejar conductor fijo / otro
        document.addEventListener('DOMContentLoaded', function () {
            const selectConductor = document.getElementById('nombre_conductor_select');
            const inputOtro = document.getElementById('nombre_conductor_otro');
            const hiddenNombre = document.getElementById('nombre_conductor_hidden');

            function syncConductor() {
                const val = selectConductor.value;
                if (val === '__otro__') {
                    inputOtro.style.display = '';
                    hiddenNombre.value = inputOtro.value;
                } else {
                    inputOtro.style.display = 'none';
                    hiddenNombre.value = val;
                }
            }

            selectConductor.addEventListener('change', syncConductor);
            inputOtro.addEventListener('input', function () {
                if (selectConductor.value === '__otro__') {
                    hiddenNombre.value = inputOtro.value;
                }
            });

            // estado inicial
            syncConductor();
        });
    </script>

    </body>
</x-laravel-ui-adminlte::adminlte-layout>
