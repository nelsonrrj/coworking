<?php

namespace App\Repositories;

use App\Models\Office;

final class OfficeRepository
{
    public function __construct(private Office $model) {}

    public function create(array $officeData): array
    {
        $office = $this->model->newInstance($officeData);
        $office->save();

        return $office->toArray();
    }
}
