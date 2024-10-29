<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        $statuses = json_decode(User::with(['statuses' => function ($query) {
            $query->orderBy('order', 'asc');
        }])->find($user->id)->statuses, true);

        $tasks = json_decode(
            json_encode(
                TaskResource::collection(Task::where('user_id', $user->id)->get())
            ), true);

        foreach ($statuses as $key => $status) {
            $statuses[$key]['tasks'] = array_filter($tasks, function ($task) use ($status) {
                return $task['status']['id'] === $status['id'];
            });
        }

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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
