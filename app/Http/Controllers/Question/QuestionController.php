<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\Question\{StoreRequest, UpdateRequest};
use App\Models\Question;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class QuestionController extends Controller
{
    use AuthorizesRequests;

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
        $this->authorize('update', $question);

        $question->update($request->validated());

        return back();
    }
}
