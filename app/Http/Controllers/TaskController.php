<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Models\Task;
use App\Models\Type;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $taskService = new TaskService();
        $user = auth()->user();

        $statuses = $taskService->getStatuses($user);
        $tasks = $taskService->getTasks($user);
        $statuses = $taskService->getTasksInCorrectStatus($statuses, $tasks);

        return Inertia::render('Dashboard', [
            'user' => $user,
            'statuses' => $statuses,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $taskService = new TaskService();

        $types = Type::all()->pluck('name');

        $user = auth()->user();
        $statuses = $taskService->getStatuses($user);

        return Inertia::render('NewTask', [
            'types' => $types,
            'statuses' => $statuses,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request): void
    {
        $taskService = new TaskService();
        $validated = $request->validated();
        $taskFillables = $taskService->arrangeTaskArrayForInput($validated);

        $task = Task::create($taskFillables);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }
}
