<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;
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
    public function assistences()
    {
        return $this->belongsToMany(Technician::class, 'task_assistances', 'task_id', 'technician_id')->withTimestamps();
    }

    
}


