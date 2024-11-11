<?php

namespace App\Services;

use App\Repositories\OfficeRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

final class OfficeServices extends ApiService
{
    public function __construct(private OfficeRepository $officeRepo) {}

    public function createOffice(array $officeData): JsonResponse
    {
        $result = $this->officeRepo->create($officeData);

        return $this->jsonResponse($result, Response::HTTP_CREATED);
    }

    public function getOfficesList(int $page, int $perPage): JsonResponse
    {
        $page = $this->officeRepo->paginate($page, $perPage);

        return $this->jsonResponse($page);
    }
}
