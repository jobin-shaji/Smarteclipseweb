@extends('layouts.eclipse')
@section('content')
<section class="content box">
  <div class="page-wrapper_new_map">
    <div class="col-lg-12 col-sm-12">
      <input type="hidden" name="vehicle_id" id="vehicle_id" value="{{$vehicle_details->id}}">
      <input type="hidden" name="svg_icon" id="svg_icon" value="{{$vehicle_type_details->svg_icon}}">
      <input type="hidden" name="vehicle_scale" id="vehicle_scale" value="{{$vehicle_type_details->vehicle_scale}}">
      <input type="hidden" name="opacity" id="opacity" value="{{$vehicle_type_details->opacity}}">
      <input type="hidden" name="stroke_weight" id="stroke_weight" value="{{$vehicle_type_details->strokeWeight}}">
      <div class="card data_list_cover pull-right" style="width: 16rem" id="lost_blink_id">
        <div class="card-body data_list_body " >
          <p class="capitalize"><h2 class="card-title" id="user" style="font-size:20px!important;text-transform: uppercase;"></h2></p>
          <div class="cover_ofline"><b>
            <div class="cover_status" style="text-align: center;"> 
              <span id="online" style="display: none;">
                <i class="fa fa-circle" style="color:#84b752;" aria-hidden="true"></i> Moving<span id="zero_speed"></span>
              </span>
              <span id="zero_speed_online" style="display: none;">
                <i class="fa fa-circle" style="color:#84b752;" aria-hidden="true"></i> Vehicle stopped
              </span>
              <span id="halt" style="display: none;">
                <i class="fa fa-circle" style="color:#69b4b9;" aria-hidden="true"></i> Halt
              </span>
              <span id="sleep" style="display: none;">
                <i class="fa fa-circle" style="color:#858585;" aria-hidden="true"></i> Sleep
              </span>
              <span id="offline" style="display: none;font-size: 13px;">
                <i class="fa fa-circle" style="color:#c41900;" aria-hidden="true"></i> Offline</br> Last seen: <span id="last_seen"></span>
              </span>
              <span id="connection_lost" style="display: none;font-size: 13px;">
                Device connection lost: <span id="connection_lost_last_seen"></span>
              </span>
            </div>
            <div class="col-sm-12 social-buttons" style="margin-left: 3%!important;">
              <a class="btn btn-block btn-social btn-bitbucket track_item" style="cursor:auto!important">
                <img src="../../assets/images/plate.png" width=30px height=25px><label id="vehicle_name" class="mgl"></label>
              </a>
              <a class="btn btn-block btn-social btn-bitbucket track_item" style="cursor:auto!important">
                <i class="fa fa-key fapad"></i> <b class="mgl">IGNITION <b style="margin-left: 11.5%;font-size: 11px;">: <label class="mgl" id="ignition"></label></b></b>
              </a>
              <a class="btn btn-block btn-social btn-bitbucket track_item" style="cursor:auto!important">
                <i class="fa fa-tachometer fapad"></i> <b class="mgl">SPEED <b style="margin-left: 17.8%;font-size: 11px;">: <label class="mgl" id="car_speed"></label> <span id="valid_speed">km/h </span></b></b>
              </a>
              <a class="btn btn-block btn-social btn-bitbucket track_item" style="cursor:auto!important">
                <img src="../../assets/images/odo.png" height="30px" width="30px" class="fapad"><b class="mgl">ODOMETER<b style="margin-left: 8.2%;font-size: 11px;">: <label class="mgl" id="odo"></label> <span id="odometer"> </span></b></b>
              </a>
              <a class="btn btn-block btn-social btn-bitbucket track_item" style="cursor:auto!important">
                <i class="fa fa-battery-full fapad"></i><b class="mgl">BATTERY <b style="margin-left: 11.4%;font-size: 11px;">: <label class="mgl" id="car_battery"></label> %</b></b>
              </a>
              <a class="btn btn-block btn-social btn-bitbucket track_item" style="cursor:auto!important">
                <i class="fa fa-plug fapad"></i><b class="mgl"> MAIN POWER <b style="margin-left: 2%;font-size: 11px;">: <label class="mgl" id="car_power"></label></b></b>
              </a> 
              <a class=" btn btn-block btn-social btn-bitbucket track_item" id="lost_blink_id1" style="cursor:auto!important">
                <i class="fa fa-signal fapad"></i><b class="mgl"> NETWORK <b style="margin-left: 10%;font-size: 11px;">: <label class="mgl" id="network_status"></label></b></b>
              </a> 
              <a class="btn btn-block btn-social btn-bitbucket track_item" style="cursor:auto!important">
                <img src="../../assets/images/ac.png" height="25px" width="30px" class="fapad"> <b class="mgl">AC <b style="margin-left: 27%;font-size: 11px;">: <label class="mgl" id="ac"></label></b></b>
              </a>
              <a class="btn btn-block btn-social btn-bitbucket track_item" style="cursor:auto!important">
                <img src="../../assets/images/fuel.png" height="25px" width="30px" class="fapad"><b class="mgl">FUEL <b style="margin-left: 23.5%;font-size: 11px;">: <label class="mgl" id="fuel"></label> </b></b>
              </a>                                                    
              <div class="viewmore_location">
                <div>
                  <div style="float: left;padding: 3% 5% 8% 3%;"><img src="../../assets/images/marker.png" height="32px" width="24px"> <!-- <i class="fa fa-map-marker"></i> --></div>
                  <div id="car_location" style="font-size: .7rem!important;padding: 109% 8% 4% 19%;"></div>
                </div>
              </div>
            </div>
            </b>
          </div>
        </div>
      </div>
      <div id="map" style="width:100%;height:85vh;"></div>
    </div>
  </div>
</section>


@section('script')
<link rel="stylesheet" type="text/css" href="{{asset('css/odometer.css')}}">

<script src="https://maps.googleapis.com/maps/api/js?key={{config('eclipse.keys.googleMap')}}&libraries=drawing,geometry,places"></script>

<script src="{{asset('js/gps/location-track-firebase.js')}}"></script>
<script src="{{asset('js/gps_animation/jquery.easing.1.3.js')}}"></script>
<script src="{{asset('js/gps_animation/markerAnimate.js')}}"></script>
<script src="{{asset('js/gps_animation/SlidingMarker.js')}}"></script>
@endsection

@endsection

