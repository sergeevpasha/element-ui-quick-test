<?php

declare(strict_types=1);

namespace App\Http\Resources\Collections;

use App\Http\Resources\PropertyResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PropertyResourceCollection extends ResourceCollection
{
    /**
     * The resource that this resource collects.
     *
     * @var string
     */
    public $collects = PropertyResource::class;
}
