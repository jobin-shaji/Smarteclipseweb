@extends('layouts.eclipse')
@section('title')
  Device  Return Details
@endsection
@section('content')    
<section class="hilite-content">
  <div class="page-wrapper_new">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Device Return Details</li>
       <b> Device Return Details View</b>
       </ol>
      @if(Session::has('message'))
        <div class="pad margin no-print">
          <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
                {{ Session::get('message') }}  
          </div>
        </div>
      @endif  
    </nav>        
    <div class="container-fluid">
      <div class="card" style="margin:0 0 0 1%">
        <div class="card-body wizard-content">
        <div class="box-body">
              <ul class="list-group">
              <li class="list-group-item">
                  <b>Servicer:</b> {{ $device_return_details->servicer->name}}
                </li>
                <li class="list-group-item">
                  <b>IMEI:</b> {{ $device_return_details->gps->imei}}
                </li>
                <li class="list-group-item">
                  <b>Serial Number:</b> {{ $device_return_details->gps->serial_no}}
                </li>
               
                <li class="list-group-item">
                  <b>Type of Issues:</b> 
                  @if($device_return_details->type_of_issues==0) 
                 {{'Hardware'}}
                 @endif
                 @if($device_return_details->type_of_issues==1) 
                 {{'Software'}}
                 @endif
                 </li>
                 <li class="list-group-item">
                  <b>Comments:</b> {{ $device_return_details->comments}}
                </li>
                <li class="list-group-item">
                  <b>Date:</b> {{ $device_return_details->created_at}}
                </li>
                 <li class="list-group-item">
                  <b>Status:</b> 
                  @if($device_return_details->status==0)
                     {{'Submitted'}}               
                  @elseif($device_return_details->status==1)
                     {{'Cancelled'}}                
                  @elseif($device_return_details->status==2)
                     {{'Accepted'}}
                  @endif
                </li>
            </ul>
            </div>
            <br>
            <div class="row">
        
        <div class="col-md-6 ">
        @if($device_return_details->status==0)
          <button  onclick=acceptDeviceReturn({{$device_return_details->id}}) class="btn btn-md"><i class='glyphicon glyphicon-remove'></i> Accept
                    </button>
                    @endif       
                </a>
        </div>
        <!-- /.col -->
      </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@section('script')
 @role('root')
    <script src="{{asset('js/gps/device-return-root-history-list.js')}}"></script>
  @endrole
  
@endsection
 @endsection