<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PropertyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['string'],
            'bedrooms' => ['numeric'],
            'bathrooms' => ['numeric'],
            'storeys' => ['numeric'],
            'garages' => ['numeric'],
            'price_from' => ['numeric'],
            'price_to' => ['numeric'],
        ];
    }
}
