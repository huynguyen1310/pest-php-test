<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required',
            'completed' => 'boolean'
        ]);

        $todo = Todo::create($validated);

        $data = [
            'message' => 'Todo has been created',
            'todo'    => $this->mapTodoResponse($todo)
        ];

        return response()->json($data, 201);
    }

    public function show(Todo $todo)
    {
        $data = [
            'message' => 'Retrieved To-do',
            'todo'    => $this->mapTodoResponse($todo)
        ];
        return response()->json($data);
    }

    public function update(Request $request, Todo $todo)
    {
        $validated = $request->validate([
            'name'      => 'required',
            'completed' => 'boolean'
        ]);

        $todo->update($validated);
        $todo->refresh();

        $data = [
            'message' => 'To-do has been updated',
            'todo'    => $this->mapTodoResponse($todo)
        ];

        return response()->json($data);
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();

        return response()->json(['message' => 'To-do has been deleted']);
    }

    protected function mapTodoResponse($todo)
    {
        return [
            'id'        => $todo->id,
            'name'      => $todo->name,
            'completed' => $todo->completed
        ];
    }
}
