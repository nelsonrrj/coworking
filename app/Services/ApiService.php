<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ApiService
{
    public function jsonResponse(array $data = [], int $httpCode = Response::HTTP_OK): JsonResponse
    {
        return new JsonResponse(['data' => $data], $httpCode);
    }
}
