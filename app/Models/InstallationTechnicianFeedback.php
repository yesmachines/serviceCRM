<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InstallationTechnicianFeedback extends Model
{
   
    use SoftDeletes;
    protected $table = 'installation_technician_feedbacks';

    protected $fillable = [
        'installation_report_id',
        'label',
        'feedback',
        'remarks',
    ];

    public function installationReport()
    {
        return $this->belongsTo(InstallationReport::class);
    }
    
     public function getLabelNameAttribute()
    {
        return \App\Enums\InstallationCF::tryFrom($this->label)?->label() ?? '--';
    }
}
