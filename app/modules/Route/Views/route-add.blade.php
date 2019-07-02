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
  <div class="page-wrapper_new">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Create Route</h4>
              
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
           <form method="POST" action="{{route('route.create.p')}}" onSubmit="return checkRouteValue();">
                {{csrf_field()}}
            <div class="row">
                <div class="col-lg-6 col-sm-11">
                  <div class="row">
                    <div class="col-lg-10 col-sm-10">
                      <div class="form-group has-feedback">
                        <label class="srequired">Route Name</label>
                        <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Route Name" name="name" value="{{ old('name') }}" required> 
                      </div>
                      @if ($errors->has('name'))
                        <span class="help-block">
                            <strong class="error-text">{{ $errors->first('name') }}</strong>
                        </span>
                      @endif
                        <input type="hidden" class="form-control" name="points" id="locationLatLng" value="" required>
                    </div>
                    <div class="col-lg-1 col-sm-1">
                        <span class="pull-right"><button type="submit"  class="btn btn-primary btn-flat" name="submit" style="margin-top: 25px;">Submit</button></span>
                    </div>
                    <div class="col-lg-1 col-sm-1">
                        <span class=""><button type="button" onclick='clearlastdraw()'  class="btn btn-primary btn-flat" name="reset" style="margin-top: 25px;">Undo</button></span>
                    </div>
                  </div>
                </div>
                
              </div>
            </form>

          </div> 
          <div class="row">
            <div id="map" style=" width:100%;height:600px;"></div>
          </div> 
        </div>   
      </div>
    </div>
     <footer class="footer text-center">
    All Rights Reserved by VST Mobility Solutions. Designed and Developed by <a href="http://vstmobility.com">VST</a>.
  </footer>
  </div>

</section>

@section('script')
  <script src="{{asset('js/gps/route-map.js')}}"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDl9Ioh5neacm3nsLzjFxatLh1ac86tNgE&libraries=drawing&callback=initMap"
       async defer></script>
@endsection
 @endsection