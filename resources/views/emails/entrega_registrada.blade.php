<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Entrega registrada - OT {{ $ot->folio ?? $ot->id ?? $entrega->ot_id }}</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f6f8; font-family: Arial, Helvetica, sans-serif;">

@php
    $clienteNombre = $entrega->cliente ?? (optional($ot->cotizacion)->cliente ?? 'Cliente');
    $folioOt = $ot->folio ?? $ot->id ?? $entrega->ot_id;

    $fechaEntrega = $entrega->fecha_entrega
        ? \Carbon\Carbon::parse($entrega->fecha_entrega)->format('d-m-Y')
        : null;

    $rows = [
        'OT'                => $folioOt,
        'Cliente'           => $clienteNombre,
        'Lugar de entrega'  => $entrega->lugar_entrega ?? null,
        'Fecha de entrega'  => $fechaEntrega,
        'Hora de entrega'   => $entrega->hora_entrega ?? null,
        'Receptor'          => $entrega->nombre_receptor ?? null,
        'RUT receptor'      => $entrega->rut_receptor ?? null,
        'Teléfono receptor' => $entrega->telefono_receptor ?? null,
        'Correo receptor'   => $entrega->correo_receptor ?? null,
        'N° guía'           => $entrega->numero_guia ?? null,
        'N° interno'        => $entrega->numero_interno ?? null,
        'Conductor'         => $entrega->conductor ?? null,
        'Conforme'          => is_null($entrega->conforme) ? null : ($entrega->conforme ? 'Sí' : 'No'),
    ];
@endphp

<table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f6f8; padding:30px 0;">
    <tr>
        <td align="center">

            <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:6px; overflow:hidden;">

                {{-- HEADER --}}
                <tr>
                    <td style="background:#1f2933; padding:20px; text-align:center;">
                        <img
                            src="{{ $message->embed(public_path('images/logo.png')) }}"
                            alt="Logo {{ config('app.name') }}"
                            style="max-height:90px; display:block; margin:0 auto;"
                        >
                    </td>
                </tr>

                {{-- BODY --}}
                <tr>
                    <td style="padding:30px; color:#333333; font-size:14px; line-height:1.6;">

                        <p style="margin-top:0;">
                            Estimado/a <strong>{{ $clienteNombre }}</strong>,
                        </p>

                        <p>
                            Junto con saludar, le informamos que se registró correctamente la
                            <strong>entrega</strong> asociada a la <strong>OT #{{ $folioOt }}</strong>.
                        </p>

                        {{-- Resumen --}}
                        <table width="100%" cellpadding="0" cellspacing="0" style="margin:18px 0; border:1px solid #e5e7eb; border-radius:6px; overflow:hidden;">
                            <tr>
                                <td style="background:#f9fafb; padding:12px 16px; font-weight:bold; color:#111827; font-size:13px;">
                                    Resumen de la entrega
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:14px 16px;">
                                    <table width="100%" cellpadding="0" cellspacing="0" style="font-size:13px; color:#374151;">
                                        @foreach($rows as $label => $value)
                                            @if(!empty($value))
                                                <tr>
                                                    <td style="padding:6px 0; width:42%; color:#6b7280;">
                                                        {{ $label }}
                                                    </td>
                                                    <td style="padding:6px 0; font-weight:600; color:#111827;">
                                                        {{ $value }}
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </table>
                                </td>
                            </tr>
                        </table>

                        @if(!empty($entrega->observaciones))
                            <div style="margin-top:16px;">
                                <div style="font-weight:bold; color:#111827; margin-bottom:6px; font-size:13px;">
                                    Observaciones
                                </div>
                                <div style="background:#f9fafb; border:1px solid #e5e7eb; border-radius:6px; padding:12px 14px; color:#374151; font-size:13px;">
                                    {!! nl2br(e($entrega->observaciones)) !!}
                                </div>
                            </div>
                        @endif

                        <p style="margin:18px 0 0 0;">
                            Si necesita más información, por favor contáctenos por los canales habituales.
                        </p>

                    </td>
                </tr>

                {{-- AVISO --}}
                <tr>
                    <td style="padding:20px 30px; background:#f9fafb; color:#6b7280; font-size:12px;">
                        <strong>Importante:</strong><br>
                        Este correo ha sido generado automáticamente.
                        Por favor <strong>no responda a este mensaje</strong>,
                        ya que esta casilla no se encuentra habilitada para recibir respuestas.
                    </td>
                </tr>

                {{-- FOOTER --}}
                <tr>
                    <td style="padding:20px; text-align:center; font-size:12px; color:#9ca3af;">
                        © {{ date('Y') }} {{ config('app.name') }}<br>
                        Todos los derechos reservados.
                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>
