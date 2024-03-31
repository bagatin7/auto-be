<?php

it('has ares page', function () {
    $response = $this->get('/ares');

    $response->assertStatus(200);
});
