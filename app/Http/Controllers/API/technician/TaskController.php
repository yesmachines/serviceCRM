<?php

namespace App\Http\Controllers\API\technician;

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

        // dd($request->all());
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
            'assistence' => 'array',
            'assistence.*' => 'exists:technicians,id',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errorMessage = $validator->messages();
            return errorResponse(trans('api.required_fields'), $errorMessage);
        }

        $validated = $validator->validated();

        $task = new Task();
        $task->start_datetime = parseDateTimeOrNull($request->start_date, $request->start_time);
        $task->end_datetime = parseDateTimeOrNull($request->end_date, $request->end_time); // <-- fixed end_datetime
        $task->vehicle_id = $validated['vehicle_id'] ?? null;
        $task->reason = $validated['reason'] ?? null;
        $task->task_details = $validated['task_details'];
        $task->task_status_id = $validated['task_status_id'] ?? null;
        $task->job_schedule_id = $validated['job_schedule_id'] ?? null;
        $task->save();

      
        if (!empty($validated['assistence'])) {
            $task->assistences()->attach($validated['assistence']);
        }

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
            'assistence'      => 'array',
            'assistence.*'    => 'exists:technicians,id',
        ];
    
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validation failed',
                'errors'  => $validator->errors()
            ], 422);
        }
    
        $validated = $validator->validated();
    
        $task = Task::find($id);
    
        if (!$task) {
            return response()->json([
                'status'  => false,
                'message' => 'Task not found',
            ], 404);
        }
    
        // Update task fields
        $task->job_schedule_id = $validated['job_schedule_id'] ?? null;
        $task->task_status_id  = $validated['task_status_id'] ?? null;
        $task->vehicle_id      = $validated['vehicle_id'] ?? null;
        $task->start_datetime  = parseDateTimeOrNull($validated['start_date'], $validated['start_time']);
        $task->end_datetime    = parseDateTimeOrNull($validated['end_date'], $validated['end_time']);
        $task->task_details    = $validated['task_details'];
        $task->reason          = $validated['reason'] ?? null;
        $task->save();
    
        // ✅ Sync assistences (technicians)
        if (isset($validated['assistence'])) {
            $task->assistences()->sync($validated['assistence']);
        }
    
        $task->load(['jobSchedule', 'taskStatus', 'vehicle', 'assistences']);
    
        return successResponse('Success', new TaskResource($task));
    }
      
    

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return response()->json(null, 204);
    }
}
