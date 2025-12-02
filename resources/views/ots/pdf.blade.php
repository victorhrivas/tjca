<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>OT #{{ $ot->id }}</title>
    <style>
        @page {
            margin: 40px 40px;
        }

        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header,
        .footer {
            width: 100%;
        }

        .header {
            margin-bottom: 30px;
        }

        .header-table {
            width: 100%;
        }

        .header-table td {
            vertical-align: middle;
        }

        .logo {
            width: 140px;
        }

        .company-name {
            font-size: 16px;
            font-weight: bold;
            text-align: right;
        }

        .company-extra {
            font-size: 11px;
            text-align: right;
            color: #777;
        }

        h1 {
            font-size: 20px;
            margin: 0 0 5px 0;
        }

        .section {
            margin-bottom: 18px;
        }

        .section-title {
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            color: #555;
            border-bottom: 1px solid #ddd;
            margin-bottom: 6px;
            padding-bottom: 3px;
        }

        table.info-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 4px;
        }

        table.info-table td {
            padding: 4px 3px;
            vertical-align: top;
        }

        .label {
            font-weight: bold;
            color: #555;
            width: 30%;
        }

        .value {
            width: 70%;
        }

        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 11px;
            text-transform: uppercase;
        }

        .badge-success { background-color: #d4edda; color: #155724; }
        .badge-danger  { background-color: #f8d7da; color: #721c24; }
        .badge-warning { background-color: #fff3cd; color: #856404; }
        .badge-info    { background-color: #d1ecf1; color: #0c5460; }
        .badge-secondary { background-color: #e2e3e5; color: #383d41; }

        .footer {
            position: fixed;
            bottom: 20px;
            left: 40px;
            right: 40px;
            font-size: 10px;
            color: #999;
            text-align: center;
        }
    </style>
</head>
<body>
    {{-- Encabezado corporativo --}}
    <div class="header">
        <table class="header-table">
            <tr>
                <td>
                    @php
                        // Ajusta extensión según tu archivo real
                        $logoPath = public_path('images/logo.png');
                    @endphp
                    @if(file_exists($logoPath))
                        <img src="{{ $logoPath }}" class="logo" alt="Logo empresa">
                    @endif
                </td>
                <td>
                    <div class="company-name">
                        Transportes TJCA
                    </div>
                    <div class="company-extra">
                        RUT 76.123.456-7<br>
                        Dirección corporativa<br>
                        Tel: +56 2 XXXX XXXX · www.ejemplo.cl
                    </div>
                </td>
            </tr>
        </table>
    </div>

    {{-- Título y estado --}}
    <div class="section">
        <h1>Orden de trabajo #{{ $ot->id }}</h1>

        @php
            switch ($ot->estado) {
                case 'entregada':
                    $badgeClass = 'badge-success';
                    break;
                case 'en_transito':
                    $badgeClass = 'badge-warning';
                    break;
                case 'inicio_carga':
                    $badgeClass = 'badge-info';
                    break;
                default:
                    $badgeClass = 'badge-secondary';
                    break;
            }

            $estadoLabel = ucwords(str_replace('_', ' ', $ot->estado));
        @endphp

        <p>
            Estado:
            <span class="badge {{ $badgeClass }}">
                {{ $estadoLabel }}
            </span>
        </p>

        <p>
            Fecha de creación OT:
            <strong>{{ optional($ot->created_at)->format('d/m/Y') }}</strong><br>
            Fecha de generación de documento:
            <strong>{{ now()->format('d/m/Y H:i') }}</strong>
        </p>
    </div>

    {{-- Datos del servicio --}}
    <div class="section">
        <div class="section-title">Datos del servicio</div>
        <table class="info-table">
            <tr>
                <td class="label">Cliente:</td>
                <td class="value">
                    @if($ot->cotizacion && $ot->cotizacion->cliente)
                        {{ $ot->cotizacion->cliente }}
                    @else
                        No informado
                    @endif
                </td>
            </tr>
            <tr>
                <td class="label">Origen:</td>
                <td class="value">
                    @if($ot->cotizacion && $ot->cotizacion->origen)
                        {{ $ot->cotizacion->origen }}
                    @else
                        No especificado
                    @endif
                </td>
            </tr>
            <tr>
                <td class="label">Destino:</td>
                <td class="value">
                    @if($ot->cotizacion && $ot->cotizacion->destino)
                        {{ $ot->cotizacion->destino }}
                    @else
                        No especificado
                    @endif
                </td>
            </tr>
            <tr>
                <td class="label">Carga:</td>
                <td class="value">
                    @if($ot->cotizacion && $ot->cotizacion->carga)
                        {{ $ot->cotizacion->carga }}
                    @else
                        No especificada
                    @endif
                </td>
            </tr>
        </table>
    </div>

    {{-- Datos operativos --}}
    <div class="section">
        <div class="section-title">Datos operativos</div>
        <table class="info-table">
            <tr>
                <td class="label">Conductor:</td>
                <td class="value">{{ $ot->conductor ?: 'No asignado' }}</td>
            </tr>
            <tr>
                <td class="label">Patente camión:</td>
                <td class="value">{{ $ot->patente_camion ?: 'No registrada' }}</td>
            </tr>
            <tr>
                <td class="label">Patente remolque:</td>
                <td class="value">{{ $ot->patente_remolque ?: 'No registrada' }}</td>
            </tr>
        </table>
    </div>

    {{-- Información económica --}}
    <div class="section">
        <div class="section-title">Información económica</div>
        <table class="info-table">
            <tr>
                <td class="label">Cotización asociada:</td>
                <td class="value">
                    @if($ot->cotizacion)
                        Cotización #{{ $ot->cotizacion->id }}
                    @else
                        Sin cotización asociada
                    @endif
                </td>
            </tr>
        </table>
    </div>

    {{-- Observaciones --}}
    <div class="section">
        <div class="section-title">Observaciones</div>
        <p>
            {{-- Si luego agregas un campo observaciones en la OT, lo usas aquí --}}
            {{ $ot->observaciones ?? 'Sin observaciones registradas.' }}
        </p>
    </div>

    <div class="footer">
        Documento generado automáticamente desde el sistema de gestión de operaciones.
    </div>
</body>
</html>
