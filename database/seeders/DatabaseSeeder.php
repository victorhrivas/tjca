<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Cliente;
use App\Models\Solicitud;
use App\Models\Cotizacion;
use App\Models\Ot;
use App\Models\Conductor;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // ===========================
        // USUARIO PRINCIPAL
        // ===========================
        User::create([
            'name'     => 'Víctor Rivas',
            'email'    => 'vhrivas.c@gmail.com',
            'password' => Hash::make('admin'),
        ]);

        // ===========================
        // CONDUCTORES
        // ===========================
        $conductoresData = [
            ['nombre' => 'Elvis Corona',         'rut' => '11.111.111-1', 'telefono' => '+56 9 1111 1111', 'correo' => 'elvis.corona@tjca.cl',        'licencia' => 'A5', 'activo' => true],
            ['nombre' => 'Bernardo Melendez',    'rut' => '12.222.222-2', 'telefono' => '+56 9 2222 2222', 'correo' => 'bernardo.melendez@tjca.cl',   'licencia' => 'A5', 'activo' => true],
            ['nombre' => 'Luis Guerrero',        'rut' => '13.333.333-3', 'telefono' => '+56 9 3333 3333', 'correo' => 'luis.guerrero@tjca.cl',       'licencia' => 'A4', 'activo' => true],
            ['nombre' => 'Rodrigo Valenzuela',   'rut' => '14.444.444-4', 'telefono' => '+56 9 4444 4444', 'correo' => 'rodrigo.valenzuela@tjca.cl',  'licencia' => 'A4', 'activo' => true],
            ['nombre' => 'Juan Carlos Cuello',   'rut' => '15.555.555-5', 'telefono' => '+56 9 5555 5555', 'correo' => 'juan.cuello@tjca.cl',         'licencia' => 'A5', 'activo' => true],
            ['nombre' => 'Juan Carlos Gonzalez', 'rut' => '16.666.666-6', 'telefono' => '+56 9 6666 6666', 'correo' => 'juan.gonzalez@tjca.cl',      'licencia' => 'A5', 'activo' => true],
            ['nombre' => 'Francisco León',       'rut' => '17.777.777-7', 'telefono' => '+56 9 7777 7777', 'correo' => 'francisco.leon@tjca.cl',      'licencia' => 'A4', 'activo' => true],
        ];

        foreach ($conductoresData as $data) {
            Conductor::create($data);
        }

        $nombresConductores = Conductor::pluck('nombre')->all();

        // ===========================
        // CLIENTES
        // ===========================
        $clientes = [];
        for ($i = 1; $i <= 8; $i++) {
            $clientes[] = Cliente::create([
                'razon_social' => "Cliente $i SPA",
                'rut'          => "11.111.11$i-K",
                'correo'       => "cliente$i@example.com",
                'telefono'     => "+56 9 8765 43$i",
                'direccion'    => "Calle Falsa $i, Santiago",
            ]);
        }

        // Nombres base para solicitante / vendedor
        $nombresSolicitantes = [
            'Víctor Rivas',
            'María Soto',
            'Juan Pérez',
        ];

        // ===========================
        // SOLICITUDES
        // ===========================
        $solicitudes = [];
        foreach ($clientes as $c) {

            // fecha base de la solicitud
            $fechaSolicitud = now()->subDays(rand(5, 20));

            $solicitudes[] = Solicitud::create([
                'cliente_id'   => $c->id,
                'canal'        => ['whatsapp', 'llamada', 'email'][rand(0, 2)],
                'origen'       => 'Bodega Central',
                'destino'      => 'Sucursal ' . rand(1, 5),
                'carga'        => rand(100, 500) . ' kg',
                'notas'        => 'Notas de prueba ' . rand(1, 100),
                'estado'       => ['pendiente', 'aprobada', 'fallida'][rand(0, 2)],
                'solicitante'  => $nombresSolicitantes[array_rand($nombresSolicitantes)], // NUEVO
                'created_at'   => $fechaSolicitud,
                'updated_at'   => $fechaSolicitud,
            ]);
        }

        // ===========================
        // COTIZACIONES
        // ===========================
        $cotizaciones = [];
        foreach ($solicitudes as $index => $s) {

            // solo solicitudes aprobadas tendrán cotización
            if ($s->estado === 'aprobada') {

                // fuerzo que varias queden como aceptadas (por índice)
                $estadoCot = ($index % 3 === 0)
                    ? 'aceptada'
                    : ['enviada', 'aceptada', 'rechazada'][rand(0, 2)];

                $fechaCot = $s->created_at->copy()->addDay();

                // obtenemos el cliente relacionado para “congelar” el nombre
                $cliente = $s->cliente;

                $cotizaciones[] = Cotizacion::create([
                    'solicitud_id' => $s->id,
                    'solicitante'  => $s->solicitante, // NUEVO: se congela el solicitante de la solicitud
                    'estado'       => $estadoCot,
                    'monto'        => rand(50000, 200000),

                    // CAMPOS “CONGELADOS” DESDE SOLICITUD / CLIENTE
                    'origen'       => $s->origen,
                    'destino'      => $s->destino,
                    'cliente'      => $cliente?->razon_social ?? 'Cliente sin nombre',
                    'carga'        => $s->carga,

                    'created_at'   => $fechaCot,
                    'updated_at'   => $fechaCot,
                ]);
            }
        }

        // ===========================
        // OTs (UNA POR CADA COTIZACIÓN ACEPTADA)
        // ===========================
        foreach ($cotizaciones as $c) {

            if ($c->estado === 'aceptada') {

                $solicitud = $c->solicitud;
                $cliente   = $solicitud->cliente;
                $fechaOt   = $solicitud->created_at->copy()->addDays(2);

                Ot::create([
                    'cotizacion_id'    => $c->id,
                    'equipo'           => ['Camión 3/4', 'Camión alto', 'Camión rampla'][rand(0, 2)],
                    'origen'           => $solicitud->origen,
                    'destino'          => $solicitud->destino,
                    'cliente'          => $cliente?->razon_social ?? 'Cliente sin nombre',
                    'valor'            => $c->monto,
                    'fecha'            => $fechaOt->toDateString(),
                    'solicitante'      => $c->solicitante ?? "Encargado de {$cliente?->razon_social}", // usa el solicitante de la coti
                    'conductor'        => $nombresConductores[array_rand($nombresConductores)],
                    'estado'           => ['inicio_carga', 'en_transito', 'entregada'][rand(0, 2)],
                    'observaciones'    => 'OT generada automáticamente desde seeder.',
                    'created_at'       => $fechaOt,
                    'updated_at'       => $fechaOt,
                ]);
            }
        }
    }
}
