<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(fn () => $this->user = User::factory()->create());

it('unauthenticated user cannot store a post', function () {
    $response = $this->post('/posts');
    $response->assertStatus(302);
});

it('authenticated user can create a post', function () {
    $response = $this->actingAs($this->user)->post('/posts', [
        'user_id' => $this->user->id,
        'title'   => 'test',
        'body'    => 'body test',
        'status'  => 'is_published',
    ]);
    $response->assertStatus(200);
    $this->assertDatabaseHas('posts', [
        'title' => 'test'
    ]);
});

it('requires title body and status', function () {
    $this->actingAs($this->user)->post('/posts')->assertSessionHasErrors(['title','body', 'status']);
});

it('authenticated user can visit create post route', function () {
    $response = $this->actingAs($this->user)->get('/posts/create');
    $response->assertStatus(200);
});

it('unauthenticated user cannot visit create post route', function () {
    $response = $this->get('/posts/create');
    $response->assertStatus(302);
});
