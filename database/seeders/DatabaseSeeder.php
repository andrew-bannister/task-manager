<?php

namespace Database\Seeders;

use App\Models\Status;
use App\Models\Type;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
//        $tasks = Task::factory()->count(10)->create();
        $defaultStatuses = [
            'In Progress',
            'Testing',
            'Code Review',
            'Done'
        ];

        foreach ($defaultStatuses as $status) {
            Status::create([
                'name' => $status
            ]);
        }

        $taskTypes = [
            'Story' => 'Story',
            'Epic' => 'Epic',
        ];

        foreach ($taskTypes as $name => $logo) {
            Type::create([
                'name' => $name,
                'logo' => $logo,
            ]);
        }
    }
}
