<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\RedirectResponse;

class LikeController extends Controller
{
    public function __invoke(Question $question): RedirectResponse
    {
        $question->votes()->updateOrCreate([
            'user_id' => auth()->id(),
            'like'    => 1,
            'unlike' => 0,
        ]);

        return back();
    }
}
