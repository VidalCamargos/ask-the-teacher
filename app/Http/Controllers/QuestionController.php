<?php

namespace App\Http\Controllers;

use App\Http\Requests\Question\StoreRequest;
use Illuminate\Http\RedirectResponse;

class QuestionController extends Controller
{
    public function store(StoreRequest $request): RedirectResponse
    {
        auth()->user()->questions()->create($request->validated());

        return to_route('dashboard');
    }
}
