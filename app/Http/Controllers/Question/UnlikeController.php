<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\RedirectResponse;

class UnlikeController extends Controller
{
    public function __invoke(Question $question): RedirectResponse
    {
        $question->votes()->updateOrCreate([
            'user_id' => auth()->id(),
        ], [
            'like'   => 0,
            'unlike' => 1,
        ]);

        return back();
    }
}
