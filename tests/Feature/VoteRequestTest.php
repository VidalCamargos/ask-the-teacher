<?php

use App\Models\{Question, User, Vote};

use function Pest\Laravel\{actingAs, assertDatabaseHas, post};

it('should be able to like a question', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->for($user, 'createdBy')->create();

    actingAs($user);

    post(route('questions.like', $question));

    assertDatabaseHas(Vote::class, [
        'question_id' => $question->id,
        'like'        => 1,
        'unlike'      => 0,
        'user_id'     => $user->id,
    ]);
});

it('should not be able to like a question more than 1 time', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->for($user, 'createdBy')->create();

    actingAs($user);

    post(route('questions.like', $question));
    post(route('questions.like', $question));

    expect($user->votes)->toHaveCount(1);
});
