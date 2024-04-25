<?php

use App\Models\Record;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Collection;

it('has a name', function (Record $record) {
    expect($record->name)->toBeString();
})->with([fn() => Record::factory()->create()]);

it('has a price', function (Record $record) {
    expect($record->price)->toBeFloat();
})->with([fn() => Record::factory()->create()]);

it('has a description', function (Record $record) {
    expect($record->description)->toBeString();
})->with([fn() => Record::factory()->create()]);

it('has a user', function (Record $record) {
    expect($record->user_id)->toBeInt()
        ->and($record->user)->toBeInstanceOf(User::class);
})->with([fn() => Record::factory()->create()]);

it('has some tags attached ', function (Record $record) {
    expect($record->tags)->toBeInstanceOf(Collection::class)
        ->each
        ->toBeInstanceOf(Tag::class);
})->with([fn() => Record::factory()->create()]);
