<?php

namespace App\Repositories;

use App\Models\Puente;
use App\Repositories\BaseRepository;

class PuenteRepository extends BaseRepository
{
    protected $fieldSearchable = [
        
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Puente::class;
    }
}
