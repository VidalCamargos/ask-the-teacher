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
    $user = User::factory()->create();
    Question::factory(20)->for($user, 'createdBy')->create();

    actingAs($user);

    get(route('dashboard'))->assertViewHas('questions', fn ($value) => $value instanceof LengthAwarePaginator);
});

it('should order by like and unlike, most liked at the top and most unliked at the bottom', function () {
    $user = User::factory()->create();
    Question::factory(5)->for($user, 'createdBy')->create();

    $mostLikedQuestion = Question::inRandomOrder()->first();
    $mostLikedQuestion->votes()->create(['like' => 1, 'user_id' => $user->id]);

    $mostUnlikedQuestion = Question::inRandomOrder()->whereNot('id', $mostLikedQuestion->id)->first();
    $mostUnlikedQuestion->votes()->create(['unlike' => 1, 'user_id' => $user->id]);

    actingAs($user);

    get(route('dashboard'))->assertViewHas('questions', function ($questions) use ($mostLikedQuestion, $mostUnlikedQuestion) {
        expect($questions)
            ->first()->id->toBe($mostLikedQuestion->id)
            ->and($questions)
            ->last()->id->toBe($mostUnlikedQuestion->id);

        return true;
    });
});
