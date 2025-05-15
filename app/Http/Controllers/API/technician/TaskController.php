<?php

namespace App\Http\Controllers\api\technician;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index(Request $request){

        $query = Task::with(['jobSchedule', 'taskStatus', 'vehicle']);

        if ($request->has('task_status_id')) {
            $query->where('task_status_id', $request->task_status_id);
        }
        if ($request->has('job_schedule_id')) {
            $query->where('job_schedule_id', $request->job_schedule_id);
        }
        if ($request->has('vehicle_id')) {
            $query->where('vehicle_id', $request->vehicle_id);
        }
        $tasks = $query->paginate(15);

        return successResponse('Success', TaskResource::collection($tasks));
    }

    public function show($id)
    {
        $task = Task::findOrFail($id);

        return successResponse('Success',new TaskResource($task));
        
    }

    public function store (Request $request){
        $rules = [
            'job_schedule_id' => 'nullable|exists:job_schedules,id',
            'task_status_id' => 'nullable|exists:task_statuses,id',
            'vehicle_id' => 'nullable|exists:vehicles,id',
            'task_status_id' => 'nullable|exists:task_statuses,id',
            // 'start_datetime' => 'required|date',
            // 'end_datetime' => 'required|date|after_or_equal:start_datetime',
            'start_date'     => 'required|date_format:m/d/Y',
            'end_date'     =>   'required|date_format:m/d/Y',
            'start_time'     => 'required|date_format:H:i',
            'end_time'       => 'required|date_format:H:i|after:start_time',
            'task_details' => 'required|string',
            'reason' => 'nullable|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errorMessage = $validator->messages();
            return errorResponse(trans('api.required_fields'), $errorMessage);
        }

        $task = new Task();
        $task->start_datetime = parseDateTimeOrNull($request->start_date, $request->start_time);
        $task->end_datetime = parseDateTimeOrNull($request->end_time, $request->end_time);
        $task->vehicle_id = $request->vehicle_id;
        $task->reason = $request->reason;
        $task->task_details = $request->task_details;
        $task->task_status_id = $request->task_status_id;
        $task->job_schedule_id = $request->job_schedule_id;
        $task->task_status_id  = $request->task_status_id;
        $task->save();
        $task->load(['jobSchedule', 'taskStatus', 'vehicle']);

        return successResponse('Success',new TaskResource($task));
        // return response()->json($task, 201);
    }

    public function update(Request $request, $id)
    {

        $rules = [
            'job_schedule_id' => 'nullable|exists:job_schedules,id',
            'task_status_id'  => 'nullable|exists:task_statuses,id',
            'vehicle_id'      => 'nullable|exists:vehicles,id',
            'start_date'      => 'required|date_format:m/d/Y',
            'end_date'        => 'required|date_format:m/d/Y',
            'start_time'      => 'required|date_format:H:i',
            'end_time'        => 'required|date_format:H:i|after:start_time',
            'task_details'    => 'required|string',
            'reason'          => 'nullable|string',
            'task_status_id' => 'nullable|exists:task_statuses,id',
        ];
    
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation failed',
                'errors'  => $validator->errors()
            ], 422);
        }
    
        $task = Task::find($id);
    
        if (!$task) {
            return response()->json([
                'status'  => false,
                'message' => 'Task not found',
            ], 404);
        }
    
        $task->job_schedule_id = $request->job_schedule_id;
        $task->task_status_id  = $request->task_status_id;
        $task->vehicle_id      = $request->vehicle_id;
        $task->start_datetime  = parseDateTimeOrNull($request->start_date, $request->start_time);
        $task->end_datetime    = parseDateTimeOrNull($request->end_date, $request->end_time);
        $task->task_details    = $request->task_details;
        $task->reason          = $request->reason;
        $task->task_status_id  = $request->task_status_id;
        $task->save();
        $task->load(['jobSchedule', 'taskStatus', 'vehicle']);

        return successResponse('Success',new TaskResource($task));
      
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return response()->json(null, 204);
    }
}
