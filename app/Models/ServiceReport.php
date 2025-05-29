<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceReport extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'task_id',
        'description',
        'observations',
        'actions_taken',
        'client_remark',
        'technician_id',
        'concluded_by',
        'client_representative',
        'designation',
        'contact_number',
        'client_signature',
    ];

    /**
     * Get the task associated with this service report.
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Get the technician who performed the work.
     */
    public function technician(): BelongsTo
    {
        return $this->belongsTo(User::class,'technician_id');
    }

    

    /**
     * Get the user who concluded the job.
     */
    public function concludedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'concluded_by');
    }


    public function clientFeedbacks()
    {
        return $this->hasMany(ServiceReportClientFeedback::class);
    }
    
}
