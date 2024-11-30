<?php

namespace App\Http\Requests\Question;

use App\Rules\SameQuestion;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'question' => ['string', 'sometimes', 'ends_with:?', 'min:10', 'max:1200', new SameQuestion()],
            'draft'    => ['boolean', 'sometimes'],
        ];
    }
}
