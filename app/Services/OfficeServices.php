<?php

namespace App\Services;

use App\Models\Office;

final class OfficeServices
{
    public function __construct(private Office $model) {}

    public function createOffice(array $officeData): array
    {
        $office = $this->model->newInstance($officeData);
        $office->save();

        return $office->toArray();
    }
}
