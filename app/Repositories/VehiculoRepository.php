<?php

namespace App\Repositories;

use App\Models\Vehiculo;
use App\Repositories\BaseRepository;

class VehiculoRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'marca',
        'modelo',
        'patente'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Vehiculo::class;
    }
}
