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
        $ot = $this->inicioCarga->ot;

        // Rutas absolutas para embebido (inline)
        $inlinePhotos = collect([
            $this->inicioCarga->foto_1,
            $this->inicioCarga->foto_2,
            $this->inicioCarga->foto_3,
            $this->inicioCarga->foto_guia_despacho,
        ])
            ->filter()
            ->map(fn ($p) => storage_path('app/public/' . ltrim($p, '/')))
            ->filter(fn ($abs) => is_file($abs) && is_readable($abs))
            ->values()
            ->all();

        // Adjuntos (opcional): adjuntar TODO lo anterior
        // Si prefieres NO adjuntar, comenta el foreach de abajo.
        $mail = $this->subject('Inicio de carga - OT #' . ($ot->folio ?? $this->inicioCarga->ot_id))
            ->view('emails.inicio_carga')
            ->with([
                'inicio'        => $this->inicioCarga,
                'ot'            => $ot,
                'inlinePhotos'  => $inlinePhotos,
            ]);

        foreach ($inlinePhotos as $i => $abs) {
            $ext = pathinfo($abs, PATHINFO_EXTENSION) ?: 'jpg';
            $mail->attach($abs, [
                'as' => 'inicio_carga_' . ($i + 1) . '.' . $ext,
            ]);
        }

        return $mail;
    }
}