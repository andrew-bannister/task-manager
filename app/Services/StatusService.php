<?php

namespace App\Services;

use App\Models\User;

class StatusService
{
    public function getStatuses(User $user): array
    {
        $taskService = new TaskService();
        return $taskService->getStatuses($user);
    }
}
