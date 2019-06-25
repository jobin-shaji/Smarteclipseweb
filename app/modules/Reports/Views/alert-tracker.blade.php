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

<section class="hilite-content">
      <!-- title row -->
  <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title"> Alert View</h4>
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
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
    <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
      <div class="card-body">
        <div class="table-responsive">
            <input type="hidden" name="hd_id" id="hd_id" value="{{$alert_id}}">
    <input type="hidden" name="lat" id="lat" value="{{$alertmap->latitude}}">
    <input type="hidden" name="lng" id="lng" value="{{$alertmap->longitude}}">
    <input type="hidden" name="icon" id="icon" value="{{$alert_icon->path}}">
    <input type="hidden" name="alert" id="alert" value="{{$alert_icon->description}}">
    <input type="hidden" name="vehicle" id="vehicle" value="{{$get_vehicle->register_number}}">
          <div class="row">
            <div id="map" style=" width:100%;height:600px;"></div>
          </div> 
        </div>   
      </div>
    </div>
  </div>
</section>
@section('script')
    <script src="{{asset('js/gps/alert-track.js')}}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDl9Ioh5neacm3nsLzjFxatLh1ac86tNgE&libraries=drawing&callback=initMap"
         async defer></script>
    @endsection
 @endsection