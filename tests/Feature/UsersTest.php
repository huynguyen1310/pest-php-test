<?php

it('has login page', function () {
   $response = $this->get('/login');

   $response->assertStatus(200);
});

it('has welcome page', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});
