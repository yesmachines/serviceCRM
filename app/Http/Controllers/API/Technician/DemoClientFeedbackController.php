<?php

namespace App\Http\Controllers\API\Technician;

use App\Http\Controllers\Controller;
use App\Http\Resources\DemoClientFeedbackReportResource;
use App\Models\DemoClientFeedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DemoClientFeedbackController extends Controller
{
    public function index(Request $request){
        $reports = DemoClientFeedback::with(['jobSchedule'])->latest()->paginate(15);
        return successResponse('Success', DemoClientFeedbackReportResource::collection($reports));
    }

    public function store(Request $request){
                
        $validator = Validator::make($request->all(), [
                    'job_schedule_id'         => 'required|exists:job_schedules,id',
                    'demo_objective'          => 'required',
                    'client_representative'   => 'nullable',
                    'result'                  => 'nullable',
                    'designation'             => 'nullable|string|max:255',
                    'rating'                  => 'nullable|string|max:255',
                    'comment'                 => 'nullable|string|max:255',
                    'client_signature'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                
                ]);
        
        if ($validator->fails()) {
            $errorMessage = $validator->messages();
            return errorResponse(trans('api.required_fields'), $errorMessage);
        }

        $data = $validator->validated();


        if ($request->hasFile('client_signature')) {
            $file = $request->file('client_signature');
            $path = $file->store('client_signatures', 'public');
            $data['client_signature'] = $path;
        }
        $report = new DemoClientFeedback();
        $report->job_schedule_id = $data['job_schedule_id'] ?? null;
        $report->demo_objective  = $data['demo_objective'] ?? null;
        $report->client_representative = $data['client_representative'] ?? null;
        $report->result = $data['result'] ?? null;
        $report->designation = $data['designation'] ?? null;
        $report->rating = $data['rating'] ?? null;
        $report->comment = $data['comment'] ?? null;
        $report->client_signature =  $data['client_signature'];
        $report->save();
      

        return response()->json([
            'status' => true,
            'message' => 'Demo Client Feedback created successfully.',
        ]);
        

    }

    public function show($id)
    {
        $feedback = DemoClientFeedback::with('jobSchedule')->findOrFail($id);

        return new DemoClientFeedbackReportResource($feedback);
    }

    
    public function update(Request $request, $id)
    {
        $feedback = DemoClientFeedback::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'job_schedule_id'         => 'sometimes|exists:job_schedules,id',
            'demo_objective'          => 'sometimes|required',
            'client_representative'   => 'nullable',
            'result'                  => 'nullable',
            'designation'             => 'nullable|string|max:255',
            'rating'                  => 'nullable|string|max:255',
            'comment'                 => 'nullable|string|max:255',
            'client_signature'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        // Delete old signature if new one is uploaded
        if ($request->hasFile('client_signature')) {
            if ($feedback->client_signature && Storage::disk('public')->exists($feedback->client_signature)) {
                Storage::disk('public')->delete($feedback->client_signature);
            }

            $data['client_signature'] = $request->file('client_signature')->store('client_signatures', 'public');
        }

        $feedback->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Demo Client Feedback updated successfully.',
            // 'data' => new DemoClientFeedbackReportResource($feedback->load('jobSchedule'))
        ]);
    }

    public function destroy($id)
    {
        $feedback = DemoClientFeedback::findOrFail($id);

        if ($feedback->client_signature && Storage::disk('public')->exists($feedback->client_signature)) {
            Storage::disk('public')->delete($feedback->client_signature);
        }

        $feedback->delete();

        return response()->json([
            'status' => true,
            'message' => 'Demo Client Feedback deleted successfully.'
        ]);
    }
}
