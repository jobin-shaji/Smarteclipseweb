  @extends('layouts.eclipse')

@section('content')
<section class="content box">
<div class="page-wrapper_new_map">
  <!-- <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Live Track</li>
   </ol>
    @if(Session::has('message'))
      <div class="pad margin no-print">
         <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
            {{ Session::get('message') }}  
         </div>
      </div>
      @endif  
  </nav> -->

  <form id="playback_form">
    <input type="hidden" name="gps_id" id="gps_id" value="{{$gps_id}}">
    <div class="cover_playback" style="width:33%;">
      <div class="row">
        <div class="col-lg-4 col-md-3">
          <div class="form-group">
             <label> From Date</label>
             <input type="text" class="datetimepicker form-control" id="fromDate" name="fromDate">
          </div>
        </div>
        <div class="col-lg-4 col-md-3">
          <div class="form-group">                   
             <label> To date</label>
              <input type="text" class="datetimepicker form-control" id="toDate" name="toDate">
          </div>
        </div>

        <div class="col-lg-3 col-md-3 pt-2 ">
          <div class="form-group"> 
             <button type="submit" class="btn btn-sm btn-info form-control btn-play-back" > <i class="fa fa-filter" style="height:23px;"></i>Playback </button>
          </div>
        </div>
      </div>
    </div>
  </form>
  <div class="col-lg-12 col-sm-12">
    <input type="hidden" name="vid" id="vehicle_id_data" value="{{$gps_id}}">
    <input type="hidden" name="vehicle_id" id="vehicle_id" value="{{$gps_id}}">
    <input type="hidden" name="svg_con" id="svg_con" value="{{$vehicle_type->svg_icon}}">
    <input type="hidden" name="vehicle_scale" id="vehicle_scale" value="{{$vehicle_type->vehicle_scale}}">
    <input type="hidden" name="opacity" id="opacity" value="{{$vehicle_type->opacity}}">
    <input type="hidden" name="strokeWeight" id="strokeWeight" value="{{$vehicle_type->strokeWeight}}">
    <input type="hidden" name="lat" id="lat" value="{{$latitude}}">
    <input type="hidden" name="lng" id="lng" value="{{$longitude}}">                      
    <div class="card data_list_cover pull-right" style="width: 16rem;" id="lost_blink_id">
      <div class="card-body data_list_body">
        <h5 class="card-title" id="gps_imei"></h5>
        <p>
        <b>
        </b></p>
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
              <i class="fa fa-circle" style="color:#c41900;" aria-hidden="true"></i> Offline: Last seen <span id="last_seen"></span>
            </span>
            <span id="connection_lost" style="display: none;font-size: 13px;">
              Connection lost: <span id="connection_lost_last_seen"></span>
            </span>
          </div>
          <div class="col-sm-12 social-buttons">
            <a class="btn btn-block btn-social btn-bitbucket track_item">
              <i class="fa fa-key fapad"></i> <b class="mgl">IGNITION <b style="margin-left: 11%;font-size: 11px;">: <label class="mgl" id="ignition"></label></b></b>
            </a>
            <a class="btn btn-block btn-social btn-bitbucket track_item">
              <i class="fa fa-tachometer fapad"></i> <b class="mgl">SPEED <b style="margin-left: 19%;font-size: 11px;">: <label class="mgl" id="car_speed"></label> <span id="valid_speed">km/h </span></b></b>
            </a>
            <a class="btn btn-block btn-social btn-bitbucket track_item">
              <i class="fa fa-battery-full fapad"></i><b class="mgl">BATTERY <b style="margin-left: 12.4%;font-size: 11px;">: <label class="mgl" id="car_bettary"></label> %</b></b>
            </a>
            <a class="btn btn-block btn-social btn-bitbucket track_item">
              <i class="fa fa-plug fapad"></i><b class="mgl"> MAIN POWER <b style="margin-left: 1%;font-size: 11px;">: <label class="mgl" id="car_power"></label></b></b>
            </a> 
            <a class=" btn btn-block btn-social btn-bitbucket track_item" id="lost_blink_id1">
              <i class="fa fa-signal fapad"></i><b class="mgl"> NETWORK <b style="margin-left: 9%;font-size: 11px;">: <label class="mgl" id="network_status"></label></b></b>
            </a>   
            <a class="btn btn-block btn-social btn-bitbucket track_item">
              <img src="../../assets/images/ac.png" height="25px" width="30px" class="fapad"> <b class="mgl">AC <b style="margin-left: 27%;font-size: 11px;">: <label class="mgl" id="ac"></label></b></b>
            </a>
            <a class="btn btn-block btn-social btn-bitbucket track_item">
              <img src="../../assets/images/fuel.png" height="25px" width="30px" class="fapad"><b class="mgl">FUEL <b style="margin-left: 22.5%;font-size: 11px;">: <label class="mgl" id="fuel"></label> </b></b>
            </a>                                                  
            <div class="viewmore_location">
              <i class="fa fa-map-marker"></i><b><span id="car_location" style="font-size: .7rem!important"></span></b>
            </div>

            <hr>
            <?php
            $location_url=urlencode("https://www.google.com/maps/search/?api=1&query=".$latitude.",".$longitude);
            ?>
          </div>
          </b>
        </div>
      </div>
    </div>
    
    <div class="cover_poi">
      <div class="poi_atm poi_item">
        <a href="#" id="poi_atm">
          <img src="{{ url('/') }}/images/ATM.png">
        </a>
      </div>
      <div class="poi_petrol poi_item">
        <a href="#" id="poi_petrol">
          <img src="{{ url('/') }}/images/pump.png">
        </a>
      </div>
      <div class="poi_hopital poi_item">
        <a href="#" id="poi_hopital">
          <img src="{{ url('/') }}/images/hospital.png">
        </a>
      </div>
    </div>

    <div id="map" class="live_track_map" style="width:100%;height:500px;"></div>
  </div>
    </div>

  </div>
</section>

@section('script')
<link rel="stylesheet" type="text/css" href="{{asset('css/odometer.css')}}">
<script src="{{asset('js/gps/gps-location-track.js')}}"></script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDl9Ioh5neacm3nsLzjFxatLh1ac86tNgE&libraries=drawing&libraries=places&callback=initMap" async defer></script>

@endsection

@endsection