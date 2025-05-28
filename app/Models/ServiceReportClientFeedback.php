<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceReportClientFeedback extends Model
{
     use SoftDeletes;
     // Optional: define the table name explicitly if it doesn't follow Laravel's plural naming convention
     protected $table = 'service_report_client_feedbacks';

     // Allow mass assignment for these fields
     protected $fillable = [
         'service_report_id',
         'label',
         'feedback',
         'remark', // include this if you're also saving remarks
     ];
 
     /**
      * Define the inverse relationship to the ServiceReport
      */
     public function serviceReport()
     {
         return $this->belongsTo(ServiceReport::class);
     }

     
     public function getLabelNameAttribute()
    {
        return \App\Enums\ServiceCF::tryFrom($this->label)?->label() ?? '--';
    }
}
