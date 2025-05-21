<button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#full-width-modal">
    View
</button>


<div id="full-width-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="fullWidthModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-full-width">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="fullWidthModalLabel">Demo Client Feedback Report</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <h5 class="mb-3">Demo Client Feedback Report Details</h5>
                    <table class="table table-bordered">
                        <tbody>

                        @php
                        use Carbon\Carbon;

                        $start = $report->job_start_datetime ? Carbon::parse($report->job_start_datetime)->format('d M Y h:i A') : null;
                        $end = $report->job_end_datetime ? Carbon::parse($report->job_end_datetime)->format('d M Y h:i A') : null;
                        @endphp

                      
                        
                            <tr><th>Job Schedule No</th><td>{{$report->jobSchedule->job_no ?? '-'}}</td></tr>
                            <tr><th>Job Location</th><td>{{$report->jobSchedule->location ?? '-'}}</td></tr>
                            <tr><th>Job Contact No</th><td>{{$report->jobSchedule->contact_no ?? '-'}}</td></tr>
                            <tr><th>Job Strat Time and Date</th><td>{{ $start ?? '-'}}</td></tr>
                            <tr><th>Job End Time and Date</th><td>{{ $end ?? '-'}}</td></tr>
                            <tr><th>Demo Objective</th><td>{{$report->demo_objective ?? '-'}}</td></tr>
                            <tr><th>Result</th><td>{{$report->result ?? '-'}}</td></tr>
                            <tr><th>Client Representative</th><td>{{$report->client_representative ?? '-'}}</td></tr>
                            <tr><th>Designation</th><td>{{$report->designation ?? '-'}}</td></tr>
                            <tr><th>Rating</th><td>{{$report->rating ?? '-'}}</td></tr>
                            <tr><th>Comment</th><td>{{$report->comment ?? '-'}}</td></tr>
                          
                                <th>Client Signature</th>
                                <td>
                                @if($report->client_signature && Storage::disk('public')->exists($report->client_signature))
                                    <img src="{{ asset('storage/' . $report->client_signature) }}" alt="Client Signature" class="img-fluid" style="max-height: 200px;">
                                @else
                                    <em>No signature available</em>
                                @endif
                                </td>
                            </tr>


                           </tr>
                    
                           
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
