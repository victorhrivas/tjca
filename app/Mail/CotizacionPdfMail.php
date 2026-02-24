<?php

namespace App\Mail;

use App\Models\Cotizacion;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CotizacionPdfMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Cotizacion $cotizacion,
        public string $pdfBinary,
        public string $fileName
    ) {}

    public function build()
    {
        $clienteNombre = optional($this->cotizacion->cliente_obj)->razon_social ?? 'Cliente';

        return $this->subject(
                'Cotización N° ' . $this->cotizacion->id . ' | ' . $clienteNombre . ' | ' . config('app.name')
            )
            ->view('emails.cotizacion_pdf')
            ->attachData($this->pdfBinary, $this->fileName, [
                'mime' => 'application/pdf',
            ]);
    }

}
