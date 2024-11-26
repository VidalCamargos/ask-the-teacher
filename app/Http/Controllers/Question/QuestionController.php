<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Http\Requests\Question\StoreRequest;
use App\Http\Requests\Question\UpdateRequest;
use App\Models\Question;
use Illuminate\Http\RedirectResponse;

class QuestionController extends Controller
{
    public function store(StoreRequest $request): RedirectResponse
    {
        user()->questions()->create([
            ...$request->validated(),
            'draft' => true,
        ]);

        return to_route('dashboard');
    }

    public function update(UpdateRequest $request, Question $question): RedirectResponse
    {
        $question->update($request->validated());

        return back();
    }
}
