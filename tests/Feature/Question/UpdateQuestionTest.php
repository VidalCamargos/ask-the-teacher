<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, assertDatabaseHas, put};

it('should be able to update the question', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->for($user, 'createdBy')->create();

    actingAs($user);

    put(route('questions.update', $question), ['question' => 'uepaaaaaaa?'])->assertRedirect();

    $question->refresh();

    expect($question->question)->toBe('uepaaaaaaa?');
});

it('should update a new question bigger than 255 chars', function () {
    $expectedQuestion = str_repeat('x', 260) . '?';
    $user             = User::factory()->create();
    $question         = Question::factory()->for($user, 'createdBy')->create();

    actingAs($user);

    put(route('questions.update', $question), [
        'question' => $expectedQuestion,
    ])->assertRedirect();

    assertDatabaseHas(Question::class, [
        'question'      => $expectedQuestion,
        'created_by_id' => $user->id,
    ]);
});

it('question have a ? at final', function () {
    $expectedQuestion = str_repeat('x', 9) . '!';
    $user             = User::factory()->create();
    $question         = Question::factory()->for($user, 'createdBy')->create();

    actingAs($user);

    put(route('questions.update', $question), [
        'question' => $expectedQuestion,
    ])
        ->assertSessionHasErrors(['question' => 'The question field must end with one of the following: ?.']);
});

it('should have at least 10 chars', function () {
    $expectedQuestion = str_repeat('x', 8) . '?';
    $user             = User::factory()->create();
    $question         = Question::factory()->for($user, 'createdBy')->create();

    actingAs($user);

    put(route('questions.update', $question), [
        'question' => $expectedQuestion,
    ])
        ->assertSessionHasErrors(['question' => 'The question field must be at least 10 characters.']);
});

it('should have at max 1200 chars', function () {
    $expectedQuestion = str_repeat('x', 1200) . '?';
    $user             = User::factory()->create();
    $question         = Question::factory()->for($user, 'createdBy')->create();

    actingAs($user);

    put(route('questions.update', $question), [
        'question' => $expectedQuestion,
    ])
        ->assertSessionHasErrors(['question' => 'The question field must not be greater than 1200 characters.']);
});

it('should make sure that only the person who has created the question update the question', function () {
    $rightUser = User::factory()->create();
    $wrongUser = User::factory()->create();
    $question  = Question::factory()->for($rightUser, 'createdBy')->create();

    actingAs($wrongUser);
    put(route('questions.update', $question))->assertForbidden();

    actingAs($rightUser);
    put(route('questions.update', $question))->assertRedirect();
});
