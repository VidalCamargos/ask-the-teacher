<?php

namespace App\Http\Requests\Question;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'question' => ['string', 'sometimes', 'ends_with:?', 'min:10', 'max:1200'],
            'draft'    => ['boolean', 'sometimes'],
        ];
    }
}
