<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientFeedback extends Model
{
    use SoftDeletes;
    protected $table = 'client_feedbacks';
    
    protected $fillable = [
        'job_schedule_id',
        'job_type',
        'demo_objective',
        'result',
        'client_representative',
        'designation',
        'client_signature',
        'rating',
        'comment'
    ];

    public function jobSchedule()
    {
        return $this->belongsTo(JobSchedule::class);
    }

    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class, 'job_type');
    }
}
