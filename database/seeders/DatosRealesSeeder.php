<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Cliente;
use App\Models\Conductor;
use App\Models\TarifaRuta;

class DatosRealesSeeder extends Seeder
{
    public function run()
    {
        // ===========================
        // USUARIO PRINCIPAL
        // ===========================
        User::updateOrCreate(
            ['email' => 'vhrivas.c@gmail.com'],
            [
                'name'     => 'Víctor Rivas',
                'password' => Hash::make('admin'), // cámbialo luego en producción
            ]
        );

        // ===========================
        // CONDUCTORES (REALS)
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
            Conductor::updateOrCreate(
                ['rut' => $data['rut']],
                $data
            );
        }

        // ===========================
        // CLIENTES (REALS)
        // ===========================
        $clientesData = [
            ['razon_social' => 'AC PERFORACIONES',                'rut' => '76.610.230-1'],
            ['razon_social' => 'ALIMEX S.A',                      'rut' => '96.928.200-8'],
            ['razon_social' => 'ALO RENTAL',                      'rut' => null],
            ['razon_social' => 'BIOMETL',                         'rut' => null],
            ['razon_social' => 'BOARTLONGYEAR',                   'rut' => '76.753.520-1'],
            ['razon_social' => 'CARMONA Y CIA',                   'rut' => null],
            ['razon_social' => 'CDN',                             'rut' => '77.070.746-3'],
            ['razon_social' => 'CERRO NEVADO',                    'rut' => '76.121.580-9'],
            ['razon_social' => 'CJR RENEWABLES',                  'rut' => '76.270.424-2'],
            ['razon_social' => 'DERCOMAQ',                        'rut' => '96.545.450-0'],
            ['razon_social' => 'ELECCON MAQUINARIAS',             'rut' => '99.576.460-1'],
            ['razon_social' => 'FINNING',                         'rut' => '91.489.000-4'],
            ['razon_social' => 'FLESAN MINERIA S.A',              'rut' => '76.727.168-9'],
            ['razon_social' => 'FLESAN S.A',                      'rut' => '76.259.040-9'],
            ['razon_social' => 'FLESAN TRANSPORTE Y MAQUINARIA',  'rut' => '76.259.020-4'],
            ['razon_social' => 'GTC SPA',                         'rut' => '76.788.007-3'],
            ['razon_social' => 'HELLEMA HOLLAND',                 'rut' => null],
            ['razon_social' => 'HIDRONOR',                        'rut' => '96.607.990-8'],
            ['razon_social' => 'IMOPAC',                          'rut' => '79.807.570-5'],
            ['razon_social' => 'INDUMETAL',                       'rut' => '76.865.290-2'],
            ['razon_social' => 'ISNORT',                          'rut' => '77.887.290-0'],
            ['razon_social' => 'JANSSEN',                         'rut' => '81.198.100-1'],
            ['razon_social' => 'MO RENTAL',                       'rut' => '77.184.980-6'],
            ['razon_social' => 'MATAGUI',                         'rut' => null],
            ['razon_social' => 'MATECO',                          'rut' => null],
            ['razon_social' => 'RCC GROUP',                       'rut' => '76.388.115-6'],
            ['razon_social' => 'RESITER',                         'rut' => '89.696.403-0'],
            ['razon_social' => 'SALFA',                           'rut' => '91.502.000-3'],
            ['razon_social' => 'SANTA AGUSTINA',                  'rut' => '76.951.862-2'],
            ['razon_social' => 'SIMMACOMPACT',                    'rut' => null],
            ['razon_social' => 'SIMMARENT',                       'rut' => '76.028.217-0'],
            ['razon_social' => 'SK RENTAL',                       'rut' => '96.777.170-8'],
            ['razon_social' => 'STR POWER',                       'rut' => null],
            ['razon_social' => 'SUBCARGO',                        'rut' => null],
            ['razon_social' => 'TPC',                             'rut' => null],
            ['razon_social' => 'TREX',                            'rut' => '76.414.829-0'],
            ['razon_social' => 'MITTA',                           'rut' => '83.547.100-4'],
            ['razon_social' => 'CYC',                             'rut' => '78.108.630-4'],
            ['razon_social' => 'INCIBO',                          'rut' => '76.647.461-6'],
        ];

        $rutGenericoCorrelativo = 1;

        foreach ($clientesData as $data) {
            $rut = $data['rut'];

            if (empty($rut)) {
                // Ejemplo de RUT genérico único: 99.000.001-K, 99.000.002-K, etc.
                $rut = sprintf('99.000.%03d-K', $rutGenericoCorrelativo);
                $rutGenericoCorrelativo++;
            }

            Cliente::updateOrCreate(
                ['rut' => $rut],
                [
                    'razon_social' => $data['razon_social'],
                    'correo'       => strtolower(str_replace(' ', '', $data['razon_social'])) . '@example.com',
                    'telefono'     => '+56 9 ' . rand(10000000, 99999999),
                    'direccion'    => 'Dirección genérica en Santiago',
                ]
            );
        }

        // ===========================
        // TARIFAS RUTA (OPCIONAL, PERO SON REALES)
        // ===========================
        $tarifas = [
            [
                'destino'                 => 'Arica',
                'cama_baja_25_ton'        => 4000000,
                'rampla_autodescargable'  => 3500000,
                'rampla_plana'            => 3500000,
                'autodescargable_10_ton'  => 3100000,
            ],
            [
                'destino'                 => 'Iquique',
                'cama_baja_25_ton'        => 3600000,
                'rampla_autodescargable'  => 2950000,
                'rampla_plana'            => 2950000,
                'autodescargable_10_ton'  => 2650000,
            ],
            [
                'destino'                 => 'Calama',
                'cama_baja_25_ton'        => 2800000,
                'rampla_autodescargable'  => 2500000,
                'rampla_plana'            => 2500000,
                'autodescargable_10_ton'  => 2250000,
            ],
            [
                'destino'                 => 'Mejillones',
                'cama_baja_25_ton'        => 2900000,
                'rampla_autodescargable'  => 2500000,
                'rampla_plana'            => 2500000,
                'autodescargable_10_ton'  => 2200000,
            ],
            [
                'destino'                 => 'Antofagasta',
                'cama_baja_25_ton'        => 2500000,
                'rampla_autodescargable'  => 2300000,
                'rampla_plana'            => 2300000,
                'autodescargable_10_ton'  => 2000000,
            ],
            [
                'destino'                 => 'Tal Tal',
                'cama_baja_25_ton'        => 2350000,
                'rampla_autodescargable'  => 2100000,
                'rampla_plana'            => 2100000,
                'autodescargable_10_ton'  => 1800000,
            ],
            [
                'destino'                 => 'Copiapó',
                'cama_baja_25_ton'        => 2100000,
                'rampla_autodescargable'  => 1700000,
                'rampla_plana'            => 1700000,
                'autodescargable_10_ton'  => 1500000,
            ],
            [
                'destino'                 => 'Coquimbo/LS',
                'cama_baja_25_ton'        => 1250000,
                'rampla_autodescargable'  => 1100000,
                'rampla_plana'            => 1000000,
                'autodescargable_10_ton'  => 900000,
            ],
            [
                'destino'                 => 'Ovalle',
                'cama_baja_25_ton'        => 1100000,
                'rampla_autodescargable'  => 980000,
                'rampla_plana'            => 980000,
                'autodescargable_10_ton'  => 750000,
            ],
            [
                'destino'                 => 'Los Vilos',
                'cama_baja_25_ton'        => 750000,
                'rampla_autodescargable'  => 550000,
                'rampla_plana'            => 550000,
                'autodescargable_10_ton'  => 450000,
            ],
            [
                'destino'                 => 'Salamanca',
                'cama_baja_25_ton'        => 1100000,
                'rampla_autodescargable'  => 750000,
                'rampla_plana'            => 750000,
                'autodescargable_10_ton'  => 600000,
            ],
            [
                'destino'                 => 'Santiago',
                'cama_baja_25_ton'        => 350000,
                'rampla_autodescargable'  => 250000,
                'rampla_plana'            => 250000,
                'autodescargable_10_ton'  => 200000,
            ],
            [
                'destino'                 => 'Valparaíso',
                'cama_baja_25_ton'        => 500000,
                'rampla_autodescargable'  => 350000,
                'rampla_plana'            => 350000,
                'autodescargable_10_ton'  => 250000,
            ],
            [
                'destino'                 => 'Rancagua',
                'cama_baja_25_ton'        => 500000,
                'rampla_autodescargable'  => 350000,
                'rampla_plana'            => 350000,
                'autodescargable_10_ton'  => 250000,
            ],
            [
                'destino'                 => 'Curico',
                'cama_baja_25_ton'        => 700000,
                'rampla_autodescargable'  => 550000,
                'rampla_plana'            => 550000,
                'autodescargable_10_ton'  => 450000,
            ],
            [
                'destino'                 => 'Talca',
                'cama_baja_25_ton'        => 750000,
                'rampla_autodescargable'  => 550000,
                'rampla_plana'            => 550000,
                'autodescargable_10_ton'  => 450000,
            ],
            [
                'destino'                 => 'Chillan',
                'cama_baja_25_ton'        => 1400000,
                'rampla_autodescargable'  => 1200000,
                'rampla_plana'            => 1200000,
                'autodescargable_10_ton'  => 1000000,
            ],
            [
                'destino'                 => 'Concepción',
                'cama_baja_25_ton'        => 1500000,
                'rampla_autodescargable'  => 1200000,
                'rampla_plana'            => 1200000,
                'autodescargable_10_ton'  => 980000,
            ],
            [
                'destino'                 => 'Temuco',
                'cama_baja_25_ton'        => 2200000,
                'rampla_autodescargable'  => 2000000,
                'rampla_plana'            => 2000000,
                'autodescargable_10_ton'  => 1650000,
            ],
            [
                'destino'                 => 'Puerto Montt',
                'cama_baja_25_ton'        => 2900000,
                'rampla_autodescargable'  => 0,
                'rampla_plana'            => 0,
                'autodescargable_10_ton'  => 1700000,
            ],
        ];

        foreach ($tarifas as $t) {
            TarifaRuta::updateOrCreate(
                [
                    'origen'  => 'Santiago',
                    'destino' => $t['destino'],
                ],
                [
                    'km'                     => null,
                    'cama_baja_25_ton'       => $t['cama_baja_25_ton'],
                    'rampla_autodescargable' => $t['rampla_autodescargable'],
                    'rampla_plana'           => $t['rampla_plana'],
                    'autodescargable_10_ton' => $t['autodescargable_10_ton'],
                ]
            );
        }
    }
}
