@extends('layouts.eclipse')
@section('content')
<section class="content box">
<div class="page-wrapper_new_map">

<!--   <nav aria-label="breadcrumb">
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
        </nav>
   -->




  <!-- <form id="playback_form">
    <input type="hidden" name="vehicle_id" id="vehicle_id" value="{{$Vehicle_id}}">
    <div class="cover_playback" style="width:43%;">
        <div class="row">
          <div class="col-lg-4 col-md-3">
            <div class="form-group">
               <label> From Date</label>
               <input type="text" class="datetimepicker form-control" id="fromDate" name="fromDate" autocomplete="off" required>
            </div>
          </div>
          <div class="col-lg-4 col-md-3">
            <div class="form-group">                   
               <label> To Date</label>
                <input type="text" class="datetimepicker form-control" id="toDate" name="toDate" autocomplete="off" required>
            </div>
          </div>
          <div class="col-lg-3 col-md-3 pt-2 ">
            <div class="form-group" style="margin:5% 0 0 15%!important"> 
               <button type="submit" class="btn btn-sm btn-info form-control btn-play-back" > <span style="color:#000"><i class="fa fa-filter"></i>Playback</span> </button>                               
            </div>
          </div>

        </div>
    </div>
  </form> -->

  <div class="col-lg-12 col-sm-12">
    <input type="hidden" name="vid" id="vehicle_id_data" value="{{$Vehicle_id}}">
    <input type="hidden" name="svg_con" id="svg_con" value="{{$vehicle_type->svg_icon}}">
    <input type="hidden" name="vehicle_scale" id="vehicle_scale" value="{{$vehicle_type->vehicle_scale}}">
    <input type="hidden" name="opacity" id="opacity" value="{{$vehicle_type->opacity}}">
    <input type="hidden" name="strokeWeight" id="strokeWeight" value="{{$vehicle_type->strokeWeight}}">
    <input type="hidden" name="lat" id="lat" value="{{$latitude}}">
    <input type="hidden" name="lng" id="lng" value="{{$longitude}}">
                      
    <div class="card data_list_cover pull-right" style="width: 16rem;">
      <div class="card-body data_list_body " >
        <p class="capitalize"><h2 class="card-title" id="user" style="font-size:20px!important;text-transform: uppercase;"></h2></p>
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
              <i class="fa fa-circle" style="color:#c41900;" aria-hidden="true"></i> Last seen <span id="last_seen"></span>
            </span>
          </div>
          <div class="col-sm-12 social-buttons">
            <a class="btn btn-block btn-social btn-bitbucket track_item">
              <i class="fa fa-car"></i><label id="vehicle_name" class="mgl"></label>
            </a>
            <a class="btn btn-block btn-social btn-bitbucket track_item">
              <i class="fa fa-key"></i> <b class="mgl">IGNITION <b style="margin-left: 11%">: <label class="mgl" id="ignition"></label></b></b>
            </a>
            <a class="btn btn-block btn-social btn-bitbucket track_item">
              <i class="fa fa-tachometer"></i> <b class="mgl">SPEED <b style="margin-left: 17.5%">: <label class="mgl" id="car_speed"></label> <span id="valid_speed">km/h </span></b></b>
            </a>
            <a class="btn btn-block btn-social btn-bitbucket track_item">
              <i class="fa fa-battery-full"></i><b class="mgl">BATTERY <b style="margin-left: 10.7%">: <label class="mgl" id="car_bettary"></label> %</b></b>
            </a>
            <a class="btn btn-block btn-social btn-bitbucket track_item">
              <i class="fa fa-plug"></i><b class="mgl"> MAIN POWER <b style="margin-left: 1%">: <label class="mgl" id="car_power"></label></b></b>
            </a> 
            <a class="btn btn-block btn-social btn-bitbucket track_item">
              <i class="fa fa-signal"></i><b class="mgl"> NETWORK <b style="margin-left: 8.7%">: <label class="mgl" id="network_status"></label></b></b>
            </a> 
            <!-- <a class="btn btn-block btn-social btn-bitbucket track_item">
              <i><image src="/assets/images/moving-b.png" width="18" height="18"></i><b><label id="car_bettary">MOVING TIME : </label></b>
            </a>
            <a class="btn btn-block btn-social btn-bitbucket track_item">
              <i><image src="/assets/images/stop1-b.png" width="22" height="20"></i><b><label id="car_bettary">STOP TIME : </label></b>
            </a>
            <a class="btn btn-block btn-social btn-bitbucket track_item">
              <i><image src="/assets/images/halt-b.png" width="18" height="18"></i><b><label id="car_bettary">HALT TIME :</label></b>
            </a>
            <a class="btn btn-block btn-social btn-bitbucket track_item">
              <i><image src="/assets/images/sleep-b.png" width="16" height="16"></i><b><label id="car_bettary">SLEEP TIME : </label></b> -->
            </a>                                                      
            <div class="viewmore_location">
              <div>
                <div style="float: left;padding: 10% 5% 8% 3%;"><img src="../../assets/images/marker.png" height="32px" width="24px"> <!-- <i class="fa fa-map-marker"></i> --></div>
                <div id="car_location" style="font-size: .7rem!important;padding: 73% 8% 4% 19%;"></div>
            </div>
            </div>
            <!-- <div id="odometer" class="odometer" style="margin-left: 80px">000000</div> -->
          </div>
            <hr>
            <?php
            $location_url=urlencode("https://www.google.com/maps/search/?api=1&query=".$latitude.",".$longitude);
            ?>

            @role('fundamental|superior|pro')
              <div class="share_button">
                <!--These buttons are created by frinmash.blogspot.com,frinton madtha--> <div id="share-buttons"> <!-- Facebook --> <a target="_blank" href="https://www.facebook.com/sharer.php?u={{$location_url}}" target="_blank"><img src="{{ url('/') }}/share-icons/facebook.png" alt="Facebook" /></a> <!-- Twitter --> <a target="_blank" href="https://twitter.com/share?url={{$location_url}}&text=Simple Share Buttons" target="_blank"><img src="{{ url('/') }}/share-icons/twitter.png" alt="Twitter" /></a>
                <!-- LinkedIn --> <a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url={{$location_url}}" target="_blank"><img src="{{ url('/') }}/share-icons/linkedin.png" alt="LinkedIn" /></a> 
                <a target="_blank" href="mailto:?Subject=FrinMash&Body=I%20saw%20this%20and%20thought%20of%20you!%20 {{$location_url}}"><img src="{{ url('/') }}/share-icons/email.png" alt="Email" /></a>
                <!-- watsapp -->
                <a target="_blank" href="https://web.whatsapp.com/send?text={{$location_url}}" data-action="share/whatsapp/share"><img src="{{ url('/') }}/share-icons/whatsapp.png" alt="Email" /></a>
                </div>
              </div>
            @endrole
          </div>
        </b>
        </div>
      </div>
    </div>

    <div class="cover_poi">
      <div  class="poi_atm poi_item">
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
      <div class="poi_item">
        <!-- <a href="#">
          <img src="{{ url('/') }}/images/playback.png" width="64px" height="64px" onclick="pbk()"> -->
        <a href="{{url('/vehicles/'.Crypt::encrypt($Vehicle_id).'/playback-page')}}">
          <img src="{{ url('/') }}/images/playback.png" width="64px" height="64px">
        </a>
      </div>
    </div>

    <div id="map" class="live_track_map" style="width:100%;height:85vh;"></div>
    </div>
  </div>
  </div>
</section>

@section('script')
<link rel="stylesheet" type="text/css" href="{{asset('css/odometer.css')}}">
<style type="text/css">
#pbk{
width:100%;
height:45px;
border-radius:10px;
background-color:#cd853f;
color:#fff;
font-family:'Raleway',sans-serif;
font-size:18px;
cursor:pointer
}
</style>
<!-- <script src="{{asset('js/odometer.js')}}"></script> -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDl9Ioh5neacm3nsLzjFxatLh1ac86tNgE&libraries=drawing,geometry,places"></script>

<script src="{{asset('js/gps/location-track.js')}}"></script>
<script src="{{asset('js/gps_animation/jquery.easing.1.3.js')}}"></script>
<script src="{{asset('js/gps_animation/markerAnimate.js')}}"></script>
<script src="{{asset('js/gps_animation/SlidingMarker.js')}}"></script>














@endsection

@endsection

<!--  <script src="{{asset('js/bootstrap-datetimepicker.js')}}"></script> -->
