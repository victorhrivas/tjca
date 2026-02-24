<?php

namespace App\Repositories;

use App\Models\Solicitud;
use App\Repositories\BaseRepository;

class SolicitudRepository extends BaseRepository
{
    protected $fieldSearchable = [
        
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Solicitud::class;
    }
}
