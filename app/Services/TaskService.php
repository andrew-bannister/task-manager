<?php

namespace App\Services;

use App\Http\Resources\TaskResource;
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

    public function getTasks(User $user): array
    {
        return json_decode(
            json_encode(
                TaskResource::collection(Task::where('user_id', $user->id)->get())
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

    public function getTypeFromName(string $name): Type
    {
         return Type::where('name', $name)->first();
    }

    public function addFullTypeAndStatusToTask(Task $task): Task
    {
        $task['type'] = Type::find($task['type_id']);
        $task['status'] = Status::find($task['status_id']);

        return $task;
    }
}
