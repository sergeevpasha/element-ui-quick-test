<?php

declare(strict_types=1);

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class Price implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return float
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): float
    {
        return is_numeric($value) ? round($value / 100, 2) : 0.0;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return int
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): int
    {
        return is_numeric($value) ? (int) round($value * 100) : 0;
    }
}
