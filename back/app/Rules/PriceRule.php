<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class PriceRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^\d{1,6}(\.\d{1,2})?$/', $value)) {
            $fail('Поле ":attribute" должно иметь вид от 1 до 6 цифр до запятой и две цифры после.');
        }
    }
}
