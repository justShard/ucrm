<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTasksRequest;
use App\Http\Requests\UpdateTasksRequest;
use App\Http\Resources\TasksResource;
use App\Models\Tasks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return TasksResource::collection(auth()->user()->tasks()->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTasksRequest $request)
    {
        $tasks = Tasks::create($request->validated());

        return TasksResource::make($tasks);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $task = Tasks::find($id);
        Gate::authorize("view", $task);
        return TasksResource::make($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTasksRequest $request, $id)
    {
        $tasks = Tasks::find($id);
        Gate::authorize('view', $tasks);
        $tasks->update($request->validated());

        return TasksResource::make($tasks);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $tasks = Tasks::find($id);
        Gate::authorize('view', $tasks);
        $status = $tasks->delete();
        $tasks->refresh();
        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function complete(Request $request, $id)
    {
        $tasks = Tasks::find($id);
        $tasks->is_complited = $request->is_complited;
        $tasks->save();

        return TasksResource::make($tasks);
    }
}