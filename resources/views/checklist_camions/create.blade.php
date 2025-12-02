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

        <div class="card-section">
            @php
                $estadoSimple = [
                    'buen_estado' => 'Buen estado',
                    'mal_estado'  => 'Mal estado',
                ];
            @endphp

            <form method="POST" action="{{ route('checklist-camions.store') }}">
                @csrf

                <div class="row">
                    {{-- Datos generales --}}
                    <div class="col-12">
                        <div class="section-title">Datos generales</div>
                        <div class="divider-line"></div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Nombre del conductor</label>
                        <input type="text"
                               name="nombre_conductor"
                               class="form-control"
                               value="{{ old('nombre_conductor') }}"
                               required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label>Patente</label>
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

                    {{-- Iluminación y frenos --}}
                    <div class="col-12 mt-2">
                        <div class="section-title">Iluminación y frenos</div>
                        <div class="divider-line"></div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Luces altas / bajas</label>
                        <select name="luces_altas_bajas" class="form-control">
                            <option value="">Seleccionar...</option>
                            @foreach($estadoSimple as $val => $label)
                                <option value="{{ $val }}" {{ old('luces_altas_bajas') === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Intermitentes</label>
                        <select name="intermitentes" class="form-control">
                            <option value="">Seleccionar...</option>
                            @foreach($estadoSimple as $val => $label)
                                <option value="{{ $val }}" {{ old('intermitentes') === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Luces de posición</label>
                        <select name="luces_posicion" class="form-control">
                            <option value="">Seleccionar...</option>
                            @foreach($estadoSimple as $val => $label)
                                <option value="{{ $val }}" {{ old('luces_posicion') === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Luces de freno</label>
                        <select name="luces_freno" class="form-control">
                            <option value="">Seleccionar...</option>
                            @foreach($estadoSimple as $val => $label)
                                <option value="{{ $val }}" {{ old('luces_freno') === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Sistema de frenos</label>
                        <select name="sistema_frenos" class="form-control">
                            <option value="">Seleccionar...</option>
                            @foreach($estadoSimple as $val => $label)
                                <option value="{{ $val }}" {{ old('sistema_frenos') === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Seguridad y visibilidad --}}
                    <div class="col-12 mt-2">
                        <div class="section-title">Seguridad y visibilidad</div>
                        <div class="divider-line"></div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Espejos</label>
                        <select name="estado_espejos" class="form-control">
                            <option value="">Seleccionar...</option>
                            @foreach($estadoSimple as $val => $label)
                                <option value="{{ $val }}" {{ old('estado_espejos') === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Parabrisas</label>
                        <select name="parabrisas" class="form-control">
                            <option value="">Seleccionar...</option>
                            @foreach($estadoSimple as $val => $label)
                                <option value="{{ $val }}" {{ old('parabrisas') === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Calefacción / A.C.</label>
                        <select name="calefaccion_ac" class="form-control">
                            <option value="">Seleccionar...</option>
                            @foreach($estadoSimple as $val => $label)
                                <option value="{{ $val }}" {{ old('calefaccion_ac') === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Neumáticos y estructura --}}
                    <div class="col-12 mt-2">
                        <div class="section-title">Neumáticos y estructura</div>
                        <div class="divider-line"></div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Estado neumáticos</label>
                        <input type="text"
                               name="estado_neumaticos"
                               class="form-control"
                               value="{{ old('estado_neumaticos') }}"
                               placeholder="Descripción general">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Neumático de repuesto</label>
                        <select name="neumatico_repuesto" class="form-control">
                            <option value="">Seleccionar...</option>
                            @foreach($estadoSimple as $val => $label)
                                <option value="{{ $val }}" {{ old('neumatico_repuesto') === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Tablones</label>
                        <select name="estado_tablones" class="form-control">
                            <option value="">Seleccionar...</option>
                            @foreach($estadoSimple as $val => $label)
                                <option value="{{ $val }}" {{ old('estado_tablones') === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Acumulación de aire</label>
                        <select name="acumulacion_aire" class="form-control">
                            <option value="">Seleccionar...</option>
                            @foreach($estadoSimple as $val => $label)
                                <option value="{{ $val }}" {{ old('acumulacion_aire') === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Equipamiento de seguridad --}}
                    <div class="col-12 mt-2">
                        <div class="section-title">Equipamiento de seguridad</div>
                        <div class="divider-line"></div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Extintor</label>
                        <select name="extintor" class="form-control">
                            <option value="">Seleccionar...</option>
                            <option value="vigente" {{ old('extintor') === 'vigente' ? 'selected' : '' }}>Vigente</option>
                            <option value="vencido" {{ old('extintor') === 'vencido' ? 'selected' : '' }}>Vencido</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Conos / cunas</label>
                        <select name="conos_cunas" class="form-control">
                            <option value="">Seleccionar...</option>
                            @foreach($estadoSimple as $val => $label)
                                <option value="{{ $val }}" {{ old('conos_cunas') === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Trinquetes / cadenas</label>
                        <select name="trinquetes_cadenas" class="form-control">
                            <option value="">Seleccionar...</option>
                            @foreach($estadoSimple as $val => $label)
                                <option value="{{ $val }}" {{ old('trinquetes_cadenas') === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Cabina y motor --}}
                    <div class="col-12 mt-2">
                        <div class="section-title">Cabina y motor</div>
                        <div class="divider-line"></div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Asiento conductor</label>
                        <select name="asiento_conductor" class="form-control">
                            <option value="">Seleccionar...</option>
                            @foreach($estadoSimple as $val => $label)
                                <option value="{{ $val }}" {{ old('asiento_conductor') === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Nivel de aceite</label>
                        <input type="text"
                               name="nivel_aceite"
                               class="form-control"
                               value="{{ old('nivel_aceite') }}"
                               placeholder="Dentro de rango, requiere cambio, etc.">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Ruidos motor</label>
                        <input type="text"
                               name="ruidos_motor"
                               class="form-control"
                               value="{{ old('ruidos_motor') }}"
                               placeholder="Descripción de ruidos extraños (si aplica)">
                    </div>

                    {{-- Detalle mal estado --}}
                    <div class="col-md-12 mb-3">
                        <label>Detalle de elementos en mal estado</label>
                        <textarea name="detalle_mal_estado"
                                  rows="3"
                                  class="form-control"
                                  placeholder="Detalla los puntos que requieren reparación o atención">{{ old('detalle_mal_estado') }}</textarea>
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
    </body>
</x-laravel-ui-adminlte::adminlte-layout>
