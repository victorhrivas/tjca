<?php

namespace App\Repositories;

use App\Models\Ot;
use App\Repositories\BaseRepository;

class OtRepository extends BaseRepository
{
    protected $fieldSearchable = [
        
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Ot::class;
    }
}
