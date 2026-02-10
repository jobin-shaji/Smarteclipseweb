@extends('layouts.eclipse')
@section('content')

<!--  -->
<!-- ROOT ROLE-START -->
@role('root')
@include('Dashboard::dash-root')
@endrole
<!-- ROOT ROLE-END -->

<!-- DEALER ROLE-START -->
@role('dealer')
@include('Dashboard::dash-dealer')
@endrole
<!-- DEALER ROLE-END -->
<!-- DEALER ROLE-START -->
@role('operations')
@include('Dashboard::dash-operations')
@endrole
<!-- SUB DEALER ROLE-START -->
@role('sub_dealer')
@include('Dashboard::dash-sub-dealer')
@endrole
<!-- SUB DEALER ROLE-END -->

<!-- TRADER ROLE-START -->
@role('trader')
@include('Dashboard::dash-trader')
@endrole
<!-- TRADER ROLE-END -->

<!-- SERVICER ROLE-START -->
@role('servicer')
@include('Dashboard::dash-servicer')
@endrole
<!-- SERVICER ROLE-END -->

<style>
  #more {display: none;}
  </style>
@role('Finance')
@include('Dashboard::dash-finance')
@endrole

<!-- SCHOOL ROLE-START -->
<!--
@role('school')


<div class="container-fluid">
   <div class="row">
    <div class="col-md-12 full-height">
      <div id="map" style="width:100%; height:100%;"></div>
    </div>
    <div class="pageContainer" style="overflow: scroll">
      <div class="col-lg-12">
        <div class="st-actionContainer right-bottom">
          <div class="st-panel" style="overflow: scroll!important;">
           
            <div class="st-panel-contents" id="vehicle_card_cover">
              @foreach ($vehicles as $vehicle)

              <div class="border-card">
                <div class="card-type-icon with-border">
                  <input type="radio" id="radio" id="gpsid{{ $loop->iteration }}" class="vehicle_gps_id" name="radio" onclick="getVehicle({{$vehicle->gps_id}})" value="{{$vehicle->gps_id}}">
                </div>
                <div class="content-wrapper">
                  <div class="label-group fixed">
                    <p class="title">
                      <span><i class="fa fa-car"></i></span>
                    </p>
                    <p class="caption" id="vehicle_name{{ $loop->iteration }}">{{$vehicle->name}}</p>
                  </div>
                  <div class="min-gap"></div>
                  <div class="label-group">
                    <p class="title">
                      <span><i class="fas fa-arrow-alt-circle-left"></i></span>
                    </p>
                    <p class="caption" id="register_number{{ $loop->iteration }}">{{$vehicle->register_number}}</p>
                  </div>
                  <div class="min-gap"></div>

                </div>
              </div>
              @endforeach
            </div>
          </div>
          <div class="right-bottom">
            <div class="st-button-main">
              <img class="left-bottom-car-details-img" src="assets/images/stearing.png" width="66px">
            </div>
          </div>

          @role('fundamental|superior|pro|school')
          <div class="right-bottom2">
            <form onsubmit="return locationSearch();">
              <div class="col-lg-12 col-md-12">
                <div class="container-fluid bg-light map_search">
                  <div class="row align-items-center justify-content-center">
                    <div class="col-lg-4 col-md-4 ">
                      <div class="form-group">
                        <input type="text" id="search_place" class="form-control" value="">
                      </div>
                    </div>
                    <div class="col-lg-4 col-md-4 ">
                      <div class="form-group">
                        <select id="search_radius" class="form-control">
                          <option selected>KM</option>
                          <option value="10">10 KM</option>
                          <option value="30">30 KM</option>
                          <option value="50">50 KM</option>
                          <option value="75">75 KM</option>
                          <option value="100">100 KM</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-2 col-md-2 ">
                      <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>

                  </div>
                </div>
              </div>
            </form>
          </div>

          <div id="myModal" class="modal_for_dash">
           
            <div class="modal-content">
              <div class="modal-header">
                <span class="close"></span>
                <div class="container">
                  <div class="container">
                    <canvas id="myChart" style="max-width: 500px;"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>
          @endrole


        </div>
      </div>
    </div>
    <div class="dashboard-main-Right cover_vehicle_track_list">
      <div class="iconsbg1234">
        <div class="col-md-6 col-lg-2 col-xlg-3 cover_track_data" onclick="moving('M')">
          <div class="card card-hover">
            <div class="box bg-cyan1234 text-center">
              <h1 class="font-light text-white"></h1>
              <h1 class="text-white" style="color:#84b752!important">
                
                <i class="fa fa-map-marker" aria-hidden="true"></i>
              </h1>
              <span class="track_status">Moving</span>
              <span style="float:left;width:100%">
                <h1 id="moving" class="text-white" style="font-size:19px;color:#fab03a!important">0</h1>
                
              </span>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-2 col-xlg-3 cover_track_data" onclick="moving('H')">
          <div class="card card-hover">
            <div class="box bg-cyan1234 text-center">
              <h1 class="font-light text-white"></h1>
              <h1 class="text-white" style="color: #69b4b9!important">
               
                <i class="fa fa-map-marker" aria-hidden="true"></i>
              </h1>
              <span class="track_status">Halt</span>
              <span style="float:left;width:100%">
                <h1 id="idle" class="text-white" style="font-size:19px;color:#fab03a!important">0</h1>
                
              </span>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-2 col-xlg-3 cover_track_data" onclick="moving('S')">
          <div class="card card-hover">
            <div class="box bg-cyan1234 text-center">
              <h1 class="font-light text-white"></h1>
              <h1 class="text-white" style="color: #858585!important">
               
                <i class="fa fa-map-marker" aria-hidden="true"></i>
              </h1>
              <span class="track_status">Sleep</span>
              <span style="float:left;width:100%">
                <h1 id="stop" class="text-white" style="font-size:19px;color:#fab03a!important">0</h1>
                
              </span>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-lg-2 col-xlg-3 cover_track_data" onclick="moving('O')">
          <div class="card card-hover">
            <div class="box bg-cyan1234 text-center">
              <h1 class="font-light text-white"></h1>
              <h1 class="text-white" style="color:#c41900!important">
               
                <i class="fa fa-map-marker" aria-hidden="true"></i>
              </h1>
              <span class="track_status">Offline</span>
              <span style="float:left;width:100%">
                <h1 id="offline" class="text-white" style="font-size:19px;color:#fab03a!important">0</h1>
              
              </span>
            </div>
          </div>
        </div>
      </div>
      <div class="iconsbg12345">
        <div class="row">
          <div class="card card-hover" style="width:100%;-webkit-box-shadow: 1px 1px 2px 3px #ccc;
               -moz-box-shadow: 1px 1px 2px 3px #ccc;
               box-shadow: 1px 1px 21px 1px #ccc">
            <div class="col-6 m-t-15">
              <div style="width: 100%;float: left;">
                <div class="bg-dark p-10 text-white text-center" style="float: left;width:50%;border-radius: 20px 0 0 0;">
                  <img src="assets/images/network-status.png" id="network_online">
                  <img src="assets/images/no-network.png" id="network_offline" style="display: none;">
                  <h4 class="m-b-0 m-t-5 score_data_text">Network Status</h4>
                  <medium id="network_status" class="font-light">
                    <i class="fa fa-spinner" aria-hidden="true"></i>
                </div>

                <div class="bg-dark p-10 text-white text-center" style="float: left;width:50%;border-radius: 0 20px 0 0;">
                  <img src="assets/images/fuel-status.png">
                  <h4 class="m-b-0 m-t-5 score_data_text">Fuel Status</h4>
                 
                  <div id="fuel_100" class="fuel-outer">
                    <ul>
                      <li id="f100"></li>
                      <li id="f100"></li>
                      <li id="f100"></li>
                      <li id="f100"></li>
                    </ul>
                  </div>
                  <div id="fuel_75" class="fuel-outer">
                    <ul>
                      <li id="f75"></li>
                      <li id="f75"></li>
                      <li id="f75"></li>
                      <li id="f0"></li>
                    </ul>
                  </div>
                  <div id="fuel_50" class="fuel-outer">
                    <ul>
                      <li id="f50"></li>
                      <li id="f50"></li>
                      <li id="f0"></li>
                      <li id="f0"></li>
                    </ul>
                  </div>
                  <div id="fuel_25" class="fuel-outer">
                    <ul>
                      <li id="f25"></li>
                      <li id="f0"></li>
                      <li id="f0"></li>
                      <li id="f0"></li>
                    </ul>
                  </div>
                  <div id="fuel_0" class="fuel-outer">
                    <ul>
                      <li id="f0"></li>
                      <li id="f0"></li>
                      <li id="f0"></li>
                      <li id="f0"></li>
                    </ul>
                  </div>
                  <i class="fa fa-spinner" aria-hidden="true"></i>
                </div>
              </div>

              <div class="bg-dark p-10 text-white text-center" style="float: left;width:50%">
                <img src="assets/images/speed.png">
                <h4 class="m-b-0 m-t-5 score_data_text">Speed</h4>
                <medium id="speed" class="font-light">
                  <i class="fa fa-spinner" aria-hidden="true"></i>
              </div>

              <div class="bg-dark p-10 text-white text-center" style="float: left;width:50%">
                <img src="assets/images/odometer.png">
                <h4 class="m-b-0 m-t-5 score_data_text">Odometer</h4>
                <medium id="odometer" class="font-light">
                  <i class="fa fa-spinner" aria-hidden="true"></i>
              </div>

              <div class="bg-dark p-10 text-white text-center" style="float: left;width:50%">
                <img src="assets/images/vehicle-status.png" id="vehicle_status">
                <img src="assets/images/moving-dashboard.png" id="vehicle_moving" style="display: none;">
                <img src="assets/images/halt-dashboard.png" id="vehicle_halt" style="display: none;">
                <img src="assets/images/sleep-dashboard.png" id="vehicle_sleep" style="display: none;">
                <img src="assets/images/offline-dashboard.png" id="vehicle_stop" style="display: none;">
                <h4 class="m-b-0 m-t-5 score_data_text">Vehicle Status</h4>
                <medium id="mode" class="font-light">
                  <i class="fa fa-spinner" aria-hidden="true"></i>
              </div>

              <div class="bg-dark p-10 text-white text-center" style="float: left;width:50%">
                <img src="assets/images/sattelite.png">
                <h4 class="m-b-0 m-t-5 score_data_text">Satellite</h4>
                <medium id="satelite" class="font-light">
                  <i class="fa fa-spinner" aria-hidden="true"></i>
              </div>

              <div class="bg-dark p-10 text-white text-center" style="float: left;width:50%">
                <img src="assets/images/battery-status.png">
                <h4 class="m-b-0 m-t-5 score_data_text">Internal Battery Status.</h4>
                <medium id="battery_status" class="font-light">
                  <i class="fa fa-spinner" aria-hidden="true"></i>
              </div>

              <div class="bg-dark p-10 text-white text-center" style="float: left;width:50%">
                <img src="assets/images/ignition-dashboard.png">
                <h4 class="m-b-0 m-t-5 score_data_text">Ignition</h4>
                <medium id="ignition" class="font-light">
                  <i class="fa fa-spinner" aria-hidden="true"></i>
              </div>

              <div class="bg-dark p-10 text-white text-center location_details" style="width:100%;border-radius: 0px 0px 8px 10px; padding: 10px 0 10px 14px!important;">
                <h4 class="m-b-0 m-t-5 score_data_text" style="padding: 0 48% 0 0!important">
                  <img src="assets/images/location.png">
                  Location
                </h4>
                <medium id="address" class="font-light">
                  <i class="fa fa-spinner" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> 

  @endrole-->

  <!-- SCHOOL ROLE-END -->

<!-- sales ROLE-START -->
@role('sales')
@include('Dashboard::dash-sales')
@endrole
<!-- sales ROLE-END -->


<!--customer executive dashboard--->


@role('Call_Center')
@include('Dashboard::dash-call-center')
@endrole

<!-- customer executive END--->






  <!-- CLIENT ROLE-START -->
@role('client')
@include('Dashboard::dash-client')
@endrole
<!-- CLIENT ROLE-END -->

  </section>
  <style>
  .address
  { cursor: pointer; 

  }  
  .inner-left {
    float: left;
    display: block;
  }

  .box-2 {
    width: 100%;
    float: left;
    display: block;
  }

  .small-box>.view-last {
    float: left;
    width: 100%;
    margin-bottom: 0px;
  }

  .mrg-bt-0 {

    font-size: 14px;
    margin-bottom: 0px;
  }

  .a-tag {
    width: 100%;
    float: left;
    margin-top: 1px;
  }

  .small-box>.a-tag .small-box-footer1 {
    text-align: center;
    padding: 3px 0;
    color: #fff;
    color: rgba(255, 255, 255, 0.8);
    z-index: 10;
    width: 100%;
    float: left;
    background: rgba(0, 0, 0, 0.1);
  }

  .small-box>.small-box-footer2 {
    margin-bottom: -18px;
  }
</style>
  @section('script')

  <script src="{{asset('js/gps/mdb.js')}}"></script>
  <script src="{{asset('js/gps/dashb.js')}}"></script>


  @role('client')
  <link rel="stylesheet" href="{{asset('css/firebaselivetrack-new-css.css')}}" type="text/css" / >

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <script src="{{asset('js/gps/dashb-client.js')}}"></script>
 <!--<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBxw_Xjio_WcEoXjaUISda7fmqltbkG_c8&libraries=places&callback=initMap"></script>
-->
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{config('eclipse.keys.googleMap')}}&libraries=places&callback=initMap"></script>


  <script type="text/javascript">
    
    // refresh button on the map should be hidden when the dashboard loads
    window.onload = function() {
      document.getElementById('map_refresh_button').style.display = "none";
    }
  </script>
  <script src="{{asset('js/gps/GoogleRadar.js')}}"></script>
  <script src="{{asset('dist/js/st.action-panel.js')}}"></script>
  <style type="text/css">
    #f75 {
      width: 4%;
      padding: 8% 8% 7% 3%;
      margin-right: 3%;
      float: left;
      background: #c78307;
    }

    #f50 {
      width: 4%;
      padding: 8% 8% 7% 3%;
      margin-right: 3%;
      float: left;
      background: #f79f1c;
    }

    #f25 {
      width: 4%;
      padding: 8% 8% 7% 3%;
      margin-right: 3%;
      float: left;
      background: #f51902;
    }

    #f0 {
      width: 4%;
      padding: 8% 8% 7% 3%;
      margin-right: 3%;
      float: left;
      background: #cecece;
    }

    .fuel-outer ul li:last-child {
      margin-right: 0;
    }

  </style>
  @endrole

  <!-- @role('school')
  <script src="{{asset('js/gps/dashb-client.js')}}"></script>
  <script async defer src="https://maps.googleapis.com/maps/api/js?key={{config('eclipse.keys.googleMap')}}&libraries=places&callback=initMap"></script>
  <script type="text/javascript">

  </script>
  <script src="{{asset('js/gps/GoogleRadar.js')}}"></script>

  <script src="{{asset('dist/js/st.action-panel.js')}}"></script>
  <style type="text/css">
    .container-fluid {
      padding-left: 0px !important
    }
  </style>
  @endrole -->




  @role('root')

  <script src="{{asset('js/gps/dash-root.js')}}"></script>
  @endrole

  @role('dealer')
  <script src="{{asset('js/gps/dash-dealer.js')}}"></script>
  @endrole

  @role('sub_dealer')
  <script src="{{asset('js/gps/dash-sub-dealer.js')}}"></script>
  @endrole

  @role('Finance')
  <script>
  function myFunction(id) {
  var dots = document.getElementById("dots-"+id);
  var moreText = document.getElementById("more-"+id);
  var btnText = document.getElementById("myBtn-"+id);

  if (dots.style.display === "none") {
    dots.style.display = "inline";
    btnText.innerHTML = "Read more";
    moreText.style.display = "none";
  } else {
    dots.style.display = "none";
    btnText.innerHTML = "Read less";
    moreText.style.display = "inline";
  }
}


function printDiv(divId) {
     var printContents = document.getElementById('print-'+divId).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>
  @endrole
  @endsection
  @endsection
