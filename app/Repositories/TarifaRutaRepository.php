<?php

namespace App\Repositories;

use App\Models\TarifaRuta;
use App\Repositories\BaseRepository;

class TarifaRutaRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'origen',
        'destino'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return TarifaRuta::class;
    }
}
