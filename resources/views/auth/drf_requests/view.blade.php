<x-app-layout>
    @section('title', 'Demo Request Forms')

    @section('header')
        <div class="page-title-right">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboards</a></li>
                <li class="breadcrumb-item active">Demo Request Forms</li>
            </ol>
        </div>
        <h4 class="page-title">Demo Request Forms</h4>
    @endsection

    @section('content')
        <div class="wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="clearfix">
                                    <div class="w-100" style="max-width:100%; padding: 0 24px;">
                                        @if(isset($drfDatas))
                                            @php
                                                $demoDate = $drfDatas->demo_date ? \Carbon\Carbon::parse($drfDatas->demo_date)->format('d M Y') : null;
                                            @endphp

                                            <div class="card p-3 shadow-sm border-0" style="background:#f8f9fa; text-align:left;">
                                                <div class="row mb-2">
                                                    <div class="col-md-3 col-5 text-muted">Brand:</div>
                                                    <div class="col-md-9 col-7 fw-bold">{{ $drfDatas->brand->brand ?? '-' }}</div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-md-3 col-5 text-muted">Company:</div>
                                                    <div class="col-md-9 col-7 fw-bold">{{ $drfDatas->company->company ?? '-' }}</div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-md-3 col-5 text-muted">Customer:</div>
                                                    <div class="col-md-9 col-7 fw-bold">{{ $drfDatas->customer->fullname ?? '-' }}</div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-md-3 col-5 text-muted">Demo Date:</div>
                                                    <div class="col-md-9 col-7 fw-bold">{{ $demoDate ?? '-' }}</div>
                                                </div>

                                                
                                                @if($drfDatas->details && count($drfDatas->details))
                                                    <div class="row mb-2">
                                                        <div class="col-12 text-muted mb-2">Details:</div>
                                                        @foreach($drfDatas->details as $detail)
                                                            <div class="col-12">
                                                                <div class="border rounded p-3 mb-3 bg-white">
                                                                    <div class="row">
                                                                        <div class="col-md-6 col-12 mb-2">
                                                                            <span class="text-muted d-block">Product Name:</span>
                                                                            <span class="fw-semibold">{{ $detail->product->title ?? 'N/A' }}</span>
                                                                        </div>

                                                                        <div class="col-md-6 col-12 mb-2">
                                                                            <span class="text-muted d-block">Description:</span>
                                                                            <span class="fw-semibold">{{ $detail->description ?? 'N/A' }}</span>
                                                                        </div>

                                                                        <div class="col-md-6 col-12 mb-2">
                                                                            <span class="text-muted d-block">Quantity :</span>
                                                                            <span class="fw-semibold">{{ $detail->qty ?? 'N/A' }}</span>
                                                                        </div>

                                                                        <div class="col-md-6 col-12 mb-2">
                                                                            <span class="text-muted d-block">Job No(s):</span>
                                                                            @if($drfDatas->jobSchedules && $drfDatas->jobSchedules->count())
                                                                                @foreach($drfDatas->jobSchedules as $job)
                                                                                    <div class="fw-semibold">{{ $job->job_no ?? 'N/A' }}</div>
                                                                                @endforeach
                                                                            @else
                                                                                <span class="fw-semibold">N/A</span>
                                                                            @endif
                                                                        </div>

                                        

                                                                      <div class="col-md-6 col-12 mb-2">
                                                                            <span class="text-muted d-block">Machine In:</span>
                                                                            <span class="fw-semibold">{{ $detail->machine_in ? \Carbon\Carbon::parse($detail->machine_in)->format('d M Y h:i A') : 'N/A' }}</span>
                                                                        </div>

                                                                        <div class="col-md-6 col-12 mb-2">
                                                                            <span class="text-muted d-block">Machine Out:</span>
                                                                            <span class="fw-semibold">{{ $detail->machine_out ? \Carbon\Carbon::parse($detail->machine_out)->format('d M Y h:i A') : 'N/A' }}</span>
                                                                        </div>

                                                                        <div class="col-md-6 col-12 mb-2">
                                                                            <span class="text-muted d-block">Product Name:</span>
                                                                            <span class="fw-semibold">{{ $detail->product->title ?? 'N/A' }}</span>
                                                                        </div>

                                                                        <div class="col-md-6 col-12 mb-2">
                                                                            <span class="text-muted d-block">Remarks:</span>
                                                                            <span class="fw-semibold">{{ $detail->remarks ?? 'N/A' }}</span>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif

                                    </div> <!-- /.w-100 -->
                                    @endif
                                </div> <!-- /.clearfix -->
                            </div> <!-- /.card-body -->
                        </div> <!-- /.card -->
                    </div> <!-- /.col-12 -->
                </div> <!-- /.row -->
            </div> <!-- /.container-fluid -->
        </div> <!-- /.wrapper -->
    @endsection
</x-app-layout>
