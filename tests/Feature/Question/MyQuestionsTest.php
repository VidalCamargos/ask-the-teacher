<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, get};

it('should be able to list all questions created by me', function () {
    $wrongUser      = User::factory()->create();
    $wrongQuestions = Question::factory(5)->for($wrongUser, 'createdBy')->create();
    $user           = User::factory()->create();
    $questions      = Question::factory(5)->for($user, 'createdBy')->create();

    actingAs($user);

    $response = get(route('questions.index'));

    foreach ($questions as $question) {
        $response->assertSee($question->question);
    }

    foreach ($wrongQuestions as $question) {
        $response->assertDontSee($question->question);
    }
});
