<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DemoClientFeedback extends Model
{
    protected $table ='demo_client_feedbacks';
    protected $fillable = [
        'job_schedule_id',
        'demo_objective',
        'result',
        'client_representative',
        'designation',
        'client_signature',
        'rating',
        'comment',
    ];

    public function jobSchedule()
    {
        return $this->belongsTo(JobSchedule::class);
    }
}
