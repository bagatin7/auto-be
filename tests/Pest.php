<?php

use App\Models\User;
use Laravel\Passport\Passport;

uses(Tests\TestCase::class)->in('Feature');

function actingAsUser(User $user): void
{
    Passport::actingAs($user);
}

function actingAsRandomUser(): void
{
    actingAsUser(User::factory()->create());
}
