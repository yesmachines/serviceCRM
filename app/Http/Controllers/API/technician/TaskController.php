<?php

namespace App\Http\Controllers\api\technician;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index(Request $request){

        $query = Task::query();

        if ($request->has('job_schedule_id')) {
            $query->where('job_schedule_id', $request->job_schedule_id);
        }

        if ($request->has('vehicle_id')) {
            $query->where('vehicle_id', $request->vehicle_id);
        }

        $tasks = $query->paginate(15);

        return response()->json($tasks);
    }

    public function show($id)
    {
        $task = Task::findOrFail($id);
        return response()->json($task);
    }

    public function store (Request $request){

        
        $rules = [
            'job_schedule_id' => 'nullable|exists:job_schedules,id',
            'task_status_id' => 'nullable|exists:task_statuses,id',
            'vehicle_id' => 'nullable|exists:vehicles,id',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after_or_equal:start_datetime',
            'task_details' => 'required|string',
            'reason' => 'nullable|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errorMessage = $validator->messages();
            return errorResponse(trans('api.required_fields'), $errorMessage);
        }
       
        $task = Task::create($validator);
        return response()->json($task, 201);
    }

    public function update(Request $request,$id){

        $task = Task::findOrFail($id);

        $validated = $request->validate([
            'job_schedule_id' => 'nullable|exists:job_schedules,id',
            'task_status_id' => 'nullable|exists:task_statuses,id',
            'vehicle_id' => 'nullable|exists:vehicles,id',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after_or_equal:start_datetime',
            'task_details' => 'required|string',
            'reason' => 'nullable|string',
        ]);

        $task->update($validated);

        return response()->json($task);

    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return response()->json(null, 204);
    }
}
