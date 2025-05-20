<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstallationTechnicianFeedback extends Model
{
   
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
}
