<?php

use App\Models\Record;
use Illuminate\Support\Collection;
use Illuminate\Testing\Fluent\AssertableJson;
use function Pest\Laravel\assertModelMissing;
use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

beforeEach(fn() => actingAsRandomUser());

it('lists the records', function (Collection $collection) {
    getJson("api/records")
        ->assertSuccessful()
        ->assertJson(fn(AssertableJson $json) => $json
            ->hasAll(['objects', 'total', 'page_index', 'page_size'])
            ->has('objects', $collection->count())
        );
})->with([fn() => Record::factory(20)->create()]);

it('shows a record', function (Record $record) {
    getJson("api/records/$record->id")
        ->assertSuccessful()
        ->assertJson(fn(AssertableJson $json) => $json
            ->where('id', $record->id)
            ->where('name', $record->name)
            ->where('user_id', $record->user_id)
            ->where('description', $record->description)
            ->etc());
})->with([fn() => Record::factory()->create()]);

it('creates a record', function (Record $record) {
    postJson("api/records", $record->toArray())
        ->assertCreated()
        ->assertJson(fn(AssertableJson $json) => $json
            ->has('id')
            ->where('name', $record->name)
            ->where('user_id', $record->user_id)
            ->where('description', $record->description)
            ->etc());
})->with([fn() => Record::factory()->make()]);

it('updates a record', function (Record $record, Record $updated) {
    putJson("api/records/$record->id", $updated->toArray())
        ->assertSuccessful()
        ->assertJson(fn(AssertableJson $json) => $json
            ->where('id', $record->id)
            ->where('name', $updated->name)
            ->where('user_id', $updated->user_id)
            ->where('description', $updated->description)
            ->etc());
})->with([fn() => Record::factory()->create()], [fn() => Record::factory()->make()]);

it('deletes a record', function (Record $record) {
    deleteJson("api/records/$record->id")
        ->assertSuccessful()
        ->assertJson(fn(AssertableJson $json) => $json
            ->where('id', $record->id)
            ->where('name', $record->name)
            ->where('user_id', $record->user_id)
            ->where('description', $record->description)
            ->etc());
    assertModelMissing($record);
})->with([fn() => Record::factory()->create()]);
