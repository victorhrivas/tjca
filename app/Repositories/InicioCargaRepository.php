<?php

namespace App\Repositories;

use App\Models\InicioCarga;
use App\Repositories\BaseRepository;

class InicioCargaRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'ot_id',
        'cliente',
        'contacto',
        'origen',
        'destino',
        'tipo_carga',
        'fecha_carga'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return InicioCarga::class;
    }
}
