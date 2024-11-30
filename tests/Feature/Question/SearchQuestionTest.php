<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, get};

it('should be able search a question by text', function () {
    $user           = User::factory()->create();
    $wrongQuestions = Question::factory(5)->for($user, 'createdBy')->create(['question' => 'Something Else??']);
    $question       = Question::factory()->for($user, 'createdBy')->create(['question' => 'My question??']);

    actingAs($user);

    $response = get(route('dashboard', ['search' => 'question']));

    $response->assertDontSee('Something Else??');
    $response->assertSee($question->question);
});
