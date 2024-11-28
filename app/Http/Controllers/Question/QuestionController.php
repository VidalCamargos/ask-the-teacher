<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Http\Requests\Question\{StoreRequest, UpdateRequest};
use App\Models\Question;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;

class QuestionController extends Controller
{
    use AuthorizesRequests;

    public function index(): View
    {
        return view('question.index', [
            'questions' => user()->questions,
        ]);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        user()->questions()->create([
            ...$request->validated(),
            'draft' => true,
        ]);

        return back();
    }

    public function update(UpdateRequest $request, Question $question): RedirectResponse
    {
        $this->authorize('update', $question);

        $question->update($request->validated());

        return back();
    }
}
