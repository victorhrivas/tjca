<?php

namespace App\Repositories;

use App\Models\Conductor;
use App\Repositories\BaseRepository;

class ConductorRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'nombre',
        'rut'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Conductor::class;
    }
}
