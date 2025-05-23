<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DemoClientFeedback extends Model
{
    use SoftDeletes;
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
