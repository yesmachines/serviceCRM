
<button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#full-width-modal">
    View
</button>


<div id="full-width-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="fullWidthModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-full-width">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="fullWidthModalLabel">Service Report</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <h5 class="mb-3">Service Report Details</h5>
                    <table class="table table-bordered">
                        <tbody>


                            <tr><th>Task Details</th><td>{{ $report->task->task_details ?? '-' }}</td></tr>
                            <tr><th>Description</th><td>{{ $report->description  ?? '-' }}</td></tr>
                            <tr><th>Observations</th><td>{{ $report->observations  ?? '-' }}</td></tr>
                            <tr><th>Actions Taken</th><td>{{ $report->actions_taken  ?? '-' }}</td></tr>
                            <tr><th>Client Remark</th><td>{{ $report->client_remark }}</td></tr>
                            <tr><th>Client Representative</th><td>{{ $report->client_representative  ?? '-' }}</td></tr>
                            <tr><th>Designation</th><td>{{ $report->designation  ?? '-' }}</td></tr>
                            <tr><th>Contact Number</th><td>{{ $report->contact_number }}</td></tr>
                            <tr><th>Technician</th><td>{{$report->technician->name ?? '-' }}</td></tr>
                            <tr><th>Concluded By</th><td>{{ optional($report->concludedBy)->name  ?? '-' }}</td></tr>
                            <tr><th>Task Details</th><td>{{ optional($report->task)->task_details  ?? '-' }}</td></tr>
                            <tr><th>Task Status</th><td>{{ optional($report->task->taskStatus)->status  ?? '-' }}</td></tr>
                            <tr><th>Job Schedule No</th><td>{{ optional($report->task->jobSchedule)->job_no  ?? '-' }}</td></tr>
                            <tr><th>Job Created By</th><td>{{ optional($report->task->jobSchedule->createdBy)->name  ?? '-' }}</td></tr>
                            <tr><th>Job Owner</th><td>{{ optional($report->task->jobSchedule->jobOwner)->name  ?? '-' }}</td></tr>
                            <tr><th>Job Location</th><td>{{ $report->task->jobSchedule->location ?? '-' }}</td></tr>
                            <tr><th>Job Start</th><td>{{ optional($report->task->jobSchedule)->start_datetime  ?? '-' }}</td></tr>
                            <tr><th>Job End</th><td>{{ optional($report->task->jobSchedule)->end_datetime  ?? '-' }}</td></tr>                      <tr>
                                <th>Client Signature</th>
                                <td>
                                @if($report->client_signature && Storage::disk('public')->exists($report->client_signature))
                                    <img src="{{ asset('storage/' . $report->client_signature) }}" alt="Client Signature" class="img-fluid" style="max-height: 200px;">
                                @else
                                    <em>No signature available</em>
                                @endif
                                </td>
                            </tr>

                           
                          
                        </tbody>
                    </table>


                    <h5 class="mt-5 mb-3">Client Feedback</h5>
                            <table class="table table-bordered text-center align-middle">
                                <thead>
                                    <tr>
                                        <th></th> <!-- Label column with no heading -->
                                        <th>Excellent</th>
                                        <th>Good</th>
                                        <th>To Improve</th>
                                    </tr>
                                </thead>
                                <tbody>

                              
                                    @forelse($report->clientFeedbacks as $feedback)
                                        <tr>
                                            <td class="text-start">{{ $feedback->label_name }}</td>
                                            <td>@if(strtolower($feedback->feedback) == 'excellent') ✓ @endif</td>
                                            <td>@if(strtolower($feedback->feedback) == 'good') ✓ @endif</td>
                                            <td>@if(strtolower($feedback->feedback) == 'to-improve' || strtolower($feedback->feedback) == 'to improve') ✓ @endif</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">No client feedbacks available.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                </div>
            </div>
        </div>
    </div>
</div>




