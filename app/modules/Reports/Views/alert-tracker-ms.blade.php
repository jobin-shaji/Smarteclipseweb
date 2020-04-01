@extends('layouts.eclipse')
@section('title')
  Create Route
@endsection
@section('content')   
    @if(Session::has('message'))
    <div class="pad margin no-print">
      <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
          {{ Session::get('message') }}  
      </div>
    </div>
    @endif  
<input type="hidden" value="{{$ms_alert_id}}" id="ms_alert_id">
<section class="hilite-content">
  <div class="page-wrapper_new">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <b> Alert View</b>
                @if(Session::has('message'))
                <div class="pad margin no-print">
                  <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
                      {{ Session::get('message') }}  
                  </div>
                </div>
                @endif 
            </div>
        </div>
    </div>
           
    <div class="container-fluid">
      <div class="card-body">
        <div class="table-responsive">
          <div class="row">
            <div id="tracker-map" style=" width:100%;height:600px;"></div>
          </div> 
        </div>   
      </div>
    </div>
  </div>
</section>
@section('script')
    <script src="{{asset('js/gps/alert-report-ms.js')}}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDl9Ioh5neacm3nsLzjFxatLh1ac86tNgE&libraries=drawing&callback=getAlertFromMicroService"
         async defer></script>
    @endsection
 @endsection