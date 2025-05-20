<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id'                    => $this->id,
            'task_id'               => $this->task_id,
            'task'                  => new TaskResource($this->whenLoaded('task')),
            'description'           => $this->description,
            'observations'          => $this->observations,
            'actions_taken'         => $this->actions_taken,
            'client_remark'         => $this->client_remark,
            'technician_id'         => $this->technician_id,
            'technician'            => $this->whenLoaded('technician'),
            'concluded_by'          => $this->concluded_by,
            'concluded_user'        => $this->whenLoaded('concludedBy'),
            'client_feedbacks'      => ClientFeedbackResource::collection($this->whenLoaded('clientFeedbacks')),
            'client_representative' => $this->client_representative,
            'designation'           => $this->designation,
            'contact_number'        => $this->contact_number,
            'client_signature'      =>  $this->client_signature ? asset('storage/' . $this->client_signature) : '',
            'created_at'            => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}