<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Entrega - TJCA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" type="image/png">

    <style>
        :root{
            --bg-0:#101114;--bg-1:#15171b;--bg-2:#1c1f24;--bg-3:#23272e;
            --line:#2c3139;--ink:#e6e7ea;--muted:#a7adb7;
            --accent:#d4ad18;--accent-hover:#e1ba1f;--accent-ink:#0b0c0e;
            --shadow:0 14px 40px rgba(0,0,0,.45);
        }
        body{
            margin:0;
            min-height:100vh;
            background:var(--bg-0);
            color:var(--ink);
            font-family:"Inter", system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial, sans-serif;
            display:flex;
            align-items:center;
            justify-content:center;
        }
        .card{
            width:100%;
            max-width:900px;
            background:linear-gradient(180deg, var(--bg-2), var(--bg-1));
            border-radius:18px;
            border:1px solid var(--line);
            box-shadow:var(--shadow);
            padding:24px;
            margin:16px;
        }
        .card-header{
            display:flex;
            align-items:center;
            justify-content:space-between;
            margin-bottom:16px;
        }
        .card-header h1{
            font-size:1.1rem;
            margin:0;
        }
        .card-body{ margin-top:8px; }
        label{
            font-size:0.85rem;
            color:var(--muted);
        }
        .form-control{
            width:100%;
            background:#2a2f38;
            border:1px solid var(--line);
            color:var(--ink);
            border-radius:10px;
            height:42px;
            padding:6px 10px;
            margin-top:2px;
        }
        textarea.form-control{
            height:auto;
            min-height:80px;
        }
        .btn{
            border-radius:10px;
            height:46px;
            font-weight:700;
            letter-spacing:.3px;
            cursor:pointer;
        }
        .btn-accent{
            background:var(--accent);
            border:1px solid var(--accent);
            color:var(--accent-ink);
            width:100%;
        }
        .btn-accent:hover{
            background:var(--accent-hover);
            border-color:var(--accent-hover);
            box-shadow:0 10px 24px rgba(246,199,0,.28);
        }
        .row{
            display:flex;
            flex-wrap:wrap;
            gap:12px 16px;
        }
        .col-6{width:calc(50% - 8px);}
        .col-12{width:100%;}
        @media (max-width:768px){
            .col-6{width:100%;}
        }
        .alert-success{
            padding:10px 12px;
            border-radius:8px;
            background:#12351a;
            color:#b4f7c2;
            border:1px solid #206735;
            font-size:0.85rem;
            margin-bottom:12px;
        }
        .checkbox-row{
            display:flex;
            align-items:center;
            gap:8px;
            margin-top:6px;
        }
        .checkbox-row input{ width:auto; height:auto; }
    </style>
</head>
<body>
<div class="card">
    <div class="card-header">
        <h1>Formulario de entrega</h1>
        <img src="{{ asset('images/logo.png') }}" alt="TJCA" style="height:40px;">
    </div>

    <div class="card-body">
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('public.entrega.store') }}">
            @csrf

            <div class="row">
                {{-- OT --}}
                <div class="col-12">
                    <label for="ot_id">OT asociada</label>
                    <select name="ot_id" id="ot_id" class="form-control" required>
                        <option value="">Seleccione la OT</option>
                        @foreach($ots as $id => $label)
                            <option value="{{ $id }}" {{ old('ot_id') == $id ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('ot_id') <small style="color:#f88;">{{ $message }}</small> @enderror
                </div>

                {{-- Fecha y horas --}}
                <div class="col-6">
                    <label for="fecha_entrega">Fecha de entrega</label>
                    <input type="date" name="fecha_entrega" id="fecha_entrega"
                           class="form-control"
                           value="{{ old('fecha_entrega', date('Y-m-d')) }}" required>
                </div>

                <div class="col-6">
                    <label for="hora_llegada">Hora de llegada a cliente</label>
                    <input type="text" name="hora_llegada" id="hora_llegada"
                           class="form-control" placeholder="Ej: 10:15"
                           value="{{ old('hora_llegada') }}">
                </div>

                <div class="col-6">
                    <label for="hora_descarga_inicio">Inicio descarga</label>
                    <input type="text" name="hora_descarga_inicio" id="hora_descarga_inicio"
                           class="form-control" placeholder="Ej: 10:30"
                           value="{{ old('hora_descarga_inicio') }}">
                </div>

                <div class="col-6">
                    <label for="hora_descarga_fin">Fin descarga</label>
                    <input type="text" name="hora_descarga_fin" id="hora_descarga_fin"
                           class="form-control" placeholder="Ej: 11:05"
                           value="{{ old('hora_descarga_fin') }}">
                </div>

                {{-- Receptor --}}
                <div class="col-6">
                    <label for="nombre_receptor">Nombre receptor</label>
                    <input type="text" name="nombre_receptor" id="nombre_receptor"
                           class="form-control" value="{{ old('nombre_receptor') }}">
                </div>

                <div class="col-6">
                    <label for="rut_receptor">RUT receptor</label>
                    <input type="text" name="rut_receptor" id="rut_receptor"
                           class="form-control" value="{{ old('rut_receptor') }}">
                </div>

                {{-- Mercadería completa --}}
                <div class="col-12">
                    <label class="small text-muted">Estado de la carga</label>
                    <div class="checkbox-row">
                        <input type="checkbox" name="mercaderia_completa" id="mercaderia_completa"
                               value="1" {{ old('mercaderia_completa') ? 'checked' : '' }}>
                        <span>Mercadería recibida conforme / completa</span>
                    </div>
                </div>

                {{-- Observaciones --}}
                <div class="col-12">
                    <label for="observaciones">Observaciones</label>
                    <textarea name="observaciones" id="observaciones"
                              class="form-control">{{ old('observaciones') }}</textarea>
                </div>

                <div class="col-12" style="margin-top:10px;">
                    <button type="submit" class="btn btn-accent">
                        Enviar entrega
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>
