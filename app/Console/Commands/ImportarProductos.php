<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductosImport;

class ImportarProductos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * Define aquí el nombre del comando y su argumento.
     *
     * @var string
     */
    protected $signature = 'productos:importar {archivo : Ruta al archivo Excel (.xlsx o .csv)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importa productos masivamente desde un archivo Excel hacia la base de datos';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Obtener la ruta al archivo desde el argumento
        $path = $this->argument('archivo');

        // Verificar que el archivo exista
        if (!file_exists($path)) {
            $this->error("El archivo no se encontró en la ruta especificada: {$path}");
            return 1;
        }

        try {
            // Ejecutar la importación
            Excel::import(new ProductosImport, $path);
            $this->info("¡Importación completada correctamente desde: {$path}!");
            return 0;
        } catch (\Exception $e) {
            $this->error('Error durante la importación: ' . $e->getMessage());
            return 1;
        }
    }
}
