<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Property;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PropertyService
{
    /**
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function queryProperties(array $filters): LengthAwarePaginator
    {
        $query = Property::query();

        if (!empty($filters['name'])) {
            $query->whereRaw("(search_vector @@ plainto_tsquery('english', ?) OR name ILIKE ?)", [
                $filters['name'],
                '%' . $filters['name'] . '%',
            ]);
        }

        if (!empty($filters['bedrooms'])) {
            $query->where('bedrooms', $filters['bedrooms']);
        }

        if (!empty($filters['bathrooms'])) {
            $query->where('bathrooms', $filters['bathrooms']);
        }

        if (!empty($filters['storeys'])) {
            $query->where('storeys', $filters['storeys']);
        }

        if (!empty($filters['garages'])) {
            $query->where('garages', $filters['garages']);
        }

        if (!empty($filters['price_from'])) {
            $query->where('price', '>=', (int) $filters['price_from'] * 100);
        }

        if (!empty($filters['price_to'])) {
            $query->where('price', '<=', (int) $filters['price_to'] * 100);
        }

        return $query->paginate(10);
    }
}
