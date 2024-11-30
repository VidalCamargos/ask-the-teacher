<?php

namespace App\Rules;

use App\Models\Question;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class SameQuestion implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_string($value)) {
            return;
        }

        if ($this->validationRule($value)) {
            $fail('Pergunta já existe!');
        }
    }

    private function validationRule(string $value): bool
    {
        return Question::whereQuestion($value)->exists();
    }
}
