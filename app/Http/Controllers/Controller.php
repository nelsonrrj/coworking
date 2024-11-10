<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

abstract class Controller
{
    public function jsonResponse(array $data, int $httpCode = Response::HTTP_OK): JsonResponse
    {
        return new JsonResponse($data, $httpCode);
    }
}
