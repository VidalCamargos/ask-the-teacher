<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, assertDatabaseMissing, delete};

it('should be able to destroy a question', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);

    actingAs($user);

    delete(route('questions.destroy', $question))->assertRedirect();

    assertDatabaseMissing(Question::class, ['id' => $question]);
});

it('should make sure that only the person who has created the question destroy the question', function () {
    $rightUser = User::factory()->create();
    $wrongUser = User::factory()->create();
    $question  = Question::factory()->for($rightUser, 'createdBy')->create();

    actingAs($wrongUser);

    delete(route('questions.destroy', $question))->assertForbidden();

    actingAs($rightUser);

    delete(route('questions.destroy', $question))->assertRedirect();
});
