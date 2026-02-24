<?php

namespace App\Repositories;

use App\Models\EventoOperacion;
use App\Repositories\BaseRepository;

class EventoOperacionRepository extends BaseRepository
{
    protected $fieldSearchable = [
        
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return EventoOperacion::class;
    }
}
