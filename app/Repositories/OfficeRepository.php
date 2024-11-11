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

    public function paginate(int $page = 1, int $perPage = 10): array
    {
        $result = $this->model->newQuery()
            ->offset(($page - 1) * $perPage)
            ->limit($perPage)
            ->get();

        $total = $this->model->newQuery()->count();

        return ['data' => $result, 'total' => $total];
    }
}
