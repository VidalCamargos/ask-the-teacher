<?php

use App\Models\{Question, User, Vote};

use function Pest\Laravel\{actingAs, assertDatabaseCount, assertDatabaseHas, post};

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

it('should be able to unlike a question', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->for($user, 'createdBy')->create();

    actingAs($user);

    post(route('questions.unlike', $question));

    assertDatabaseHas(Vote::class, [
        'question_id' => $question->id,
        'like'        => 0,
        'unlike'      => 1,
        'user_id'     => $user->id,
    ]);
});

it('should not be able to unlike a question more than 1 time', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->for($user, 'createdBy')->create();

    actingAs($user);

    post(route('questions.unlike', $question));
    post(route('questions.unlike', $question));

    expect($user->votes)->toHaveCount(1);
});

it('should not able to like and unlike the same question', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->for($user, 'createdBy')->create();

    actingAs($user);

    post(route('questions.unlike', $question));
    post(route('questions.like', $question));

    assertDatabaseCount(Vote::class, 1);
    assertDatabaseHas(Vote::class, [
        'user_id'     => $user->id,
        'question_id' => $question->id,
        'unlike'      => 0,
        'like'        => 1,
    ]);
});
