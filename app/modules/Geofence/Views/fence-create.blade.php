@extends('layouts.eclipse')
@section('title')
  Create Geofence
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
  <div class="page-wrapper_new">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Create Geofence</h4>
              
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
          <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
            <div class="row">
                <div class="col-lg-6 col-sm-11">
                  <div class="row">
                    <div class="col-lg-11 col-sm-10">
                      <div class="form-group has-feedback">
                        <label class="srequired">Name</label>
                          <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" id="name" value="" required> 
           
                      </div>
                      @if ($errors->has('name'))
                        <span class="help-block">
                            <strong class="error-text">{{ $errors->first('name') }}</strong>
                        </span>
                      @endif
                
                    </div>
                    <div class="col-lg-1 col-sm-1">
                        <span class="pull-right"><button id="savebutton" class="btn btn-success">SAVE FENCE</button></span>
                    </div>
                  </div>
                </div>
              </div>
          </div> 
          <div class="row">
            <div id="map" style=" width:100%;height:600px;"></div>
          </div> 
        </div>   
      </div>
    </div>
  </div>

</section>

@section('script')
  <script src="{{asset('js/gps/geofence.js')}}"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDl9Ioh5neacm3nsLzjFxatLh1ac86tNgE&libraries=drawing&callback=initMap"
         async defer></script>
@endsection
 @endsection