<?php

use function Pest\Laravel\getJson;

test('example', function () {
    getJson('/')->assertSuccessful();
});
