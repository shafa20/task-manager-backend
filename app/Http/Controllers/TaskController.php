<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
class TaskController extends Controller
{
    // GET /tasks
    public function index(Request $request)
    {
        $query = \App\Models\Task::query();

        // Search by name or description
        if ($request->has('search') && $request->search !== null) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%") ;
            });
        }

        // Filter by status
        if ($request->has('status') && in_array($request->status, ['Pending', 'Completed'])) {
            $query->where('status', $request->status);
        }

        // Conditional Pagination
        if ($request->has('page') || $request->has('per_page')) {
            $perPage = $request->get('per_page', 10); // default 10
            $tasks = $query->orderBy('id', 'desc')->paginate($perPage);
            if ($tasks->isEmpty()) {
                return response()->json(['message' => 'No data found', 'data' => []], 200);
            }
            return response()->json($tasks, 200);
        } else {
            $tasks = $query->orderBy('id', 'desc')->get();
            if ($tasks->isEmpty()) {
                return response()->json(['message' => 'No data found', 'data' => []], 200);
            }
            return response()->json($tasks, 200);
        }
    }

 
  
// create tasks
        public function store(Request $request)
        {
            try {
                $validated = $request->validate([
                    'name' => 'required|string|max:255',
                    'description' => 'nullable|string',
                    'status' => ['required', \Illuminate\Validation\Rule::in(['Pending', 'Completed'])],
                ]);

                $task = \App\Models\Task::create($validated);
                return response()->json($task, 201);

            } catch (ValidationException $e) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $e->errors(),
                ], 422);
            }
        }

    // update /tasks/{id}
    public function update(Request $request, $id)
    {
        
        $task =  \App\Models\Task::find($id);
        if (!$task) {
            return response()->json([
                'message' => 'Task not found',
                'errors' => ['id' => ['No task found with this id']],
            ], 404);
        }
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'status' => ['required', \Illuminate\Validation\Rule::in(['Pending', 'Completed'])],
            ]);
            $task->update($validated);
            return response()->json($task, 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        }
    }

    // edit /tasks/{id}
    public function show($id)
    {
        $task = \App\Models\Task::find($id);
        if (!$task) {
            return response()->json([
                'message' => 'Task not found',
                'errors' => ['id' => ['No task found with this id']],
            ], 404);
        }
        return response()->json($task, 200);
    }

    // DELETE /tasks/{id}
    public function destroy($id)
    {
        $task = \App\Models\Task::find($id);
        if (!$task) {
            return response()->json([
                'message' => 'Task not found',
                'errors' => ['id' => ['No task found with this id']],
            ], 404);
        }
        $task->delete();
        return response()->json(['message' => 'Task deleted successfully'], 200);
    }
}
