<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function __construct()
    {
        $this->user = auth()->user();
    }

    public function taskSearch (Request $request)
    {
        $searchString = $request->query('query');

        $tasks = new Task();

        return $tasks->where('user_id', '=', $this->user->id)
            ->whereAny([
                'title',
                'label'
            ], 'like', '%' . $searchString . '%')
            ->take(10)
            ->get();
    }
}
