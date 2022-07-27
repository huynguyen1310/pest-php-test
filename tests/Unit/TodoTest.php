<?php

use App\Models\Todo;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

it('does not create a to-do without a name field', function () {
    $response = $this->postJson('/api/todos', []);
    $response->assertStatus(422);
});

it('can create a to-do', function () {
    $attributes = Todo::factory()->raw();
    $response = $this->postJson('/api/todos', $attributes);
    $response->assertStatus(201)->assertJson(['message' => 'Todo has been created']);
    $this->assertDatabaseHas('todos', $attributes);
});

it('can fetch a to-do', function () {
    $todo = Todo::factory()->create();

    $response = $this->getJson("/api/todos/{$todo->id}");

    $data = [
        'message' => 'Retrieved To-do',
        'todo'    => [
            'id'        => $todo->id,
            'name'      => $todo->name,
            'completed' => $todo->completed,
        ]
    ];

    $response->assertStatus(200)->assertJson($data);
});

it('can update a to-do', function () {
    $todo = Todo::factory()->create();
    $updatedTodo = ['name' => 'Updated To-do'];
    $response = $this->putJson("/api/todos/{$todo->id}", $updatedTodo);
    $response->assertStatus(200)->assertJson(['message' => 'To-do has been updated']);
    $this->assertDatabaseHas('todos', $updatedTodo);
});

it('can delete a todo', function () {
    $todo = Todo::factory()->create();
    $response = $this->deleteJson("/api/todos/{$todo->id}");
    $response->assertStatus(200)->assertJson(['message' => 'To-do has been deleted']);
    $this->assertDatabaseMissing('todos', ['id' => $todo->id]);
});
