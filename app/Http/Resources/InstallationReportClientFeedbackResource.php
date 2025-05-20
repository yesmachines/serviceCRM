<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InstallationReportClientFeedbackResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        return [
            'id'                    => $this->id,
            'installation_report_id' => $this->installation_report_id,
            'label'                 => $this->label,
            'feedback'              => $this->feedback,
            'remarks'               => $this->remarks,
            // 'created_at'            => $this->created_at,
            // 'updated_at'            => $this->updated_at,
        ];
    }
}
