<?php

namespace Tests\Feature;

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, assertDatabaseCount, assertDatabaseHas, freezeSecond, post, postJson};

it('should create a new question bigger than 255 chars', function () {
    freezeSecond();

    $user = User::factory()->create();
    actingAs($user);
    $expectedQuestion = str_repeat('x', 260) . '?';

    $request = post(route('questions.store'), [
        'question' => $expectedQuestion,
    ]);

    $request->assertRedirect();
    assertDatabaseCount(Question::class, 1);
    assertDatabaseHas(Question::class, [
        'question'      => $expectedQuestion,
        'created_by_id' => $user->id,
        'created_at'    => now(),
    ]);
});

it('question have a ? at final', function () {
    $user = User::factory()->create();
    actingAs($user);
    $expectedQuestion = str_repeat('x', 9) . '!';

    post(route('questions.store'), [
        'question' => $expectedQuestion,
    ])
        ->assertSessionHasErrors(['question' => 'The question field must end with one of the following: ?.']);
});

it('should have at least 10 chars', function () {
    $user = User::factory()->create();
    actingAs($user);
    $expectedQuestion = str_repeat('x', 8) . '?';

    post(route('questions.store'), [
        'question' => $expectedQuestion,
    ])
        ->assertSessionHasErrors(['question' => 'The question field must be at least 10 characters.']);
});

it('should have at max 1200 chars', function () {
    $user = User::factory()->create();
    actingAs($user);
    $expectedQuestion = str_repeat('x', 1200) . '?';

    post(route('questions.store'), [
        'question' => $expectedQuestion,
    ])
        ->assertSessionHasErrors(['question' => 'The question field must not be greater than 1200 characters.']);
});

it('should create as draft all the time', function () {
    freezeSecond();

    $user = User::factory()->create();
    actingAs($user);
    $expectedQuestion = str_repeat('x', 260) . '?';

    post(route('questions.store'), [
        'question' => $expectedQuestion,
    ]);

    assertDatabaseHas(Question::class, [
        'question'      => $expectedQuestion,
        'draft'         => true,
        'created_by_id' => $user->id,
        'created_at'    => now(),
    ]);
});

it('only authenticated user can create a question', function () {
    $expectedQuestion = str_repeat('x', 260) . '?';

    post(route('questions.store'), [
        'question' => $expectedQuestion,
    ])->assertRedirect(route('login'));
});

it('question should be unique', function () {
    $user = User::factory()->create();
    Question::factory()->for($user, 'createdBy')->create(['question' => 'Some question?']);

    actingAs($user);

    postJson(route('questions.store'), [
        'question' => 'Some question?',
    ])->assertJsonFragment(['errors' => ['question' => ['Pergunta já existe!']]]);
});
