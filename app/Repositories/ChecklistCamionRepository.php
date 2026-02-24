<?php

namespace App\Repositories;

use App\Models\ChecklistCamion;
use App\Repositories\BaseRepository;

class ChecklistCamionRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'nombre_conductor',
        'patente'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return ChecklistCamion::class;
    }
}
