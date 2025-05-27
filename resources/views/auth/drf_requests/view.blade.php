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
        <!-- Begin page -->
        <div class="wrapper">

            
         


            <!-- <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">

                       

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">

                                        <!-- Invoice Logo-->
                                        <div class="clearfix">
                                            <!-- <div class="float-start mb-3">
                                                <img src="assets/images/logo-dark.png" alt="dark logo" height="22">
                                            </div> -->
                                            <div class="w-100" style="max-width:100%; padding: 0 24px;">
                                                <h4 class="m-0 d-print-none mb-3">Demo Request Form</h4>
                                                @if(isset($drfDatas))
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
                                                        @if($drfDatas->details && count($drfDatas->details))
                                                            <div class="row mb-2">
                                                                <div class="col-12 text-muted mb-1">Details:</div>
                                                                <div class="col-12">
                                                                    @foreach($drfDatas->details as $detail)
                                                                    
                                                                        <div class="border rounded p-2 mb-2 bg-white">
                                                                            <div class="row">
                                                                            @foreach($detail->getAttributes() as $key => $value)
                                                                                @if($key !== 'id' && $key !== 'demo_request_id' && $key !== 'created_at' && $key !== 'updated_at')
                                                                                    <div class="col-md-4 col-6 mb-1">
                                                                                        <span class="text-muted">{{ ucfirst(str_replace('_',' ',$key)) }}:</span>
                                                                                        <span class="fw-semibold">{{ $value }}</span>
                                                                                    </div>
                                                                                @endif
                                                                            @endforeach
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="row mb-2">
                                                                <div class="col-12 text-muted">No details available.</div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @else
                                                    <div class="mt-3 text-muted">No request data available.</div>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Invoice Detail-->
                                     
                      
                    </div>
                </div>
            </div>
          
        </div>
        @endsection
  </x-app-layout>