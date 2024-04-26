<?php

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Testing\Fluent\AssertableJson;
use function Pest\Laravel\assertModelMissing;
use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

beforeEach(fn() => actingAsRandomUser());

it('should lists users', function (Collection $collection) {
    getJson('api/users')
        ->assertSuccessful()
        ->assertJson(fn(AssertableJson $json) => $json
            ->hasAll(['objects', 'total', 'page_index', 'page_size'])
            ->has('objects', User::count())
            ->etc());
})->with([fn() => User::factory(10)->create()]);

it('should show a user', function (User $user) {
    getJson("api/users/$user->id")
        ->assertSuccessful()
        ->assertJson(fn(AssertableJson $json) => $json
            ->where('id', $user->id)
            ->where('name', $user->name)
            ->where('email', $user->email)
            ->etc());
})->with([fn() => User::factory()->create()]);

it('should create a user', function (User $user) {
    $password = fake()->password;
    postJson("api/users", [
        ...$user->toArray(),
        'password' => $password,
        'password_confirmation' => $password
    ])
        ->assertCreated()
        ->assertJson(fn(AssertableJson $json) => $json
            ->has('id')
            ->where('name', $user->name)
            ->where('email', $user->email)
            ->etc());
})->with([fn() => User::factory()->make()]);

it('should update a user', function (User $user, User $updated) {
    putJson("api/users/$user->id", $updated->toArray())
        ->assertSuccessful()
        ->assertJson(fn(AssertableJson $json) => $json
            ->where('id', $user->id)
            ->where('name', $updated->name)
            ->where('email', $updated->email)
            ->etc());
})->with([fn() => User::factory()->create()], [fn() => User::factory()->make()]);

it('should delete a user', function (User $user) {
    deleteJson("api/users/$user->id")
        ->assertSuccessful()
        ->assertJson(fn(AssertableJson $json) => $json
            ->where('id', $user->id)
            ->where('name', $user->name)
            ->where('email', $user->email)
            ->etc());
    assertModelMissing($user);
})->with([fn() => User::factory()->create()]);
