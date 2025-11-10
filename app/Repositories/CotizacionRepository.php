<?php

namespace App\Repositories;

use App\Models\Cotizacion;
use App\Repositories\BaseRepository;

class CotizacionRepository extends BaseRepository
{
    protected $fieldSearchable = [
        
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Cotizacion::class;
    }
}
