<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Services\StatusService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StatusController extends Controller
{
    public function __construct(StatusService $statusService)
    {
        $this->statusService = $statusService;
        $this->user = auth()->user();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statuses = $this->statusService->getStatuses($this->user);

        return Inertia::render('DashboardPreview', [
            'user' => $this->user,
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
    public function show(Status $status)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Status $status)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Status $status)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Status $status)
    {
        //
    }
}
