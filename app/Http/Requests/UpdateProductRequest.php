<?php

namespace App\Http\Requests;

use App\Rules\NutriscoreGradeRule;
use App\Rules\ProductStatusRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return false;
    }

    public function rules(): array
    {
        return [
            'status' => ['nullable', new ProductStatusRule],
            'url' => ['nullable', 'url:http,https'],
            'creator' => ['nullable', 'string'],
            'productName' => ['nullable', 'string'],
            'quantity' => ['nullable', 'string'],
            'brands' => ['nullable', 'string'],
            'categories' => ['nullable', 'string'],
            'labels' => ['nullable', 'string'],
            'cities' => ['nullable', 'string'],
            'purchasePlaces' => ['nullable', 'string'],
            'stores' => ['nullable', 'string'],
            'ingredientsText' => ['nullable', 'string'],
            'traces' => ['nullable', 'string'],
            'servingSize' => ['nullable', 'string'],
            'servingQuantity' => ['nullable', 'numeric'],
            'nutriscoreScore' => ['nullable', 'numeric'],
            'nutriscoreGrade' => ['nullable', new NutriscoreGradeRule],
            'mainCategory' => ['nullable', 'string'],
            'imageUrl' => ['nullable', 'url:http,https'],
        ];
    }
}
