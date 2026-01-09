<?php

namespace App\Mail;

use App\Models\InicioCarga;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InicioCargaMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public InicioCarga $inicioCarga) {}

    public function build()
    {
        $ot = $this->inicioCarga->ot; // requiere relación en el modelo

        return $this->subject('Inicio de carga - OT #' . ($ot->folio ?? $this->inicioCarga->ot_id))
            ->view('emails.inicio_carga')
            ->with([
                'inicio' => $this->inicioCarga,
                'ot'     => $ot,
            ]);
    }
}
