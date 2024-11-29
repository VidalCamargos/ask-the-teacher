<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, put};

it('should be able to publish a question', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);

    actingAs($user);

    put(route('questions.update', $question), ['draft' => false])->assertRedirect();

    expect($question->refresh()->draft)->toBeFalse();
});

it('should make sure that only the person who has created the question publish the question', function () {
    $rightUser = User::factory()->create();
    $wrongUser = User::factory()->create();
    $question  = Question::factory()->for($rightUser, 'createdBy')->create(['draft' => true]);

    actingAs($wrongUser);

    put(route('questions.update', $question), ['draft' => false])->assertForbidden();

    actingAs($rightUser);

    put(route('questions.update', $question), ['draft' => false])->assertRedirect();
});
