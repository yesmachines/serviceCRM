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
        return $this->hasOne(Technician::class, 'user_id', 'technician_id');
    }
  

    public function user()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }
}

