<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Http\Requests\Question\StoreRequest;
use Illuminate\Http\RedirectResponse;

class QuestionController extends Controller
{
    public function store(StoreRequest $request): RedirectResponse
    {
        user()->questions()->create($request->validated());

        return to_route('dashboard');
    }
}
