<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cotización #{{ $cotizacion->id }}</title>
    <style>
        @page {
            margin: 40px 40px;
        }

        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 11px;
            color: #333;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        .header-table td {
            vertical-align: middle;
        }

        .logo {
            width: 140px;
        }

        .empresa-nombre {
            font-size: 16px;
            font-weight: bold;
            text-align: right;
        }

        .empresa-extra {
            font-size: 11px;
            text-align: right;
            color: #555;
        }

        .titulo-doc {
            font-size: 18px;
            font-weight: bold;
            text-align: left;
            margin: 10px 0 2px 0;
        }

        .subtitulo-doc {
            font-size: 12px;
            color: #555;
        }

        .bloque {
            margin-top: 12px;
            margin-bottom: 12px;
        }

        .tabla-datos {
            width: 100%;
            border: 1px solid #ccc;
        }

        .tabla-datos td {
            padding: 3px 4px;
        }

        .celda-label {
            font-weight: bold;
            background-color: #f5f5f5;
            width: 18%;
        }

        .celda-valor {
            width: 32%;
        }

        .separador {
            height: 8px;
        }

        .tabla-detalle {
            width: 100%;
            border: 1px solid #000;
            margin-top: 12px;
        }

        .tabla-detalle th,
        .tabla-detalle td {
            border: 1px solid #000;
            padding: 4px 5px;
            font-size: 10px;
        }

        .tabla-detalle thead th {
            background-color: #d9d9d9;
            text-align: center;
        }

        .alinear-derecha {
            text-align: right;
        }

        .alinear-centro {
            text-align: center;
        }

        .nota {
            font-size: 9px;
            margin-top: 8px;
        }

        .tabla-totales {
            width: 40%;
            margin-left: auto;
            margin-top: 10px;
            border-collapse: collapse;
        }

        .tabla-totales td {
            padding: 3px 4px;
            font-size: 10px;
        }

        .tabla-totales tr td:first-child {
            text-align: right;
            font-weight: bold;
            width: 50%;
        }

        .tabla-totales tr td:last-child {
            text-align: right;
            width: 50%;
        }

        .bloque-bancos {
            margin-top: 22px;
            border-top: 1px solid #ccc;
            padding-top: 8px;
            font-size: 10px;
        }

        .tabla-bancos td {
            padding: 2px 4px;
        }

        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 9px;
            text-transform: uppercase;
        }

        .badge-success { background-color: #d4edda; color: #155724; }
        .badge-danger  { background-color: #f8d7da; color: #721c24; }
        .badge-warning { background-color: #fff3cd; color: #856404; }
        .badge-secondary { background-color: #e2e3e5; color: #383d41; }
    </style>
</head>
<body>
@php
    // Intentar obtener nombre y RUT desde el campo cliente (que viene como JSON o string)
    $cliente = $cotizacion->cliente_obj;
    $rutCliente = $cliente->rut;

    if (!empty($cotizacion->cliente)) {
        // Intento decodificar como JSON
        $decoded = json_decode($cotizacion->cliente, true);

        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            // Caso: campo cliente guarda el objeto completo en JSON
            $clienteNombre = $decoded['razon_social'] ?? '—';
            $rutCliente    = $decoded['rut'] ?? '—';
        } else {
            // Caso: ya es un string normal (solo nombre)
            $clienteNombre = $cotizacion->cliente;
        }
    } else {
        // Fallback: tomar los datos desde la relación solicitud->cliente
        $clienteNombre = optional(optional($cotizacion->solicitud)->cliente)->razon_social ?? '—';
        $rutCliente    = optional(optional($cotizacion->solicitud)->cliente)->rut          ?? '—';
    }

    // Dirigido a: primero intento con contacto en la propia cotización,
    // si no, desde el cliente relacionado, si existiera.
    $dirigidoA = $cotizacion->solicitante
        ?? optional(optional($cotizacion->solicitud)->cliente)->contacto
        ?? '—';

    // Datos del ejecutivo desde el usuario de la cotización
    $ejecutivo     = $cotizacion->user;
    $ejecutivoNombre   = $ejecutivo->name  ?? '—';
    $ejecutivoEmail    = $ejecutivo->email ?? '—';

    // Si no tienes teléfono en la tabla users, puedes dejarlo fijo o vacío
    $ejecutivoTelefono = method_exists($ejecutivo, 'phone')
        ? ($ejecutivo->phone ?? '—')
        : '—';

    $condicionMoneda = 'CLP';
    $pais            = 'CHILE';

    $fechaEmision = optional($cotizacion->created_at) ?? now();
    $fechaValidez = $cotizacion->valido_hasta ?? $fechaEmision; // si no tienes campo, duplico

    // Cálculos de montos tipo Excel
    $precioUnitario = $cotizacion->monto ?? 0;
    $cantidad       = 1;
    $porcDescuento  = 0; // si más adelante agregas un campo, lo reemplazas acá
    $subtotal       = $precioUnitario * $cantidad;
    $montoDescuento = round($subtotal * ($porcDescuento / 100));
    $neto           = $subtotal - $montoDescuento;
    $iva            = round($neto * 0.19);
    $total          = $neto + $iva;

    // Badge de estado
    switch ($cotizacion->estado) {
        case 'aprobada':
        case 'aprobado':
        case 'aceptada':
        case 'aceptado':
            $badgeClass = 'badge-success';
            break;
        case 'rechazada':
        case 'rechazado':
            $badgeClass = 'badge-danger';
            break;
        case 'enviada':
        case 'pendiente':
            $badgeClass = 'badge-warning';
            break;
        default:
            $badgeClass = 'badge-secondary';
            break;
    }
@endphp


{{-- ENCABEZADO (LOGO + DATOS EMPRESA/CONTACTO) --}}
<table class="header-table">
    <tr>
        <td>
            @php
                $logoPath = public_path('images/logo.png');
            @endphp
            @if(file_exists($logoPath))
                <img src="{{ $logoPath }}" class="logo" alt="Logo empresa">
            @endif
        </td>
        <td>
            <div class="empresa-nombre">
                Transportes TJCA
            </div>
            <div class="empresa-extra">
                Direccion: Av. Los Pescadores #4639, Coquimbo.<br>
                Telefono: 971097698
            </div>
        </td>
    </tr>
</table>

<div class="bloque" style="margin-top: 10px;">
    <div class="titulo-doc">
        COTIZACIÓN #{{ $cotizacion->id }}
    </div>
    <div class="subtitulo-doc">
        Estado:
        <span class="badge {{ $badgeClass }}">
            {{ strtoupper($cotizacion->estado) }}
        </span>
    </div>
</div>

{{-- BLOQUE DATOS CLIENTE / EJECUTIVO (MISMOS CAMPOS QUE EL EXCEL) --}}
<div class="bloque">
    <table class="tabla-datos">
        {{-- Fila Cliente / Rut --}}
        <tr>
            <td class="celda-label">Cliente:</td>
            <td class="celda-valor">{{ $clienteNombre }}</td>
            <td class="celda-label">Rut Cliente:</td>
            <td class="celda-valor">{{ $rutCliente }}</td>
        </tr>

        {{-- separación visual como en el Excel --}}
        <tr><td colspan="4" class="separador"></td></tr>

        {{-- Dirigido a / Ejecutivo --}}
        <tr>
            <td class="celda-label">Dirigido a:</td>
            <td class="celda-valor">{{ $dirigidoA }}</td>
            <td class="celda-label">Ejecutivo:</td>
            <td class="celda-valor">{{ $ejecutivoNombre }}</td>
        </tr>

        <tr><td colspan="4" class="separador"></td></tr>

        {{-- Condición / Fono Ejecutivo --}}
        <tr>
            <td class="celda-label">Condicion:</td>
            <td class="celda-valor">{{ $condicionMoneda }}</td>
            <td class="celda-label">Fono Ejecutivo:</td>
            <td class="celda-valor">{{ $ejecutivoTelefono }}</td>
        </tr>

        <tr><td colspan="4" class="separador"></td></tr>

        {{-- Emisión / Email Ejecutivo --}}
        <tr>
            <td class="celda-label">Emision:</td>
            <td class="celda-valor">{{ $fechaEmision->format('d/m/Y') }}</td>
            <td class="celda-label">Email Ejecutivo:</td>
            <td class="celda-valor">{{ $ejecutivoEmail }}</td>
        </tr>

        <tr><td colspan="4" class="separador"></td></tr>

        {{-- Validez / País --}}
        <tr>
            <td class="celda-label">Valido hasta:</td>
            <td class="celda-valor">{{ $fechaValidez->format('d/m/Y') }}</td>
            <td class="celda-label">Pais:</td>
            <td class="celda-valor">{{ $pais }}</td>
        </tr>
    </table>
</div>

{{-- NOTA STAND BY (TEXTO DEL EXCEL) --}}
<div class="bloque">
    <div class="nota">
        En caso de generar Stand By el cliente asume el costo diario de
        $450.000.- más IVA (por concepto de cama baja y/o Rampla).
    </div>
</div>

{{-- TABLA DETALLE (ENCABEZADOS COMO EN EL EXCEL: Detalle, Precio uni, Uni., Neto, % Desc, Total) --}}
<div class="bloque">
    <table class="tabla-detalle">
        <thead>
            <tr>
                <th colspan="7" class="alinear-centro">Detalle</th>
                <th>Precio uni</th>
                <th>Uni.</th>
                <th>Neto</th>
                <th>% Desc</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                {{-- "Servicio" + descripción de la carga / servicio --}}
                <td colspan="2"><strong>Servicio</strong></td>
                <td colspan="5">
                    {{ $cotizacion->carga
                        ?? 'Servicio de transporte / movimiento de carga' }}
                </td>

                <td class="alinear-derecha">
                    $ {{ number_format($precioUnitario, 0, ',', '.') }}
                </td>
                <td class="alinear-centro">
                    {{ $cantidad }}
                </td>
                <td class="alinear-derecha">
                    $ {{ number_format($subtotal, 0, ',', '.') }}
                </td>
                <td class="alinear-centro">
                    {{ $porcDescuento }}%
                </td>
                <td class="alinear-derecha">
                    $ {{ number_format($subtotal - $montoDescuento, 0, ',', '.') }}
                </td>
            </tr>

            {{-- FILA ORIGEN / DESTINO CON ESPACIO SIMÉTRICO --}}
            <tr>
                <td class="celda-label" colspan="2">Origen</td>
                <td class="celda-valor celda-origen" colspan="4">
                    {{ $cotizacion->origen
                        ?? optional($cotizacion->solicitud)->origen
                        ?? '—' }}
                </td>

                <td class="celda-label" colspan="2">Destino</td>
                <td class="celda-valor celda-destino" colspan="4">
                    {{ $cotizacion->destino
                        ?? optional($cotizacion->solicitud)->destino
                        ?? '—' }}
                </td>
            </tr>

            {{-- Más filas de detalle si quieres --}}
        </tbody>
    </table>
</div>

{{-- NOTA DE VIDRIOS (RESUMIDA) --}}
<div class="bloque">
    <div class="nota">
        Todo equipo que tenga vidrios en puertas y ventanas (automóviles,
        camiones, maquinaria pesada como excavadoras, bulldozer o similares),
        debe contar con seguro de vidrios a nombre del cliente. La empresa
        contratante del servicio es responsable de contar con dicho seguro;
        ante el traslado del equipo, si no se cumple esa condición, la
        responsabilidad de daños es del cliente.
    </div>
</div>

{{-- TABLA TOTALES (TOTAL, DESCUENTO, NETO, IVA, TOTAL) AL ESTILO EXCEL --}}
<div class="bloque">
    <table class="tabla-totales">
        <tr>
            <td>Total</td>
            <td>$ {{ number_format($subtotal, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Descuento</td>
            <td>$ {{ number_format($montoDescuento, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Neto</td>
            <td>$ {{ number_format($neto, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>IVA (19%)</td>
            <td>$ {{ number_format($iva, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Total</td>
            <td>$ {{ number_format($total, 0, ',', '.') }}</td>
        </tr>
    </table>
</div>

{{-- BLOQUE DATOS BANCARIOS (IGUAL AL EXCEL) --}}
<div class="bloque-bancos">
    <table class="tabla-bancos">
        <tr>
            <td style="font-weight:bold; width: 20%;">Datos Bancarios:</td>
            <td style="width: 55%;">
                Banco Santander, Cuenta Corriente N°: 67580060<br>
                Soc. De Transportes y Gruas Jorge Contador Ltda.<br>
                Giro: Transporte de carga por carretera
            </td>
            <td style="width: 10%; text-align: right;">Rut:</td>
            <td style="width: 15%;">76.335.362-1</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td style="text-align: right;">Contacto:</td>
            <td>Leslie Smythe</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td style="text-align: right;">Email:</td>
            <td>lsc@tjca.cl</td>
        </tr>
    </table>
</div>
</body>
</html>
