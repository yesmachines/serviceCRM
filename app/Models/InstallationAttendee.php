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

    public function user()
    {
        return $this->hasOneThrough(
            \App\Models\User::class,
            \App\Models\Technician::class,
            'id',          // Foreign key on Technician table...
            'id',          // Foreign key on User table...
            'technician_id', // Local key on InstallationAttendee table...
            'user_id'      // Local key on Technician table...
        );
    }
}
