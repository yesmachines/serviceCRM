<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstallationAttendee extends Model
{
    

    protected $fillable = [
        'installation_report_id',
        'technician_id',
    ];
    

    public function installationReport()
    {
        return $this->belongsTo(InstallationReport::class);
    }

    

   

    public function technician()
    {
        return $this->belongsTo(Technician::class, 'technician_id');
    }
}
