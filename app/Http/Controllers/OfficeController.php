<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOfficeRequest;
use App\Services\OfficeServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
    public function __construct(private OfficeServices $service) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        return $this->service->getOfficesList(
            $request->get('page', 0),
            $request->get('perPage', 20)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateOfficeRequest $request): JsonResponse
    {
        return $this->service->createOffice($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateOfficeRequest $request, string $officeId): JsonResponse
    {
        return $this->service->updateOffice($officeId, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
