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
  <div class="page-wrapper_new_map">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
    <div class="page-breadcrumb page-breadcrumb1 route_breadcumb">
        <div class="row">
             <form method="POST" action="{{route('route.create.p')}}" onSubmit="return checkRouteValue();" style="    width: 100%;">
         {{csrf_field()}}
            <div class="col-12 d-flex no-block align-items-center">
              
                <div class="col-lg-5">
                  <form method="POST" action="{{route('route.create.p')}}" onSubmit="return checkRouteValue();">
                     <div class="col-lg-8 col-md-12">
                   <div class="form-group has-feedback">
                        <!-- <label class="srequired">Route Name</label> -->
                        <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Add route name" name="name" value="{{ old('name') }}" required> 
                      </div>
                      @if ($errors->has('name'))
                        <span class="help-block">
                            <strong class="error-text">{{ $errors->first('name') }}</strong>
                        </span>
                  @endif
                  <input type="hidden" class="form-control" name="points" id="locationLatLng" value="" required>
               </div>
               <div class="col-lg-4 col-sm-12 cover_search_button_route">
                       <button type="submit"  class="btn btn-primary btn-flat save_button_route" name="submit">Save Route</button>
                       <button type="button" onclick='clearlastdraw()'  class="btn btn-primary btn-flat cbtn_undo" title="Clear the points in map" name="reset">Undo</button>
                    </div>
                  </form>

                </div>
                    <form onsubmit="return locationSearch();">

                <div class="col-lg-4">
                         <div class="col-lg-8 col-md-12">
                   <div class="form-group has-feedback">
                        <!-- <label class="srequired">Place Name</label> -->
                         <input type="text" class="form-control" placeholder="Search Place" name="place_name" id="search_place" value="" required>
                      </div>
                      
                  <input type="hidden" class="form-control" name="points" id="locationLatLng" value="" required>
               </div>
               <div class="col-lg-4 col-sm-12 cover_search_button_route">
                   <button type="submit"  class="btn btn-primary btn-flat save_button_route" id="place_location" name="submit">search</button>
                      
                </div>

                   

                </div>
                 </form>
              <div class="col-lg-3">
                <h4 class="page-title" style="text-align: right;">Create Route</h4>
               </div>
            </div>
        </div>
    </div>


         <div id="map" style=" width:100%;height:540px;"></div>
      </div>


</section>

@section('script')
  <script src="{{asset('js/gps/route-map.js')}}"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDl9Ioh5neacm3nsLzjFxatLh1ac86tNgE&libraries=drawing,places&callback=initMap"
       async defer></script>
@endsection
 @endsection