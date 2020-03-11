@extends('layouts.eclipse')
@section('content')
<div class="lorder-bg-playback" id="preloader">
  <div class="lds-dual-ring" id="status"></div>
</div>
  <input type="hidden" name="vehicle_id" id="vehicle_id" value="{{$vehicle_details->id}}">
  <input type="hidden" name="svg_icon" id="svg_icon" value="{{$vehicle_type_details->svg_icon}}">
  <input type="hidden" name="online_icon" id="online_icon" value="{{$vehicle_type_details->web_online_icon}}">
  <input type="hidden" name="offline_icon" id="offline_icon" value="{{$vehicle_type_details->web_offline_icon}}">
  <input type="hidden" name="ideal_icon" id="ideal_icon" value="{{$vehicle_type_details->web_idle_icon}}">
  <input type="hidden" name="sleep_icon" id="sleep_icon" value="{{$vehicle_type_details->web_sleep_icon}}">
  <input type="hidden" name="vehicle_scale" id="vehicle_scale" value="{{$vehicle_type_details->vehicle_scale}}">
  <input type="hidden" name="opacity" id="opacity" value="{{$vehicle_type_details->opacity}}">
  <input type="hidden" name="stroke_weight" id="stroke_weight" value="{{$vehicle_type_details->strokeWeight}}">
  <div class="dashboar-1-map-box">
    <div class="dasb-board-googlemap">
      <div class="wrapper overlay-sidebar">
        <div class="main-panel">
          <div class="content">
            <div id="markers" style="width:100%px;height:100vh; position: relative;"></div>
            <div class="page-inner mt--5"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="dash-baord-rt-new-box dash-baord-rt-new-box2">
      <div class="dash-2-vechile-detials-1 ">
        <div class="dash-board-2-head" id="user" style="text-transform: uppercase"></div>
        <div class="dash-vechile-detials-1-inner">
          <div class="dash-vechile-detials-1-inner-lf">
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
          <div class="dash-vechile-detials-1-inner-lf">
            <div class="dash-vechile-detials-img">
              <img src="../../assets/images/plate.png" width=30px height=25px>
            </div>
            <label id="vehicle_name" class="mgl"></label>
            <div class="dash-vechile-detail-text"><p class="dash-board-2-sleep" id="vehicle_name"></p></div>
          </div>
        </div>
        <div class="dash-vechile-main-2-inner">
          <div class="dash-board2-left">
            <div class="dash2-vechile-detials-img">
              <i class="fa fa-key fapad"></i>
            </div>
            <div class=" dashboard-2-details"><p>IGNITION</p>
              <span id="ignition"></span>
            </div>
          </div>
          <div class="dash-board2-rt">
            <div class="dash2-vechile-detials-img">
              <i class="fa fa-tachometer fapad"></i>
            </div>
            <div class="dashboard-2-details"><p>SPEED</p>
              <span id="car_speed"></span>
            </div>
          </div>
        </div>
        <div class="dash-vechile-main-2-inner">
          <div class="dash-board2-left">
            <div class="dash2-vechile-detials-img">
              <img src="../../assets/images/odo.png" class="fapad">
            </div>
            <div class="dashboard-2-details"><p>ODOMETER</p>
              <span id="odometer"></span>
            </div>
          </div>
          <div class="dash-board2-rt">
            <div class="dash2-vechile-detials-img">
              <i class="fa fa-battery-full fapad"></i>
            </div>
            <div class="dashboard-2-details"><p>BATTERY</p>
              <span id="car_battery"></span>
            </div>
          </div>
        </div>
        <div class="dash-vechile-main-2-inner ">
          <div class="dash-board2-left">
            <div class="dash2-vechile-detials-img">
              <i class="fa fa-plug fapad"></i>
            </div>
            <div class=" dashboard-2-details"><p>MAIN POWER</p>
              <span id="car_power"></span>
            </div>
          </div>
          <div class="dash-board2-rt">
            <div class="dash2-vechile-detials-img">
              <i class="fa fa-signal fapad"></i>
            </div>
            <div class="dashboard-2-details"><p>NETWORK</p>
              <span id="network_status"></span>
            </div>
          </div>
        </div>
        <div class="dash-vechile-main-2-inner mrg-bottom-0 last-bg-2">
          <div class="dash-board2-left">
            <div class="dash2-vechile-detials-img">
              <img src="../../assets/images/ac.png" class="fapad">
            </div>
            <div class=" dashboard-2-details"><p>AC</p>
              <span id="ac"></span>
            </div>
          </div>
          <div class="dash-board2-rt">
            <div class="dash2-vechile-detials-img">
              <img src="../../assets/images/fuel.png" class="fapad">
            </div>
            <div class=" dashboard-2-details"><p>FUEL</p>
              <span id="fuel"></span>
            </div>
          </div>
        </div>
      </div>
      <div class="location-sction">
        <div class="location-sction-icon"><img src="../../assets/images/marker.png" height="32px" width="24px"></div>
        <div class="location-sction-content" id="car_location"></div>
      </div>
      <?php
        $latitude = $latlong->latitude;
        $longitude = $latlong->longitude;
        $location_url=urlencode("https://www.google.com/maps/search/?api=1&query=".$latitude.",".$longitude);
      ?>
      @role('fundamental|superior|pro')
      <div class="social-icons-dashboard2">
        <div class="social-icons-2">
          <div class="social-icons-2inner">
            <a href="https://www.facebook.com/sharer.php?u={{$location_url}}" class="face-book-bg" target="_blank">
              <i class="fa fa-facebook" aria-hidden="true"></i>
            </a>
          </div>
        </div>
        <div class="social-icons-2">
          <div class="social-icons-2inner">
            <a href="https://twitter.com/share?url={{$location_url}}&text=Simple Share Buttons" class="twitter-bg" target="_blank">
              <i class="fa fa-twitter" aria-hidden="true"></i>
            </a>
          </div>
        </div>
        <div class="social-icons-2">
          <div class="social-icons-2inner">
            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{$location_url}}" class="linkding-bg" target="_blank">
              <i class="fa fa-linkedin" aria-hidden="true"></i>
            </a>
          </div>
        </div>
        <div class="social-icons-2">
          <div class="social-icons-2inner">
            <a href="mailto:?Subject=FrinMash&Body=I%20saw%20this%20and%20thought%20of%20you!%20 {{$location_url}}" class="emailbg" target="_blank">
              <i class="fa fa-envelope-o" aria-hidden="true"></i>
            </a>
          </div>
        </div>
        <div class="social-icons-2 border-0">
          <div class="social-icons-2inner">
            <a href="https://web.whatsapp.com/send?text={{$location_url}}" class="whatsup-bg" target="_blank">
              <i class="fa fa-whatsapp" aria-hidden="true"></i>
            </a>
          </div>
        </div>
      </div>
      @endrole
    </div>
  </div>
@endsection
@section('script')
  <script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-core.js"></script>
  <script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-service.js"></script>
  <script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-ui.js"></script>
  <script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-mapevents.js"></script>
  <link rel="stylesheet" type="text/css"
      href="https://js.hereapi.cn/v3/3.0/mapsjs-ui.css" />
  <link rel="stylesheet" href="{{asset('css/firebaselivetrack-new-css.css')}}" type="text/css">
  <script src="{{asset('js/gps/location-track-firebase-hmap.js')}}"></script>
@endsection