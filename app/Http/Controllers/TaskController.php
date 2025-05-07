<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    public function index(): JsonResponse
    {
        $tasks = auth()->user()->tasks;
        return response()->json($tasks);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'completed' => 'boolean'
        ]);

        $task = auth()->user()->tasks()->create($validated);

        return response()->json($task, 201);
    }

    public function show(Task $task): JsonResponse
    {
        $this->authorize('view', $task);
        return response()->json($task);
    }

    public function update(Request $request, Task $task): JsonResponse
    {
        $this->authorize('update', $task);

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'body' => 'sometimes|required|string',
            'completed' => 'sometimes|required|boolean'
        ]);

        $task->update($validated);

        return response()->json($task);
    }

    public function destroy(Task $task): JsonResponse
    {
        $this->authorize('delete', $task);
        $task->delete();
        return response()->json(null, 204);
    }
} 