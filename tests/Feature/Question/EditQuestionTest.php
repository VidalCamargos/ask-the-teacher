<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, get};

it('should be able to open a question to edit', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);

    actingAs($user);

    get(route('questions.edit', $question))->assertSuccessful();
});

it('should return a view', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);

    actingAs($user);

    get(route('questions.edit', $question))->assertViewIs('question.edit');
});

it('should make sure that only question with draft status can be edited', function () {
    $user             = User::factory()->create();
    $questionNotDraft = Question::factory()->for($user, 'createdBy')->create(['draft' => false]);
    $questionDraft    = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);

    actingAs($user);

    get(route('questions.edit', $questionNotDraft))->assertForbidden();
    get(route('questions.edit', $questionDraft))->assertSuccessful();
});

it('should make sure that only the person who has created the question edit the question', function () {
    $rightUser = User::factory()->create();
    $wrongUser = User::factory()->create();
    $question  = Question::factory()->for($rightUser, 'createdBy')->create(['draft' => true]);

    actingAs($wrongUser);

    get(route('questions.edit', $question))->assertForbidden();

    actingAs($rightUser);

    get(route('questions.edit', $question))->assertSuccessful();
});
