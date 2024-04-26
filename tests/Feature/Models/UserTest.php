<?php

use App\Models\User;

it('has a name', function (User $user) {
    expect($user->name)->toBeString();
})->with([fn() => User::factory()->create()->refresh()]);

it('has an email', function (User $user) {
    expect($user->email)->toBeString();
})->with([fn() => User::factory()->create()->refresh()]);
