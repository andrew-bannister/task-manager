<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Models\Task;
use App\Models\Type;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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
    public function show(?int $id)
    {
        if (!is_null(Task::find($id))) {
            $taskService = new TaskService();

            $task = Task::find($id);
            $task = $taskService->addFullTypeAndStatusToTask($task);

            return Inertia::render('TaskView', [
                'task' => $task,
            ]);
        }

        Http::get(route('dashboard'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $taskService = new TaskService();

        $task = Task::find($id);
        $task = $taskService->addFullTypeAndStatusToTask($task);

        $types = Type::all()->pluck('name');

        $user = auth()->user();
        $statuses = $taskService->getStatuses($user);

        return Inertia::render('EditTask', [
            'task' => $task,
            'types' => $types,
            'statuses' => $statuses,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $taskService = new TaskService();
        $task = Task::find($id);

        $typeId = $taskService->getTypeFromName($request->type)->id;

        foreach ($request->request as $key => $val) {
            if ($key == 'type') {
                $task->type_id = $typeId;
                continue;
            }
            if ($key == 'status') {
                $task->status_id = $val['id'];
                continue;
            }
            $task->$key = $val;
        }

        $task->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        $task->delete();
    }
}
