<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NutriscoreGradeRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $allowedOptions = ['a', 'b', 'c', 'd', 'e'];

        if (!in_array($value, $allowedOptions)) {
            $fail("The {$attribute} must be a letter between 'a' and 'e'.");
        }
    }
}
