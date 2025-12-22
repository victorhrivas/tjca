<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cotización #{{ $cotizacion->id }}</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f6f8; font-family: Arial, Helvetica, sans-serif;">

@php
    $clienteNombre = optional($cotizacion->cliente_obj)->razon_social ?? 'Cliente';
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
                            Junto con saludar, le hacemos llegar adjunta la
                            <strong>cotización N° {{ $cotizacion->id }}</strong>,
                            correspondiente a su solicitud.
                        </p>

                        <p>
                            En el documento adjunto encontrará el detalle completo de la cotización,
                            incluyendo valores, condiciones y especificaciones del servicio ofrecido.
                        </p>

                        <p style="margin-bottom:0;">
                            Para cualquier consulta, aclaración o modificación,
                            le solicitamos contactar directamente a su ejecutivo comercial.
                        </p>
                    </td>
                </tr>

                {{-- AVISO NO-REPLY --}}
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
