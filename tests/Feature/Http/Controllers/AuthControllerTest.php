<?php

use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Passport\Client;
use function Pest\Laravel\postJson;

/**
 * @param $clientSecret
 * @return void
 */
function createPassportClient($clientSecret): Client
{
    /** @var \Laravel\Passport\ClientRepository $client_repository */
    $client_repository = app('Laravel\Passport\ClientRepository');
    $client = $client_repository->createPasswordGrantClient(null, "Client", "http://localhost");
    $client->setSecretAttribute($clientSecret);
    $client->save();
    return $client;
}

it('should issue a token', function () {
    $password = fake()->password;
    $secret = fake()->password;
    $client = createPassportClient($secret);
    $user = User::factory()->create(['password' => $password]);
    postJson("api/oauth/token", [
        'grant_type' => 'password',
        'client_id' => $client->id,
        'client_secret' => $secret,
        'username' => $user->email,
        'password' => $password
    ])->assertSuccessful()
        ->assertJson(fn(AssertableJson $json) => $json
            ->whereType('token_type', 'string')
            ->whereType('expires_in', 'integer')
            ->whereType('access_token', 'string')
            ->whereType('refresh_token', 'string')
            ->hasAll(['token_type', 'expires_in', 'access_token', 'refresh_token'])
            ->etc());
});
