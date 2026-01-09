<?php

namespace App\Mail;

use App\Models\Entrega;
use App\Models\Ot;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EntregaRegistradaMail extends Mailable
{
    use Queueable, SerializesModels;

    public Entrega $entrega;
    public Ot $ot;

    public function __construct(Entrega $entrega, Ot $ot)
    {
        $this->entrega = $entrega;
        $this->ot = $ot;
    }

    public function build()
    {
        $folio = $this->ot->folio ?? $this->ot->id ?? $this->entrega->ot_id;

        return $this->subject("Entrega registrada - OT #{$folio}")
            ->view('emails.entrega_registrada')
            ->with([
                'entrega' => $this->entrega,
                'ot' => $this->ot,
            ]);
    }
}
