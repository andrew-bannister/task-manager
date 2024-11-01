<?php

namespace App\Services;

use App\Models\Status;
use App\Models\User;

class StatusService
{
    public function getStatuses(User $user): array
    {
        $taskService = new TaskService();
        return $taskService->getStatuses($user);
    }

    public function createOrGet(string $name): Status
    {
        $status = new Status();
        $foundStatus = $status->firstOrCreate(['name' => $name]);
        return $foundStatus;
    }


}
