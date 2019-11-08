@extends('layouts.eclipse')
@section('content')
<section class="content box">
  <div class="page-wrapper_new_map">
    <div class="panel-heading">
      <div class="cover_div_search">
        <div class="row">
          <div class="col-lg-2 col-md-2"> 
            <div class="form-group">                      
              <label> From Date</label>
              <input type="text" class="datetimepicker form-control" id="from_date" name="from_date">
            </div>
          </div>
          <div class="col-lg-2 col-md-2"> 
            <div class="form-group">                     
              <label> To Date</label>
              <input type="text" class="datetimepicker form-control" id="to_date" name="to_date">
              <input type="hidden" class="form-control" id="gps_id" name="gps_id" value="{{$gps->id}}">
            </div>
          </div>
          <div class="col-lg-3 col-md-3 pt-5">  
            <div class="form-group">          
              <button class="btn btn-sm btn-info btn2 form-control" onclick="mapCheck()"> Search </button>
            </div>
          </div>                     
        </div>
      </div>
    </div>

  <div id="map" style="width:100%;height:500px;"></div>
  </div>
</section>

@section('script')
<script src="{{asset('js/gps/map-location-track.js')}}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDl9Ioh5neacm3nsLzjFxatLh1ac86tNgE&libraries=drawing&libraries=geometry,places&callback=initMap" async defer></script>


@endsection

@endsection

