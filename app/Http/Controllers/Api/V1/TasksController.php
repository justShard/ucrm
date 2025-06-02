<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTasksRequest;
use App\Http\Requests\UpdateTasksRequest;
use App\Http\Resources\TasksResource;
use App\Models\Tasks;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return TasksResource::collection(Tasks::all());
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
    public function show($id)//Tasks $tasks
    {
        $task = Tasks::find($id);
        return TasksResource::make($task);
//
//
//        if (!$task) {
//            return response()->json(['message' => 'Not found'], 404);
//        }
//
//        return response()->json([
//            'data' => [
//                'id' => $task->id,
//                'name' => $task->name,
//                'done' => $task->done,
//            ]
//        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTasksRequest $request, $id)//Tasks $tasks
    {
        $tasks = Tasks::find($id);
        $tasks->update($request->validated());

        return TasksResource::make($tasks);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)//Tasks $tasks
    {
        $tasks = Tasks::find($id);
        $status = $tasks->delete();
//        var_dump($status); die();
        $tasks->refresh();
        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function complete(Request $request, $id)//Tasks $tasks
    {
        $tasks = Tasks::find($id);
        $tasks->is_completed = $request->is_completed;//??? done
        $tasks->save();

        return TasksResource::make($tasks);
    }
}