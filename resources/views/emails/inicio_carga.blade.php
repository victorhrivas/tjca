<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Inicio de carga - OT {{ $ot->folio ?? $ot->id ?? $inicio->ot_id }}</title>
</head>

<body style="margin:0; padding:0; background-color:#f4f6f8;">
@php
  $clienteNombre = $inicio->cliente ?? 'Cliente';
  $folioOt = $ot->folio ?? $ot->id ?? $inicio->ot_id;

  $fechaCarga = $inicio->fecha_carga
    ? \Carbon\Carbon::parse($inicio->fecha_carga)->format('d-m-Y')
    : null;

  $horaPresentacion = $inicio->hora_presentacion ?? null;

  $rows = [
    'OT'                => $folioOt,
    'Cliente'           => $inicio->cliente ?? null,
    'Origen'            => $inicio->origen ?? null,
    'Destino'           => $inicio->destino ?? null,
    'Fecha de carga'    => $fechaCarga,
    'Hora presentación' => $horaPresentacion,
    'Conductor'         => $inicio->conductor ?? null,
    'Tipo de carga'     => $inicio->tipo_carga ?? null,
    'Peso aproximado'   => $inicio->peso_aproximado ?? null,
  ];
@endphp

  <!-- Preheader (oculto) -->
  <div style="display:none; font-size:1px; line-height:1px; max-height:0; max-width:0; opacity:0; overflow:hidden; mso-hide:all;">
    Inicio de carga registrado para OT {{ $folioOt }}.
  </div>

  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
         bgcolor="#f4f6f8"
         style="background-color:#f4f6f8; mso-table-lspace:0pt; mso-table-rspace:0pt; border-collapse:collapse;">
    <tr>
      <td align="center" style="padding:30px 12px;">

        <!--[if (mso)|(IE)]>
        <table role="presentation" width="600" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse;">
          <tr>
            <td>
        <![endif]-->

        <!-- Card -->
        <table role="presentation" cellpadding="0" cellspacing="0" border="0"
               width="600"
               bgcolor="#ffffff"
               style="width:600px; max-width:600px; background-color:#ffffff;
                      border-collapse:separate; mso-table-lspace:0pt; mso-table-rspace:0pt;
                      border:1px solid #e5e7eb; border-radius:8px;">

          <!-- HEADER -->
          <tr>
            <td align="center" bgcolor="#1f2933"
                style="background-color:#1f2933; padding:22px; border-top-left-radius:8px; border-top-right-radius:8px;">
              <img
                src="{{ $message->embed(public_path('images/logo.png')) }}"
                alt="Logo {{ config('app.name') }}"
                width="140"
                border="0"
                style="display:block; width:140px; height:auto; border:0; outline:none; text-decoration:none; -ms-interpolation-mode:bicubic;">
            </td>
          </tr>

          <!-- BODY -->
          <tr>
            <td style="padding:30px; font-family:Arial, Helvetica, sans-serif; color:#333333;
                       font-size:14px; line-height:22px; mso-line-height-rule:exactly;">

              <p style="margin:0 0 14px 0;">
                Estimado/a <strong>{{ $clienteNombre }}</strong>,
              </p>

              <p style="margin:0 0 14px 0;">
                Junto con saludar, le informamos que se registró correctamente el
                <strong>inicio de carga</strong> asociado a la
                <strong>OT #{{ $folioOt }}</strong>.
              </p>

              <!-- Resumen del servicio (sin border-radius/overflow para Outlook) -->
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
                     style="border-collapse:collapse; margin:18px 0; border:1px solid #e5e7eb;">
                <tr>
                  <td bgcolor="#f9fafb"
                      style="background-color:#f9fafb; padding:12px 16px; font-family:Arial, Helvetica, sans-serif;
                             font-weight:bold; color:#111827; font-size:13px; line-height:18px; mso-line-height-rule:exactly;">
                    Resumen del servicio
                  </td>
                </tr>
                <tr>
                  <td style="padding:14px 16px;">
                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
                           style="border-collapse:collapse; font-family:Arial, Helvetica, sans-serif; font-size:13px;
                                  color:#374151; line-height:18px; mso-line-height-rule:exactly;">
                      @foreach($rows as $label => $value)
                        @if(!empty($value))
                          <tr>
                            <td valign="top" style="padding:6px 0; width:42%; color:#6b7280;">
                              {{ $label }}
                            </td>
                            <td valign="top" style="padding:6px 0; font-weight:bold; color:#111827;">
                              {{ $value }}
                            </td>
                          </tr>
                        @endif
                      @endforeach
                    </table>
                  </td>
                </tr>
              </table>

              @if(!empty($inicio->observaciones))
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse; margin-top:16px;">
                  <tr>
                    <td style="font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#111827; font-size:13px; line-height:18px; mso-line-height-rule:exactly; padding:0 0 6px 0;">
                      Observaciones
                    </td>
                  </tr>
                  <tr>
                    <td bgcolor="#f9fafb"
                        style="background-color:#f9fafb; border:1px solid #e5e7eb; padding:12px 14px;
                               font-family:Arial, Helvetica, sans-serif; color:#374151; font-size:13px; line-height:18px; mso-line-height-rule:exactly;">
                      {!! nl2br(e($inicio->observaciones)) !!}
                    </td>
                  </tr>
                </table>
              @endif

              <p style="margin:18px 0 0 0;">
                Si necesita más información o desea modificar algún dato, por favor contáctenos por los canales habituales.
              </p>

            </td>
          </tr>

          <!-- DIVIDER -->
          <tr>
            <td style="padding:0 30px;">
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse;">
                <tr>
                  <td style="height:1px; line-height:1px; font-size:0; background-color:#eef2f7;">&nbsp;</td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- AVISO -->
          <tr>
            <td bgcolor="#f9fafb"
                style="background-color:#f9fafb; padding:18px 30px;
                       font-family:Arial, Helvetica, sans-serif; color:#6b7280;
                       font-size:12px; line-height:18px; mso-line-height-rule:exactly;">
              <strong>Importante:</strong><br>
              Este correo ha sido generado automáticamente.
              Por favor <strong>no responda a este mensaje</strong>,
              ya que esta casilla no se encuentra habilitada para recibir respuestas.
            </td>
          </tr>

          <!-- FOOTER -->
          <tr>
            <td align="center"
                style="padding:18px 20px; font-family:Arial, Helvetica, sans-serif; color:#9ca3af;
                       font-size:12px; line-height:18px; mso-line-height-rule:exactly;
                       border-bottom-left-radius:8px; border-bottom-right-radius:8px;">
              © {{ date('Y') }} {{ config('app.name') }}<br>
              Todos los derechos reservados.
            </td>
          </tr>

        </table>
        <!-- /Card -->

        <!--[if (mso)|(IE)]>
            </td>
          </tr>
        </table>
        <![endif]-->

      </td>
    </tr>
  </table>

</body>
</html>
