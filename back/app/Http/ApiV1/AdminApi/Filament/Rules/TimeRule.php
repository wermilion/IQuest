<?php

namespace App\Http\ApiV1\AdminApi\Filament\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class TimeRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/', $value)) {
            $fail('Поле ":attribute" должно быть в формате 00:00.');
        }
    }
}
