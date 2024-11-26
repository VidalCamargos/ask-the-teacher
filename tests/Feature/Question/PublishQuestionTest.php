<?php

use App\Models\Question;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\put;

it('should be able to publish a question', function() {
    $user = User::factory()->create();
    $question = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);

    actingAs($user);

    put(route('questions.update', $question), ['draft' => false])->assertRedirect();

    expect($question->refresh()->draft)->toBeFalse();
});
