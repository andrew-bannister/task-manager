<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Resources\EpicResource;
use App\Http\Resources\TaskResource;
use App\Models\Epic;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Inertia\Inertia;

class EpicController extends Controller
{
    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
        $this->user = auth()->user();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $statuses = $this->taskService->getStatuses($this->user);

        return Inertia::render('NewEpic', [
            'statuses' => $statuses,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request): void
    {
        $validated = $request->validated();
        $taskFillables = $this->taskService->arrangeTaskArrayForInput($validated);
        $task = new TaskResource(Task::create($taskFillables));

        $epicFillables = $this->taskService->arrangeEpicArrayForInput($task, $request->childTasks, $this->user);
        $epic = new EpicResource(Epic::create($epicFillables));
    }

    /**
     * Display the specified resource.
     */
    public function show(Epic $epic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Epic $epic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Epic $epic)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Epic $epic)
    {
        //
    }
}
