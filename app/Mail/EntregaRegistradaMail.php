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

    public function __construct(
        public Entrega $entrega,
        public Ot $ot
    ) {}

    public function build()
    {
        $folio = $this->ot->folio ?? $this->ot->id ?? $this->entrega->ot_id;

        // Recolectar paths relativos de fotos (compat: foto_1..3 y foto_guia_despacho)
        $photoRelPaths = collect([
            $this->entrega->foto_1,
            $this->entrega->foto_2,
            $this->entrega->foto_3,
            $this->entrega->foto_guia_despacho, // compat antigua
        ])->filter();

        // NUEVO: si existe relación guias (entrega_guias)
        if (method_exists($this->entrega, 'guias') && $this->entrega->relationLoaded('guias')) {
            $photoRelPaths = $photoRelPaths->merge(
                $this->entrega->guias->pluck('archivo')->filter()
            );
        } elseif (method_exists($this->entrega, 'guias')) {
            // si no está cargada, igual intentamos traerlas sin romper
            try {
                $photoRelPaths = $photoRelPaths->merge(
                    $this->entrega->guias()->pluck('archivo')->filter()
                );
            } catch (\Throwable $e) {
                // no hacemos nada: sigue con las fotos existentes
            }
        }

        // Rutas absolutas para embebido inline
        $inlinePhotos = $photoRelPaths
            ->unique()
            ->map(fn ($p) => storage_path('app/public/' . ltrim($p, '/')))
            ->filter(fn ($abs) => is_file($abs) && is_readable($abs))
            ->values()
            ->all();

        $mail = $this->subject("Entrega registrada - OT #{$folio}")
            ->view('emails.entrega_registrada')
            ->with([
                'entrega'       => $this->entrega,
                'ot'            => $this->ot,
                'inlinePhotos'  => $inlinePhotos,
            ]);

        // Adjuntos (opcional): adjuntar todas las imágenes encontradas
        foreach ($inlinePhotos as $i => $abs) {
            $ext = pathinfo($abs, PATHINFO_EXTENSION) ?: 'jpg';
            $mail->attach($abs, [
                'as' => 'entrega_' . ($i + 1) . '.' . $ext,
            ]);
        }

        return $mail;
    }
}