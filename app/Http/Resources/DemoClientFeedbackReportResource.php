<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DemoClientFeedbackReportResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'job_schedule_id' => $this->job_schedule_id,
            'job_schedule' => [
                'job_no' => optional($this->jobSchedule)->job_no,
                'location' => optional($this->jobSchedule)->location,
                'contact_no' => optional($this->jobSchedule)->contact_no,
            ],
            'demo_objective' => $this->demo_objective,
            'result' => $this->result,
            'client_representative' => $this->client_representative,
            'designation' => $this->designation,
            'client_signature' => $this->client_signature ? asset('storage/' . $this->client_signature) : null,
            'rating' => $this->rating,
            'comment' => $this->comment,
            'created_at' => $this->created_at->format('d M Y h:i A'),
            'updated_at' => $this->updated_at->format('d M Y h:i A'),
        ];
    }
}