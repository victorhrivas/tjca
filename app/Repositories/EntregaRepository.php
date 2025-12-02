<?php

namespace App\Repositories;

use App\Models\Entrega;
use App\Repositories\BaseRepository;

class EntregaRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'ot_id',
        'nombre_receptor',
        'rut_receptor',
        'lugar_entrega',
        'fecha_entrega'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Entrega::class;
    }
}
