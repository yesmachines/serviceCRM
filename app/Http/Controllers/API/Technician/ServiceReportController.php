<?php

namespace App\Http\Controllers\API\Technician;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceReportResource;
use App\Models\ClientFeedback;
use App\Models\ServiceReport;
use App\Models\ServiceReportClientFeedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ServiceReportController extends Controller
{

    public function index()
    {
        $reports = ServiceReport::with(['task', 'technician', 'concludedBy'])->latest()->paginate(15);
        return successResponse('Success', ServiceReportResource::collection($reports));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'task_id'               => 'nullable|exists:tasks,id',
            'description'           => 'nullable|string',
            'observations'          => 'nullable|string',
            'actions_taken'         => 'nullable|string',
            'client_remark'         => 'nullable|string',
            'technician_id'         => 'nullable|exists:technicians,id',
            'concluded_by'          => 'nullable|exists:users,id',
            'client_representative' => 'nullable|string|max:255',
            'designation'           => 'nullable|string|max:255',
            'contact_number'        => 'nullable|string|max:50',
            'client_signature' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'client_feedbacks' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            $errorMessage = $validator->messages();
            return errorResponse(trans('api.required_fields'), $errorMessage);
        }

        $validated = $validator->validated();
        $imagePath = null;
        if ($request->hasFile('client_signature')) {
            $imagePath = $request->file('client_signature')->store('client_signatures', 'public');
        }
        $report = new ServiceReport();
        $report->task_id     = $validated['task_id'];
        $report->description = $validated['description'];
        $report->observations= $validated['observations'];
        $report->actions_taken= $validated['actions_taken'];
        $report->client_remark= $validated['client_remark'];
        $report->technician_id= $validated['technician_id'];
        $report->concluded_by= $validated['concluded_by'];
        $report->client_representative= $validated['client_representative'];
        $report->designation= $validated['designation'];
        $report->contact_number= $validated['contact_number'];
        $report->client_signature= $imagePath;
        $report->save();

        if (!empty($validated['client_feedbacks']) && is_array($validated['client_feedbacks'])) {
            foreach ($validated['client_feedbacks'] as $label => $feedback) {
                ServiceReportClientFeedback::create([
                    'service_report_id' => $report->id,
                    'label' => $label,
                    'feedback' => $feedback,
                    'remark' => $request->remarks ?? null,
                ]);
           }
        }


        $report->load(['task', 'technician', 'concludedBy','clientFeedbacks']);

        return successResponse('Success',new ServiceReportResource($report));

    }


    public function show($id)
    {
        $report = ServiceReport::with(['task', 'technician', 'concludedBy'])->find($id);
        if (!$report) {
            return errorResponse('Service report not found.', null, 404);
        }
        return successResponse('Success',new ServiceReportResource($report));
    }

    public function update(Request $request, $id)
    {
        $report = ServiceReport::find($id);
 

    if (!$report) {
        return errorResponse('Service report not found.', null, 404);
    }

    $validator = Validator::make($request->all(), [
        'task_id'               => 'nullable|exists:tasks,id',
        'description'           => 'nullable|string',
        'observations'          => 'nullable|string',
        'actions_taken'         => 'nullable|string',
        'client_remark'         => 'nullable|string',
        'technician_id'         => 'nullable|exists:technicians,id',
        'concluded_by'          => 'nullable|exists:users,id',
        'client_representative' => 'nullable|string|max:255',
        'designation'           => 'nullable|string|max:255',
        'contact_number'        => 'nullable|string|max:50',
        'client_signature'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'client_feedbacks' => 'nullable|array',
    ]);

    if ($validator->fails()) {
        return response()->json(['status' => false, 'errors' => $validator->errors()], 422);
    }

    $data = $validator->validated();

             
    if (!empty($data['client_feedbacks']) && is_array($data['client_feedbacks'])) {
        $report->clientFeedbacks()->delete();
        foreach ($data['client_feedbacks'] as $label => $feedback) {
            ServiceReportClientFeedback::create([
                'service_report_id' => $report->id,
                'label' => $label,
                'feedback' => $feedback,
                'remarks' => $request->remarks ?? null,
            ]);
       }
    }
    
    // Handle client_signature image update
    if ($request->hasFile('client_signature')) {
        // Delete old file if it exists
        if ($report->client_signature && Storage::disk('public')->exists($report->client_signature)) {
            Storage::disk('public')->delete($report->client_signature);
        }
        $imagePath = $request->file('client_signature')->store('client_signature', 'public');
        $report->client_signature = $imagePath;
    }

    $report->update($data);

    $report->load(['task', 'technician', 'concludedBy','clientFeedbacks']);

    return successResponse('Success',new ServiceReportResource($report));

}

    public function destroy($id)
    {
        $report = ServiceReport::find($id);
        if (!$report) {
            return response()->json(['status' => false, 'message' => 'Service report not found.'], 404);
        }

        $report->delete();
        return response()->json(['status' => true, 'message' => 'Service report deleted successfully.']);
    }
    
}
