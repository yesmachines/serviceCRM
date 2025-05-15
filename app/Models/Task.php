<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'job_schedule_id',
        'task_status_id',
        'vehicle_id',
        'start_datetime',
        'end_datetime',
        'task_details',
        'reason',
    ];

    public function jobSchedule()
    {
        return $this->belongsTo(JobSchedule::class);
    }

    public function taskStatus()
    {
        return $this->belongsTo(TaskStatus::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
