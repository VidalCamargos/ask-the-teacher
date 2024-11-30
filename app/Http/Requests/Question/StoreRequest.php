<?php

namespace App\Http\Requests\Question;

use App\Rules\SameQuestion;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'question' => ['string', 'ends_with:?', 'min:10', 'max:1200', new SameQuestion()],
        ];
    }
}
