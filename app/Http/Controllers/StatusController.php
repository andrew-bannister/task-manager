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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $status = $this->statusService->createOrGet($request->name);
        $userStatuses = $this->statusService->getStatuses($this->user);
        $order = count($userStatuses) + 1;
        try {
            $this->user->statuses()->attach($status->id, ['order' => $order]);
        } catch (\Exception $ex) {

        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $statuses = $this->statusService->getStatuses($this->user);
        $changedStatus = $statuses[array_search($id, array_column($statuses, 'id'))];

        foreach ($statuses as $status) {
            if ($status['id'] == $id) {
                continue;
            }

            if ($request['order'] > $changedStatus['pivot']['order']
                && $status['pivot']['order'] > $changedStatus['pivot']['order']
                && $status['pivot']['order'] <= $request['order'])
            {
                $this->user->statuses()->updateExistingPivot($status['id'], ['order' => ($status['pivot']['order'] - 1)]);
            }

            if ($request['order'] < $changedStatus['pivot']['order']
                && $status['pivot']['order'] < $changedStatus['pivot']['order']
                && $status['pivot']['order'] >= $request['order'])
            {
                $this->user->statuses()->updateExistingPivot($status['id'], ['order' => ($status['pivot']['order'] + 1)]);
            }
        }

        $this->user->statuses()->updateExistingPivot($id, ['order' => $request['order']]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $status = Status::find($id);
        $orderId = $status->users()->where('user_id', $this->user->id)->first()->pivot->order;


        $status->users()->detach($this->user);
        $otherStatuses = $this->statusService->getStatuses($this->user);
        foreach ($otherStatuses as $otherStatus) {
            if ($otherStatus['pivot']['order'] > $orderId){
                $otherStatusModel = Status::find($otherStatus['id']);
                $otherStatusModel->users()->updateExistingPivot($this->user->id ,['order' => ($otherStatus['pivot']['order'] - 1)]);
            }
        }
    }
}
