<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
 
    public function toArray($request)
    {
        return [
            'id'             => $this->id,
            
            'job_schedule'   => $this->whenLoaded('jobSchedule', function () {
                return [
                    'id'    => $this->jobSchedule->id,
                    'job_no' => $this->jobSchedule->job_no,
                    // add other fields you want from JobSchedule
                ];
            }),
            
            'status'         => $this->whenLoaded('taskStatus', function () {
                return [
                    'id'     => $this->taskStatus->id,
                    'status' => $this->taskStatus->status,
                    'priority' => $this->taskStatus->priority,
                ];
            }),
            
            'vehicle'        => $this->whenLoaded('vehicle', function () {
                return [
                    'id'   => $this->vehicle->id,
                    'name' => $this->vehicle->name ?? 'N/A', // example field, change as needed
                ];
            }),
    
            'start'          => $this->start_datetime,
            'end'            => $this->end_datetime,
            'details'        => $this->task_details,
            'reason'         => $this->reason,
            'created_at'     => $this->created_at,
        ];
    }
}

