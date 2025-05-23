<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobStatus extends Model
{
   use HasFactory ,SoftDeletes;

    protected $fillable = [
        'status',
        'priority',
        'active',
    ];

    public function jobSchedules()
    {
        return $this->hasMany(JobSchedule::class, 'job_status_id');
    }
}
