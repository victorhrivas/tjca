<?php

namespace App\Imports;

use App\Models\Producto;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class ProductosImport implements 
    ToModel, 
    WithHeadingRow, 
    SkipsEmptyRows, 
    WithValidation, 
    SkipsOnFailure
{
    use Importable, SkipsFailures;

    /**
     * Cada fila (salvo encabezado/filas vacías) llega como array asociativo.
     */
    public function model(array $row)
    {
        // Si no hay año, saltamos esta fila
        if (empty($row['anio'])) {
            return null;
        }

        return new Producto([
            'categoria_id'  => $row['categoria_id'],
            'marca'         => $row['marca'],
            'modelo'        => $row['modelo'],
            'anio'          => $row['anio'],
            'tipo_vidrio'   => $row['tipo_vidrio'],
            'detalles'      => $row['detalles'] ?? null,
            'precio_base'   => $row['precio_base']   ?? 0,
            'stock_actual'  => $row['stock_actual']  ?? 0,
            'user_id'       => $row['user_ud']       ?? auth()->id(),
        ]);
    }

    /**
     * Reglas de validación fila a fila.
     */
    public function rules(): array
    {
        return [
            '*.categoria_id' => 'required|integer|exists:categorias,id',
            '*.marca'        => 'required|string',
            '*.modelo'       => 'required|string',
            '*.anio'         => 'required',
            '*.tipo_vidrio'  => 'required|string',
        ];
    }

    /**
     * Nombres amigables para errores de validación.
     */
    public function customValidationAttributes(): array
    {
        return [
            'anio' => 'año',
        ];
    }
}
