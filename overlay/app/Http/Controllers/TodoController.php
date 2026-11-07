<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TodoController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Todo::orderBy('id')->get());
    }

    public function show(Todo $todo): JsonResponse
    {
        return response()->json($todo);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'details' => ['required', 'string', 'max:255'],
        ]);

        $todo = Todo::create($validated)->refresh();

        return response()->json($todo, 201);
    }

    public function update(Request $request, Todo $todo): JsonResponse
    {
        $validated = $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'details' => ['required', 'string', 'max:255'],
        ]);

        $todo->update($validated);

        return response()->json($todo);
    }

    public function destroy(Todo $todo): Response
    {
        $todo->delete();

        return response()->noContent();
    }
}
