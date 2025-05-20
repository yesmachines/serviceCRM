<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstallationReportClientFeedback extends Model
{

    protected $table = 'installation_report_client_feedbacks';

    protected $fillable = [
        'installation_report_id',
        'label',
        'feedback',
        'remarks',
    ];
    /**
     * Get the installation report that owns the feedback.
     */
    public function installationReport()
    {
        return $this->belongsTo(InstallationReport::class);
    }

    
}
