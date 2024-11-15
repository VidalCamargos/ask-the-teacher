<?php

namespace Tests\Feature;

use App\Models\Question;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\freezeSecond;
use function Pest\Laravel\post;

it('should create a new question bigger than 255 chars', function() {
    freezeSecond();

    $user = User::factory()->create();
    actingAs($user);
    $expectedQuestion = str_repeat('x', 260).'?';

    $request = post(route('questions.store'), [
        'question' => $expectedQuestion,
    ]);

    $request->assertRedirect(route('dashboard'));
    assertDatabaseCount(Question::class, 1);
    assertDatabaseHas(Question::class, [
        'question' => $expectedQuestion,
        'created_by_id' => $user->id,
        'created_at' => now(),
    ]);
});

it('question have a ? at final', function () {

});

it('should have at least 10 chars', function() {

});
