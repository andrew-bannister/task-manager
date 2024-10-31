<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Models\Type;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class TaskController extends Controller
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
        $statuses = $this->taskService->getStatuses($this->user);
        $tasks = $this->taskService->getTasks($this->user);
        $statuses = $this->taskService->getTasksInCorrectStatus($statuses, $tasks);

        return Inertia::render('Dashboard', [
            'user' => $this->user,
            'statuses' => $statuses,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = Type::all()->pluck('name');
        $statuses = $this->taskService->getStatuses($this->user);

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
        $validated = $request->validated();
        $taskFillables = $this->taskService->arrangeTaskArrayForInput($validated);

        $task = new TaskResource(Task::create($taskFillables));
    }

    /**
     * Display the specified resource.
     */
    public function show(?int $id)
    {
        $task = new TaskResource(Task::find($id));
        $task = $this->taskService->addFullTypeAndStatusToTask($task);

        return Inertia::render('TaskView', [
            'task' => $task,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $task = Task::find($id);
        $task = $this->taskService->addFullTypeAndStatusToTask($task);

        $types = Type::all()->pluck('name');
        $statuses = $this->taskService->getStatusNames($this->user);

        return Inertia::render('EditTask', [
            'task' => $task,
            'types' => $types,
            'statuses' => $statuses,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): void
    {
        $task = Task::find($id);

        $typeId = $this->taskService->getTypeFromName($request->type)->id;
        $statusId= $this->taskService->getStatusFromName($request->status)->id;

        foreach ($request->request as $key => $val) {
            if ($key == 'type' || $key == 'status') {
                $task->{$key . '_id'} = ${$key . 'Id'};
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
        return redirect()->route('dashboard');
    }
}
