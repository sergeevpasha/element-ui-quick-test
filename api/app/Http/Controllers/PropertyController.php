<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\PropertyRequest;
use App\Http\Resources\Collections\PropertyResourceCollection;
use App\Services\PropertyService;
use Illuminate\Http\JsonResponse;

class PropertyController extends Controller
{
    public function __construct(private readonly PropertyService $service)
    {}

    /**
     * Find properties
     *
     * @param PropertyRequest $request
     * @return JsonResponse
     */
    public function __invoke(PropertyRequest $request): JsonResponse
    {
        $data = $request->validated();
        $properties = $this->service->queryProperties($data);

        return (new PropertyResourceCollection($properties))->response();
    }
}
