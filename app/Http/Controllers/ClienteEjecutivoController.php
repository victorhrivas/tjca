<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteEjecutivoController extends Controller
{
    public function byCliente(Cliente $cliente)
    {
        return $cliente->ejecutivosActivos()
            ->select('id', 'nombre', 'correo')
            ->orderByDesc('es_principal')
            ->orderBy('nombre')
            ->get()
            ->map(fn($e) => [
                'id' => $e->id,
                'text' => trim($e->nombre . ($e->correo ? " · {$e->correo}" : '')),
            ]);
    }
}
