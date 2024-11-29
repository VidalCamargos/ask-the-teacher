<?php

use App\Models\{Question, User};
use Illuminate\Pagination\LengthAwarePaginator;

use function Pest\Laravel\{actingAs, get};

it('should list all the questions properly', function () {
    $user      = User::factory()->create();
    $questions = Question::factory(5)->for($user, 'createdBy')->create();

    actingAs($user);

    $response = get(route('dashboard'));

    foreach ($questions as $question) {
        $response->assertSee($question->question);
    }
});

it('should paginate the result', function () {
    $user      = User::factory()->create();
    $questions = Question::factory(20)->for($user, 'createdBy')->create();

    actingAs($user);

    get(route('dashboard'))->assertViewHas('questions', fn ($value) => $value instanceof LengthAwarePaginator);

});
