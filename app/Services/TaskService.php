<?php

namespace App\Services;

use App\Http\Resources\StatusResource;
use App\Http\Resources\TaskResource;
use App\Http\Resources\TypeResource;
use App\Models\Epic;
use App\Models\Status;
use App\Models\Task;
use App\Models\Type;
use App\Models\User;

class TaskService
{
    public function getStatuses(User $user): array
    {
        return json_decode(User::with(['statuses' => function ($query) {
            $query->orderBy('order', 'asc');
        }])->find($user->id)->statuses, true);
    }

    public function getStatusNames(User $user): array
    {
        return json_decode(User::with(['statuses' => function ($query) {
            $query->orderBy('order', 'asc');
        }])->find($user->id)->statuses->pluck('name'), true);
    }

    public function getNonEpicTasks(User $user): array
    {
        $epic = Type::where('name', 'epic')->first();

        return json_decode(
            json_encode(
                TaskResource::collection(
                    Task::where('user_id', $user->id)
                        ->where('type_id', '!=', $epic->id)
                        ->get())
            ), true);
    }

    public function getTasksInCorrectStatus(array $statuses, array $tasks): array
    {
        foreach ($statuses as $key => $status) {
            $statuses[$key]['tasks'] = array_filter($tasks, function ($task) use ($status) {
                return $task['status']['id'] === $status['id'];
            });
        }
        return $statuses;
    }

    public function arrangeTaskArrayForInput(array $validated): array
    {
        return [
            'title' => $validated['title'],
            'label' => $validated['label'],
            'description' => $validated['description'],
            'user_id' => auth()->user()->id,
            'type_id' => $this->getTypeFromName($validated['type'])->id,
            'status_id' => $validated['status']['id'],
            'deleted_at' => null,
        ];
    }

    public function arrangeEpicArrayForInput($task, $childTasks, $user): array
    {
        return [
            'user_id' => $user->id,
            'task_id' => $task->id,
            'children' => json_encode($childTasks),
        ];
    }

    public function getTypeFromName(string $name): TypeResource
    {
         return new TypeResource(Type::where('name', $name)->first());
    }

    public function getStatusFromName(string $name): StatusResource
    {
         return new StatusResource(Status::where('name', $name)->first());
    }

    public function addFullTypeAndStatusToTask(TaskResource $task): TaskResource
    {
        $task['type'] = new TypeResource(Type::find($task->type_id));
        $task['status'] = new StatusResource(Status::find($task->status_id));

        return $task;
    }

    public function getEpics(User $user)
    {
        $epics = Epic::where('user', $user->id)->get();
    }
}
