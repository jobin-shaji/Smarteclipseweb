<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Playback</title>

      <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{asset('assets/images/favicon.ico')}}" type="image/x-icon" />



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://js.api.here.com/v3/3.0/mapsjs-ui.css?dp-version=1549984893" />
    <link href="https://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
    <link href="{{ url('/') }}/dist/css/playback_style.css" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('alertify/css/alertify.min.css')}}" />
    <link rel="stylesheet" href="{{asset('alertify/css/themes/default.min.css')}}" />

    <script src="{{asset('playback/assets/Scripts/jquery-3.3.1.js')}}"></script>
    <script src="{{asset('playback/assets/Scripts/jquery-3.3.1.min.js')}}"></script>
     <script src="{{asset('playback_assets/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.4.0/jszip.min.js"></script>

    <script src="{{asset('alertify/alertify.min.js')}}"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">
</head>
<body>

<div class="lorder-bg-playback" id="preloader">
<div class="lds-dual-ring" id="status"></div>
</div>

<div class="wrapper overlay-sidebar">


<input type="hidden" name="vid" id="vehicle_id" value="{{$vehicle_id}}">
 <div id="markers" style="width:100%px;height:100vh; position: relative;"></div>

        <div class='col-lg-12 cover_date cover-date1'>
    <div class="back_button_image back_button_image-1">
        <a onclick="closePlayback()" >
         <img src="{{asset('playback/assets/img/back-button.png')}}">
        </a>
      </div>
          <div class="top-date">
             <div class="row row-mrg-1">
             <span id="cover_date_time_picker">
              <span id="cover_date_time_picker_cover_date">


              <div class='col-sm-3'>
              <div class="form-group">
                <label style="font-weight:bold">Start Date</label>
                <div class="input-group date <?php if(\Auth::user()->hasRole('superior')){ echo 'datepickerSuperior'; }else if(\Auth::user()->hasRole('fundamental')){ echo 'datepickerFundamental'; } else if(\Auth::user()->hasRole('pro')){ echo 'datepickerPro'; }else if(\Auth::user()->hasRole('freebies')){ echo 'datepickerFreebies'; } else{ echo 'datepickerFreebies';}?>" id="<?php if(\Auth::user()->hasRole('superior')){ echo 'datepickerSuperior'; }else if(\Auth::user()->hasRole('fundamental')){ echo 'datepickerFundamental'; } else if(\Auth::user()->hasRole('pro')){ echo 'datepickerPro'; }else if(\Auth::user()->hasRole('freebies')){ echo 'datepickerFreebies'; } else{ echo 'datepickerFreebies';}?>">
                    <input type='text' style="height: 33px;" class="form-control" id="fromDate" name="fromDate" required />
                      <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                      </span>
                </div>
              </div>
            </div>
              <div class='col-sm-3'>
              <div class="form-group">
                <label style="font-weight:bold">End Date</label>
                <div class="input-group date <?php if(\Auth::user()->hasRole('superior')){ echo 'todatepickerSuperior'; }else if(\Auth::user()->hasRole('freebies')){ echo 'todatepickerFreebies'; } else if(\Auth::user()->hasRole('fundamental')){ echo 'todatepickerFundamental'; } else if(\Auth::user()->hasRole('pro')){ echo 'todatepickerPro'; } else{ echo 'todatepickerFreebies';}?>" id="<?php if(\Auth::user()->hasRole('superior')){ echo 'todatepickerSuperior'; }else if(\Auth::user()->hasRole('freebies')){ echo 'todatepickerFreebies'; } else if(\Auth::user()->hasRole('fundamental')){ echo 'todatepickerFundamental'; } else if(\Auth::user()->hasRole('pro')){ echo 'todatepickerPro'; } else{ echo 'todatepickerFreebies';}?>">
                  <input type="text" id="toDate" style="height: 33px;"class="form-control" name="toDate" required>
                  <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                  </span>
                </div>
              </div>
            </div>
          </span>
          </span>

           <div class='col-sm-2'>
            <div class="form-group">
            <div class="selce-bg-out">
              <label style="font-weight:bold" class="speed-label">Speed</label>
              <select name="speed" id="speed" class="speed-select-bx" onchange="changePlaySpeed(this.value)">
                  <option value="1">1X</option>
                  <option value="2">2X</option>
                  <option value="3">3X</option>
                  <option value="4">4X</option>
                  <option value="5">5X</option>
              </select>
            </div>
          </div>
          </div>



         <div class='col-sm-3' style="margin-top: 24px;">

           <button class="btn btn-primary btn-sm start_button buton-new-cl" onclick="startPlayBack()" id="btnPlay">Play</button>
           <button class="btn btn-primary btn-sm start_button buton-new-c3" style="display:none; margin-right: 6px;float: left;" onclick="startPause()" id="btnPause">Pause</button>
              <button class="btn btn-primary btn-sm buton-new-cl" style="display:none; margin-right: 6px;float: left;" onclick="btnContinue()" id="btnContinue">Continue</button>

              <button class="btn btn-primary btn-sm buton-new-c2" onclick="stopPlayback()" id="btnPlay">Reset</button>
        </div>




      </div>


  </div>




 </div>


<!--
<div class="notification-icon">
<div class="dropdownContainer"><div class="noti-alert-count">0
</div> <div class="notification dropdown-toggle"></div>

<div class="dropdown">

<div class="notification-list-name">Alerts
<span class="notification-number large-number"></span>
</div>
<ul >

<li><a href="#" >Over Speed <span>location Name</span>
  <div class="time-dis">2019-12-24 06:40:14</div>
</a>
</li> -->

<!-- </ul>



</div>
</div>
</div> -->


  <div class="vehicle_details_list vehicle_details_list-1">
       <div class="row">
            <span class="play-back-icon1"><img src="{{asset('playback/assets/img/car.png')}}"/></span>
            <span class="play-back-span"><span style="padding: 10px;">:</span> {{$vehicle->name}}</span>
        </div>
         <div class="row">
        <span class="play-back-icon1"><img src="{{asset('playback/assets/img/number-plate.png')}}"/></span>
            <span class="play-back-span"><span style="padding: 10px;">:</span> {{$vehicle->register_number}}</span>
        </div>
        <div class="row">
             <span class="play-back-icon1"><img src="{{asset('playback/assets/img/user.png')}}"/></span>
            <span class="play-back-span"><span style="padding: 15px;">:</span>@if($vehicle->driver){{ $vehicle->driver->name}}@endif</span>
        </div>

        <div class="row row-last">
              <span class="play-back-icon1"><img src="{{asset('playback/assets/img/dash-board.png')}}"/></span>
            <span class="play-back-span"><span style="padding: 15px;">:</span><span id="km_data">0.0</span> KM
        </div>


        </div>
        <input type="hidden" name="online_icon" id="online_icon" value="{{$vehicle_type->web_online_icon}}">
        <input type="hidden" name="offline_icon" id="offline_icon" value="{{$vehicle_type->web_offline_icon}}">
        <input type="hidden" name="ideal_icon" id="ideal_icon" value="{{$vehicle_type->web_idle_icon}}">
        <input type="hidden" name="sleep_icon" id="sleep_icon" value="{{$vehicle_type->web_sleep_icon}}">

        <div class="main-panel main-pane-bg">
            <div class="content">
              <div class="lorder-cover-bg" id="lorder-cover-bg-image">
                <div class="lorder-cover-bg-image" >
                   <img id="loading-image" src="{{asset('playback/assets/img/loader.gif')}}" />
               </div>
               </div>
                <!--<div id="markers" style="width:1800px;height:780px"></div>-->


                    <div class="left-alert-box left-alert-box-1">
                      <div class="left-inner-1bg">
                    <div id="details" class="left-alert-inner left-alert-inner-1">
                       <span id="location_details">
                        <h1 data-text="It's loading…" id="location_details_text">It's loading…</h1>
                    </span>
                    </div>    </div>
                    </div>

                <div class="page-inner mt--5">
                </div>
            </div>
        </div>
    </div>

    <!-- Style -->
    <!--   Core JS Files   -->
    <script src="{{asset('playback/assets/js/core/jquery.3.2.1.min.js')}}"></script>
    <script src="{{asset('playback/assets/js/core/bootstrap.min.js')}}"></script>
    <script src="{{asset('playback_assets/assets/js/core/popper.min.js')}}"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-core.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-service.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-ui.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-mapevents.js"></script>
    <script src="{{asset('playback_assets/assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js')}}"></script>

      <script src="{{asset('playback_assets/assets/js/plugin/chart.js/chart.min.js')}}"></script>
       <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&libraries=geometry"></script>


    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&libraries=geometry"></script>





    <script>
        var km_data           = 0;
        var pauseMapRendering = false;
        var bearsMarkeronStartPoint;
        var bearsMarker;
        var startPointLatitude       = null;
        var startPointLongitude      = null;
        var endPointLatitude         = null;
        var endPointLongitude        = null;

        var blPlaceCaronMap          = false;
        var FirstLoop                = false;
        var first_point              = true;
        var total_offset             = 0;
        var last_offset              = false;
        var vehicle_halt,vehicle_sleep,vehicle_offline,vehicle_online;
       vehicle_halt        =   '/documents/'+$('#ideal_icon').val();
       vehicle_sleep       =   '/documents/'+$('#sleep_icon').val();
       vehicle_offline     =   '/documents/'+$('#offline_icon').val();
       vehicle_online      =   '/documents/'+$('#online_icon').val();
        var objImg                   = document.createElement('img');
        var outerElement        = document.createElement('div')
        var domIcon             = new H.map.DomIcon(outerElement);
        var start_icon          = new H.map.Icon('{{asset("playback/assets/img/start.png")}}');
        var stop_icon           = new H.map.Icon('{{asset("playback/assets/img/flag.png")}}');
        var hidpi               = ('devicePixelRatio' in window && devicePixelRatio > 1);

        var alert_icon          = new H.map.Icon('{{asset("playback/assets/img/alert-icon.png")}}');


        var secure              = (location.protocol === 'https:') ? true : false; // check if the site was loaded via secure connection
       var app_id              = "RN9UIyGura2lyToc9aPg",
           app_code            = "4YMdYfSTVVe1MOD_bDp_ZA";
        var mapContainer        = document.getElementById('markers');
        var platform            = new H.service.Platform({ app_code: app_code, app_id: app_id, useHTTPS: secure });
        var maptypes            = platform.createDefaultLayers(hidpi ? 512 : 256, hidpi ? 320 : null);

        var map                 = new H.Map(mapContainer, maptypes.normal.map);
        map.setCenter({ lat: 10.192656, lng: 76.386666 });
        map.setZoom(14);
        var zoomToResult = true;
        var mapTileService = platform.getMapTileService({
            type: 'base'
        });
        var parameters = {};
        var uTurn = false;

        new H.mapevents.Behavior(new H.mapevents.MapEvents(map)); // add behavior control
        var ui = H.ui.UI.createDefault(map, maptypes); // add UI

        var location_data_que   =  new Array();
        var location_details_que =  new Array();

        var offset=1;
        var isDataLoadInProgress = false;
        var dataLoadingCompleted = false;
        var vehicle_mode;
        var previousCoorinates;
        var blacklineStyle;


        var playback_speed_rate  = 1;
        var speed_val            = 1;
        var load_speed           = 1;
        var playback_speed_base  = 300;
        var playback_speed       = playback_speed_base/playback_speed_rate;
        var location_queue_lower_limit = 30;
        var loader               = false;

        var mapUpdateInterval_location;





        var locationQueue       = [];
        var alertsQueue         = [];
        var previous_data       = [];
        var first_set_data      = true;
        var first_response      = false;

         var gis = {
            ///**
            //* All coordinates expected EPSG:4326
            //* @param {Array} start Expected [lon, lat]
            //* @param {Array} end Expected [lon, lat]
            //* @return {number} Distance - meter.
            //*/
            calculateDistance: function (start, end) {
                var lat1 = parseFloat(start[1]),
                    lon1 = parseFloat(start[0]),
                    lat2 = parseFloat(end[1]),
                    lon2 = parseFloat(end[0]);

                return gis.sphericalCosinus(lat1, lon1, lat2, lon2);
            },

            ///**
            //* All coordinates expected EPSG:4326
            //* @param {number} lat1 Start Latitude
            //* @param {number} lon1 Start Longitude
            //* @param {number} lat2 End Latitude
            //* @param {number} lon2 End Longitude
            //* @return {number} Distance - meters.
            //*/
            sphericalCosinus: function (lat1, lon1, lat2, lon2) {
                var radius = 6371e3; // meters
                var dLon = gis.toRad(lon2 - lon1),
                    lat1 = gis.toRad(lat1),
                    lat2 = gis.toRad(lat2),
                    distance = Math.acos(Math.sin(lat1) * Math.sin(lat2) +
                        Math.cos(lat1) * Math.cos(lat2) * Math.cos(dLon)) * radius;

                return distance;
            },
            ///**
            //* @param {Array} coord Expected [lon, lat] EPSG:4326
            //* @param {number} bearing Bearing in degrees
            //* @param {number} distance Distance in meters
            //* @return {Array} Lon-lat coordinate.
            //*/
            createCoord: function (coord, bearing, distance) {
                /** http://www.movable-type.co.uk/scripts/latlong.html
                * φ is latitude, λ is longitude,
                * θ is the bearing (clockwise from north),
                * δ is the angular distance d/R;
                * d being the distance travelled, R the earth’s radius*
                **/
                var
                    radius = 6371e3, // meters
                    δ = Number(distance) / radius, // angular distance in radians
                    θ = gis.toRad(Number(bearing));
                φ1 = gis.toRad(coord[1]),
                    λ1 = gis.toRad(coord[0]);

                var φ2 = Math.asin(Math.sin(φ1) * Math.cos(δ) +
                    Math.cos(φ1) * Math.sin(δ) * Math.cos(θ));

                var λ2 = λ1 + Math.atan2(Math.sin(θ) * Math.sin(δ) * Math.cos(φ1),
                    Math.cos(δ) - Math.sin(φ1) * Math.sin(φ2));
                // normalise to -180..+180°
                λ2 = (λ2 + 3 * Math.PI) % (2 * Math.PI) - Math.PI;

                return [gis.toDeg(λ2), gis.toDeg(φ2)];
            },
            ///**
            // * All coordinates expected EPSG:4326
            // * @param {Array} start Expected [lon, lat]
            // * @param {Array} end Expected [lon, lat]
            // * @return {number} Bearing in degrees.
            // */
            getBearing: function (start, end) {
                var
                    startLat = gis.toRad(start[1]),
                    startLong = gis.toRad(start[0]),
                    endLat = gis.toRad(end[1]),
                    endLong = gis.toRad(end[0]),
                    dLong = endLong - startLong;

                var dPhi = Math.log(Math.tan(endLat / 2.0 + Math.PI / 4.0) /
                    Math.tan(startLat / 2.0 + Math.PI / 4.0));

                if (Math.abs(dLong) > Math.PI) {
                    dLong = (dLong > 0.0) ? -(2.0 * Math.PI - dLong) : (2.0 * Math.PI + dLong);
                }

                return (gis.toDeg(Math.atan2(dLong, dPhi)) + 360.0) % 360.0;
            },
            toDeg: function (n) { return n * 180 / Math.PI; },
            toRad: function (n) { return n * Math.PI / 180; }
        };


         function startPause(){
            $('#btnPause').css('display','none');
            $('#btnContinue').css('display','block');
            // clearInterval(mapUpdateInterval_location)
            pauseMapRendering = true;
          }

         function btnContinue(){
            $('#btnPause').css('display','block');
            $('#btnContinue').css('display','none');
            pauseMapRendering = false;
         }

        function startPlayBack(){


                if($('#fromDate').val()== ""){
                  alertify.alert('From Date required').setHeader('<em> PLAYBACK</em>');
                  return false;
                }
                 if($('#toDate').val()== ""){
                  alertify.alert('To Date required').setHeader('<em> PLAYBACK</em>');
                  return false;
                }
                var startDate = $("#fromDate").val();
                var endDate = $("#toDate").val();
                var start_time= new Date( startDate ).getTime();
                var end_time = new Date( endDate ).getTime();
                 var time_diff= end_time- start_time;
                if(time_diff==0){
                  alertify.alert("Please Change the time").setHeader('<em> PLAYBACK</em>');

                  return false;
                }
                else if( new Date(startDate) > new Date(endDate)){
                 alertify.alert("Start date should be less than end date").setHeader('<em> PLAYBACK</em>');
                  document.getElementById("toDate").value = "";
                  return false;
                }

               $(".start_button").css("display","none");
                loader      =   true;
                // speed_val   =   $('#speed').val();
                load_speed       =   load_speed/1;

                if(loader == true){
                 $("#lorder-cover-bg-image").css("display","block");
                }



                getLocationData();
               $('.left-alert-box').css('display','block');

               if($('#fromDate').val() !="" && $('#toDate').val() != "" )
                {
                  var from_date = $('#fromDate').val();
                  var to_date   = $('#toDate').val();

                $('#cover_date_time_picker_cover_date').css('display','none');
                $('#cover_date_time_picker').append('<div class="col-sm-6 col-date-outer"><span class="datetime_searched"> '+from_date+ ' - '+to_date+' </span><span onclick="resetDate()" class="close-span-rt"><i class="fa fa-times"></i></span></div>');
                }




        }

        function changePlaySpeed(speed){
         playback_speed_rate  = speed;
         playback_speed_base  = 1000/speed;
         playback_speed       = playback_speed_base/playback_speed_rate;
        }

        function getLocationData(){
             mapUpdateInterval_location   = window.setInterval(function(){
              if(!pauseMapRendering)
              {
                plotLocationOnMap();
              }
             }, playback_speed);


            // --------2019-12-19-2:20--------------------------------------------------------
            var mapUpdateInterval   = window.setInterval(function(){
             dataShownOnList();

             }, 500);
            // --------2019-12-19-2:20-----------------------------------------


            isDataLoadInProgress = true;
            var Objdata = {
                vehicleid: $('#vehicle_id').val(),
                fromDateTime: $('#fromDate').val(),
                toDateTime: $('#toDate').val(),
                 offset: offset
            }



            $.ajax({
                type: "POST",
               headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                //url: 'http://app.smarteclipse.com/api/v1/vehicle_playback',
                 url: '/vehicle-playback',
                data: Objdata,
                async: true,
                success: function (response) {

                    if(response.status=="failed"){
                       if(first_response == false){
                       $(".start_button").css("display","none");
                       $('.left-alert-box').css('display','none');
                       $("#lorder-cover-bg-image").css("display","none");
                       alertify.alert('There is no data');
                       return false;
                      }
                    }


                    if( typeof response.playback != undefined)
                    {
                         if(first_response == false ){
                           $('#btnPause').css('display','block');
                         }

                        first_response=true;
                        total_offset=response.total_offset;
                        if(offset < total_offset){

                         locationStore(response.playback);
                         alertStore(response.alerts);
                         offset = offset+1;
                          if(offset==total_offset){
                            last_offset=true;

                          }
                        }
                    }
                    else
                    {


                        if( typeof response == undefined)
                        {


                             alertify.alert('Something went wrong');
                             return false;
                            // console.log('something went wrong with the server data');
                        }
                        else
                        {
                             alertify.alert('There is no data');
                             return false;
                            // console.log('No more data to display');
                        }

                    }
                },
                failure: function (response) {

                },
                error: function (response) {

                }
            });
        }

        function alertStore(alerts){
          if(alerts != undefined && alerts.length > 0){
            for (var i =0;  i < alerts.length; i++) {
              alertsQueue.push(
                                {
                                  "date"  : alerts[i].device_time,
                                  "lat"   : alerts[i].latitude,
                                  "lng"   : alerts[i].longitude,
                                  "alert" : alerts[i].alert_type.description
                                }

                              )
            }
          }
        }
        var previous_vehicle_mode = null;
        function locationStore(data)
        {

            for (var i = 0; i < data.length; i++)
            {


                   var current_vehicle_mode =  data[i].vehicleStatus;

                  if(first_set_data==true){
                      firstCoods(data[i].latitude,data[i].longitude,data[i].angle,data[i].vehicleStatus);
                      previous_data={
                                        "lat"   : data[i].latitude,
                                        "lng"   : data[i].longitude,
                                        "angle" : data[i].angle,
                                        "mode"  : data[i].vehicleStatus
                                    };
                        first_set_data = false;
                  }

                  // console.log("running mode"+current_vehicle_mode);

                 if((previous_vehicle_mode != null && (current_vehicle_mode  == "S" || current_vehicle_mode  == "H") ) && current_vehicle_mode == previous_vehicle_mode ){
                      // console.log("current_vehicle_mode"+current_vehicle_mode);
                      // console.log("previous_vehicle_mode"+previous_vehicle_mode);
                      // console.log('same mode :- '+current_vehicle_mode);
                      // debugger;

                   }else{

                    if(first_set_data==true){
                      firstCoods(data[i].latitude,data[i].longitude,data[i].angle,data[i].vehicleStatus);
                      previous_data={
                                        "lat"   : data[i].latitude,
                                        "lng"   : data[i].longitude,
                                        "angle" : data[i].angle,
                                        "mode"  : data[i].vehicleStatus
                                    };
                        first_set_data = false;
                    }else{


                      var start = [previous_data['lat'], previous_data['lng']];
                      var end = [data[i].latitude, data[i].longitude];
                      var total_distance = gis.calculateDistance(start, end);

                      createNewCoods(data[i].latitude,data[i].longitude,data[i].angle,data[i].vehicleStatus,total_distance,previous_data);

                      previous_data = {
                                        "lat"   : data[i].latitude,
                                        "lng"   : data[i].longitude,
                                        "angle" : data[i].angle,
                                        "mode"  : data[i].vehicleStatus
                                      };


                    // location_data_que.push({
                    //           "lat"   : data[i].latitude,
                    //           "lng"   : data[i].longitude,
                    //           "angle" : data[i].angle,
                    //           "mode"  : data[i].vehicleStatus
                    //       });

                    }

                    previous_vehicle_mode = null;
                    }
                   previous_vehicle_mode  = data[i].vehicleStatus;
                  // --------2019-12-19-2:20--------------------------------------------------------
                   location_details_que.push({
                                                "lat"   : data[i].latitude,
                                                "lng"   : data[i].longitude,
                                                "angle" : data[i].angle,
                                                "mode"  : data[i].vehicleStatus,
                                                "date"  : data[i].dateTime,
                                                "speed" : data[i].speed

                                             });
                 // --------2019-12-19-2:20--------------------------------------------------------


                isDataLoadInProgress = false;
                if( data.total_offset == offset)
                {
                    dataLoadingCompleted = true;
                    // console.log('data loading completed');
                }




            }
        }

        function firstCoods(lat,lng,angle,mode){
           location_data_que.push({
                              "lat"   : lat,
                              "lng"   : lng,
                              "angle" : angle,
                              "mode"  : mode
                          });
            moveMarker(angle,lat,lng,mode);

        }


        function createNewCoods(lat,lng,angle,mode,distance,previous_data){
          var bearing   = angle;
          var start       = [previous_data['lat'],previous_data['lng']];
          var end       = [lat, lng];

          var new_coord = gis.createCoord(start, angle, distance);
          var pCoordinates;

          for (var i = 0; i < distance/playback_speed_rate; i++) {
                bearing = gis.getBearing(start, end);
                new_coord = gis.createCoord(start, bearing, i);

                if (i > 0) {
                    if (pCoordinates != new_coord[0]) {

                        location_data_que.push({
                              "lat"   : new_coord[0],
                              "lng"   : new_coord[1],
                              "angle" : angle,
                              "mode"  : mode
                          });




                    }


                }
                pCoordinates = new_coord;

            }

        }



        function plotLocationOnMap()
        {

            // console.log('Current length '+location_data_que.length);
            if(location_data_que.length >0)
            {
                 loader = false;
                 if(loader == false){
                 $("#lorder-cover-bg-image").css("display","none");
                }

                moveMap(location_data_que[0].lat,location_data_que[0].lng);
                // create start marker
                if(first_point==true){

                     var madridMarker = new H.map.Marker({lat:location_data_que[0].lat, lng:location_data_que[0].lng},{ icon: start_icon});
                     map.addObject(madridMarker);
                }
                first_point=false;
                // create start marker



                if( (startPointLatitude != null) && (startPointLongitude!=null) )
                {
                    endPointLatitude    = location_data_que[0].lat;
                    endPointLongitude   = location_data_que[0].lng;
                    vehicle_mode        = location_data_que[0].mode;
                    // calculate the direction of movement
                    // var direction = calculateCarDirection(startPointLatitude,startPointLongitude,endPointLatitude,endPointLongitude);

                    var direction    =  location_data_que[0].angle;



                    moveMarker(direction,endPointLatitude,endPointLongitude,vehicle_mode);
                    addPolylineToMap(startPointLatitude,startPointLongitude,endPointLatitude,endPointLongitude);
                    kmCalculation(startPointLatitude,startPointLongitude,endPointLatitude,endPointLongitude);
                }
                startPointLatitude  = location_data_que[0].lat;
                startPointLongitude = location_data_que[0].lng;
                // remove the already plotted locations
                popFromLocationQueue();
                // want to load new set of data ?





                if( (location_data_que.length < location_queue_lower_limit ) && ( !isDataLoadInProgress ) && (!dataLoadingCompleted) )
                {
                    getLocationData();
                }

                // stop point

                if(last_offset==true && location_data_que.length ==0){



                     var flag = new H.map.Marker({lat:startPointLatitude, lng:startPointLongitude},{ icon: stop_icon});
                     map.addObject(flag);


                }
                // stop point

             }else{
                if( (location_data_que.length < location_queue_lower_limit ) && ( !isDataLoadInProgress ) && (!dataLoadingCompleted) )
                {
                    getLocationData();
                }

                if(last_offset==true && location_data_que.length ==0){

                     var flag = new H.map.Marker({lat:startPointLatitude, lng:startPointLongitude},{ icon: stop_icon});
                     map.addObject(flag);

                     $('#btnPause').css('display','none');
                }

             }
        }

        /**
         *
         *
         */
        function popFromLocationQueue()
        {
            if(location_data_que.length > 0)
            {
                return location_data_que.splice(0,1)[0];
            }
            else
            {
                clearInterval(mapUpdateInterval);
                clearInterval(mapUpdateInterval_location);
                // console.log('no more map updation calls');
                return null;
            }
        }

        function addMarkersToMap(){

        }


        function moveMap(lat,lng){
          map.setCenter({lat:lat, lng:lng});
        }

        function calculateCarDirection(startPointLat, startPointLng, endPointLat, endPointLng)
        {
            return getDegree(startPointLat, startPointLng, endPointLat, endPointLng);
        }

        function getDegree(lat1, long1, lat2, long2)
        {

            var dLon = (long2 - long1);
            var y = Math.sin(dLon) * Math.cos(lat2);
            var x = Math.cos(lat1) * Math.sin(lat2) - Math.sin(lat1)
                * Math.cos(lat2) * Math.cos(dLon);
            var brng = Math.atan2(y, x);
            brng = radianstoDegree(brng);
            brng = (brng + 360) % 360;
            return brng;
        }

        function radianstoDegree(x)
        {
            return x * 180.0 / Math.PI;
        }

        function addPolylineToMap(lat1,lng1,lat2,lng2) {
          var lineString = new H.geo.LineString();
          lineString.pushPoint({lat:lat1, lng:lng1});
          lineString.pushPoint({lat:lat2, lng:lng2});
          map.addObject(new H.map.Polyline(
            lineString, { style: { lineWidth: 6 ,
                                    strokeColor: 'rgb(25, 25, 25,1)'
                                 }}
          ));
        }

        function moveMarker(RotateDegree,lat,lng,vehicle_mode){
            // console.log('mode '+vehicle_mode);
            if ((bearsMarkeronStartPoint != null) && (blPlaceCaronMap == true)) {
                map.removeObject(bearsMarkeronStartPoint);
                blPlaceCaronMap = false;
            }

            if(vehicle_mode=="M")
             {
              objImg.src = vehicle_online;
             }else if(vehicle_mode=="H")
             {
              objImg.src = vehicle_halt;
             }else if(vehicle_mode=="S")
             {
              objImg.src = vehicle_sleep;
             }else{
              objImg.src = vehicle_offline;
             }

            el = objImg;
            var carDirection = RotateDegree;
            if (el.style.transform.includes("rotate")) {
                el.style.transform = el.style.transform.replace(/rotate(.*)/, "rotate(" + carDirection + "deg)");
            } else {
                el.style.transform = el.style.transform + "rotate(" + carDirection + "deg)";
            }
            outerElement.appendChild(el);
            outerElement.style.top = "-20px";
            outerElement.style.width = "150px";

            var domIcon = new H.map.DomIcon(outerElement);
            bearsMarkeronStartPoint = new H.map.DomMarker({ lat:lat, lng:lng }, {
                icon: domIcon
            });
            map.addObject(bearsMarkeronStartPoint);
            if(lat != undefined && lng != undefined){
              alertPlotOnMap(lat,lng);
             }

            blPlaceCaronMap = true;
    }
        // --------2019-12-19-2:20--------------------------------------------------------

        async function dataShownOnList(){
            if(location_details_que.length >0)
            {
                // console.log(location_details_que.length);
                // for(i=0;i<=location_details_que.length)
               // console.log(location_details_que);
            var lat=location_details_que[0].lat;
            var lng=location_details_que[0].lng;
            var mode=location_details_que[0].mode;
            var date=location_details_que[0].date;
            var speed=location_details_que[0].speed;

            var status = "";
            if(mode=="M"){
              status="<span style='color:#84b752 !important'>ONLINE<span>";
            }else if(mode=="S"){
              status="<span style='color:#858585 !important;'>SLEEP<span>";
            }else if(mode=="H"){
              status="<span style='color:#69b4b9 !important'>HALT<span>";
            }else{
              status="<span style='color:#c41900 !important'>OFFLINE<span>";
            }

             var location_name = await getPlaceName(lat,lng).then(function(data){
                    var location_data = JSON.stringify(data.Response.View);
               return location_name_list=JSON.parse(location_data)[0].Result[0].Location.Address.Label;
             });

             // var location_name = lat+","+lng;


              var details = ' <div class="left-alert-text">'+
                                '<h5></h5>'+
                             '<p class="location_name" id="location_name">'+
                             '<span class="place_data"><i class="fa fa-map-marker" aria-hidden="true"></i></span>'+location_name+'</p>'+
                              '<p><span class="place_data"><i class="fa fa-car" aria-hidden="true"></i></span>'+status+'</p>'+
                              '<p><span class="place_data">'+
                              '<i class="fa fa-tachometer" aria-hidden="true"></i></span>'+ Number(speed).toString()+
                                ' km/h <p class="datetime_cover datetime_cover1" id="date">'+date+'</p>'+
                                '<div class="left-alert-time "></div>'+
                            '</div>';
             $('#location_details').remove()
             $("#details").prepend(details);
             popDetailsLocationQueue();

             // $('#location_name').text(location_name);
             // $('#date').text(date);

             // console.log(location_details_que[0].date);
         }

        }






        // --------2019-12-19-2:20--------------------------------------------------------


        // --------2019-12-19-2:20--------------------------------------------------------
        $( document ).ready(function() {
            $('.left-alert-box').css('display','none');
        });
       function getPlaceName(lat,lng){
        var location_name = "";
        return $.ajax({
          url: 'https://reverse.geocoder.api.here.com/6.2/reversegeocode.json',
          type: 'GET',
          dataType: 'jsonp',
          jsonp: 'jsoncallback',
          data: {
            prox: lat+','+lng,
            mode: 'retrieveAddresses',
            maxresults: '1',
            gen: '9',
            app_id: app_id,
            app_code: app_code
         }
        });
         // return location_name;
        }

        function popLocationDataQueue()
        {
            if(location_details_que.length > 0)
            {
                return location_details_que.splice(0,1)[0];
            }
            else
            {
                clearInterval(mapUpdateInterval);
                // console.log('no more map updation calls');
                return null;
            }
        }


       function popDetailsLocationQueue()
        {
            if(location_details_que.length > 0)
            {
                return location_details_que.splice(0,1)[0];
            }
            else
            {
                // console.log('no more map updation calls');
                return null;
            }
        }




         function alertPlotOnMap(lat,lng){
                alertsQueue.find(function(x,i){
               if(x != undefined)
               {
                 var start = [lat,lng];
                 var end   = [x.lat, x.lng];
                 var total_distance = gis.calculateDistance(start, end);
                 if(total_distance < 1){
                     if(alertsQueue[i] != undefined){
                        addInfoBubble(alertsQueue[i].lat,alertsQueue[i].lng,alertsQueue[i].alert,alertsQueue[i].date)
                        }
                        alertsQueue.splice(0,1)[i];

                  }
                 }
                },lat,lng);
            }


        function addMarkerToGroup(group, coordinate, html) {
          var marker = new H.map.Marker(coordinate,{icon: alert_icon});
          marker.setData(html);
          group.addObject(marker);
        }

        function addInfoBubble(lat,lng,alert,time) {
          var group = new H.map.Group();
          map.addObject(group);
          group.addEventListener('tap', function (evt) {
            var bubble =  new H.ui.InfoBubble(evt.target.getGeometry(), {
              content: evt.target.getData()
            });
            ui.addBubble(bubble);
          }, false);

          var message ='<table style="font-size: 15px;">'+
          '<tr>'+
          '<td><i class="fa fa-clock-o"></i>:</td>'+
          '<td>'+time+'</td>'+
          '</tr><tr>'+
          '<td><i class="fa fa-bell"></i>:</td>'+
          '<td>'+alert+'</td>'
          '</tr>'+
          '</table>'
          addMarkerToGroup(group, {lat:lat, lng:lng},
            message);
          }


       // --------2019-12-19-2:20-------------------------------------------------------


       // function kmCalculation(lat1,lng1,lat2,lng2) {
       //    var start          = [lat1 ,lng1];
       //    var end            = [lat2 ,lng2];
       //    var total_distance = gis.calculateDistance(start, end);
       //    km_data            = km_data+total_distance;
       //    $('#km_data').text((km_data/1000).toFixed(2));

       //  }

        function kmCalculation(lat1,lng1,lat2,lng2) {

          var p1 = new google.maps.LatLng(lat1,lng1);
          var p2 = new google.maps.LatLng(lat2,lng2);
          var total_distance = google.maps.geometry.spherical.computeDistanceBetween(p1, p2) ;

              km_data            = km_data+total_distance;
             $('#km_data').text((km_data/1000).toFixed(2));
        }

       function stopPlayback(){
        location.reload(true);
       }

       function closePlayback(){
        window.close();
       }

       function resetDate(){
         location.reload(true);
       }




    </script>
 <script src="{{asset('js/bootstrap-datetimepicker.js')}}"></script>


 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script>





<script type="text/javascript">
$(function() {

  var d = new Date();
  free_date=d.setMonth(d.getMonth() - 1);
  fundamental_date=d.setMonth(d.getMonth() - 1);
  superior_date=d.setMonth(d.getMonth() - 2);
  pro_date=d.setMonth(d.getMonth() - 2);
  var date = new Date();
  var currentMonth = date.getMonth();
  var currentDate = date.getDate();
  var currentYear = date.getFullYear();


  $('#datepickerFreebies').datetimepicker({
    format: 'Y-MM-DD HH:mm:ss',
        maxDate: new Date(),
        minDate: new Date(currentYear, currentMonth-1, currentDate)
        // minDate:free_date
  });
  $('#todatepickerFreebies').datetimepicker({
      format: 'Y-MM-DD HH:mm:ss',
        maxDate: new Date(),
        minDate: new Date(currentYear, currentMonth-1, currentDate)
        // minDate:free_date
  });
  $('#datepickerFundamental').datetimepicker({
    format: 'Y-MM-DD HH:mm:ss',
        maxDate: new Date(),
        minDate: new Date(currentYear, currentMonth-2, currentDate)
        // minDate:fundamental_date
  });
  $('#todatepickerFundamental').datetimepicker({
    format: 'Y-MM-DD HH:mm:ss',
        maxDate: new Date(),
        minDate: new Date(currentYear, currentMonth-2, currentDate)
        // minDate:fundamental_date
  });
  $('#datepickerSuperior').datetimepicker({
    format: 'Y-MM-DD HH:mm:ss',
        maxDate: new Date(),
        minDate: new Date(currentYear, currentMonth-4, currentDate)
        // minDate:superior_date
  });
  $('#todatepickerSuperior').datetimepicker({
    format: 'Y-MM-DD HH:mm:ss',
        maxDate: new Date(),
        minDate: new Date(currentYear, currentMonth-4, currentDate)
        // minDate:superior_date
  });
  $('#datepickerPro').datetimepicker({
        format: 'Y-MM-DD HH:mm:ss',
        maxDate: new Date(),
        minDate: new Date(currentYear, currentMonth-6, currentDate)
        // minDate:pro_date
  });
  $('#todatepickerPro').datetimepicker({
    format: 'Y-MM-DD HH:mm:ss',
        maxDate: new Date(),
        minDate: new Date(currentYear, currentMonth-6, currentDate)
        // minDate:pro_date
  });

});

$( document ).ready(function() {
        // makes sure the whole site is loaded
jQuery(window).load(function() {
// will first fade out the loading animation
jQuery("#status").fadeOut();
// will fade out the whole DIV that covers the website.
jQuery("#preloader").delay(1000).fadeOut("slow");
})
});

/**
 * Bug #I698 
 * If playback window is opened and user is logged out from the main window
 * the user should not be able to access the playback functionality when the window is
 * refocused. 
 * @author PMS
 * date 2020-02-28
 * @return void
 */
function forceReload()
{
  var loginStatus = parseInt(localStorage.getItem('login'));
  if(loginStatus != '1')
  {
    window.location.reload();
  }
  console.log('loginStatus '+loginStatus);
}
// Active
window.addEventListener('focus', function(){ forceReload(); });
// Inactive
window.addEventListener('blur', function(){ forceReload(); });


</script>
<script>

</script>


    <script>
    $(function() {

      // Dropdown toggle
      $('.dropdown-toggle').click(function() {
        $(this).next('.dropdown').toggle( 400 );
      });

      $(document).click(function(e) {
        var target = e.target;
        if (!$(target).is('.dropdown-toggle') && !$(target).parents().is('.dropdown-toggle')) {
          $('.dropdown').hide() ;
        }
      });

});
    </script/>
          <style type="text/css">
              .col-date-outer{
      margin-top: 23px;
    background: #dab604;
    padding: 3px 4px 3px 10px;
    color: #fff;
    text-align: center;
    margin-left: 15px;
    font-weight: bold;
    font-size: 1.1em;
    width: 45%;
    border: 1px solid #c5a505;
    border-radius: 8px;
              }
              .row-mrg-1{
                    margin-bottom: 15px;
              }
.close-span-rt {
    float: right;
    background: #fff;
    padding: 1px 5px;
    border-radius: 50%;
    color: #dab604;
    font-weight: normal;
    font-size: 13px;
    margin-top: 0.5px;
}
.close-span-rt:hover {
 background: #af9308;
    color: #ffffff;
}
.col-lg-12.cover_date.cover-date1{
     width: 100%;
    margin: 0px auto;
    padding: 0 3%;
    background: #c7c7c7bf;
    box-shadow: 0 2px 2px rgba(0,0,0,.15);
    position: absolute;
    top: 0;
        max-height: 10vh;
}

.back_button_image-1 {

    margin-top: 2%;
    position: absolute;
    margin-left: -2%;
}
.speed-label{
      font-weight: bold;
    width: 100%;
}

button, input, select, textarea {
    font-family: inherit;
    font-size: inherit;
    line-height: inherit;
}
.vehicle_details_list-1{
width: 228px;
    float: left;
    margin-bottom: 0;
    display: block;
    padding: 10px 0% 0;
    background: #ffde7a;
    color: #000;
    right: 2%;
    position: absolute;
    bottom: 32px;
    border-radius: 10px;
  }
.vehicle_details_list-1 .row{
    width: 100%;
    margin: 0;
    padding: 5px 6%;
    text-transform: uppercase;
}
.vehicle_details_list-1 .row-last{
     background: #a98004;
    padding-top: 7px;
    color: #fff;
    border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px;
    padding-bottom: 7px;
    font-size: 16px;
}
.left-alert-box-1{
       display: block;
    top: 11.5vh;
    max-height: 85vh;
    left: 15px;
    box-shadow: 0 2px 2px rgba(66, 66, 66, 0.28);
    background-color: #fff;
    overflow-y: inherit;
    border-radius: 8px;

}
.left-alert-inner-1 {

    background: #fff;
    padding: 10px 0;
   box-shadow: none ;
    border-radius: 4px;
}
.left-alert-text p.datetime_cover1{
background: #ce9c06;
    width: auto;
    padding: 5px;
    float: right;
    border-radius: 5px;
    color: #fff;
}
.left-inner-1bg{
overflow-y: scroll;
    width: 100%;
    max-height: 83vh;
    margin-top: 1vh;
    margin-bottom: 1vh;}
/* width */
.left-alert-box-1 ::-webkit-scrollbar {
  width: 10px;
}

/* Track */
.left-alert-box-1 ::-webkit-scrollbar-track {
  background: #f1f1f1;
}

/* Handle */
.left-alert-box-1 ::-webkit-scrollbar-thumb {
  background: #a98004;
    border-radius: 10px;
}

/* Handle on hover */
.left-alert-box-1 ::-webkit-scrollbar-thumb:hover {
  background: #a98004;
    border-radius: 10px;
}
select.speed-select-bx{
  width: 100%;
}
.selce-bg-out{
  float: left;
    margin-left: 2%;
    width: 100%;
}
.buton-new-cl{
  width: 80px;
    background: #28a745;
    box-shadow: none;
    border: 0;
    color: #fff;
    font-size: 1em;
    border-radius: 6px;
    text-shadow: none;
outline: 0;
}
.buton-new-cl:hover{
   background: #28a745;
}

.buton-new-cl::focus{
 background: #28a745;
}

.buton-new-c2{
  width: 80px;
    background: #ffc107;
    box-shadow: none;
    border: 0;
    color: #fff;
    font-size: 1em;
    border-radius: 6px;
    text-shadow: none;
outline: 0;
}
.buton-new-c2:hover{
   background: #ffc107;
}

.buton-new-c2:focus{
 background: #ffc107;
}


.buton-new-cl:active:hover{
  background: #28a745;
}
.buton-new-c3{
  width: 80px;
    background:#dc3545;
    box-shadow: none;
    border: 0;
    color: #fff;
    font-size: 1em;
    border-radius: 6px;
    text-shadow: none;
outline: 0;
}
.buton-new-c3:hover{
   background: #dc3545;
}

.buton-new-c3:focus{
 background: #dc3545;
}


.lorder-bg-playback{
      width: 100%;
    float: left;
    height: 100%;
    background: #0000006b;
    z-index: 9;
    position: absolute
}
.lds-dual-ring {
     display: inline-block;
    width: 80px;
    height: 80px;
    z-index: 9999;
    position: absolute;
    margin-top: 23%;
    left: 49%;
}
.lds-dual-ring:after {
  content: " ";
  display: block;
  width: 64px;
  height: 64px;
  margin: 8px;
  border-radius: 50%;
  border: 6px solid #fff;
  border-color: #fff transparent #fff transparent;
  animation: lds-dual-ring 1.2s linear infinite;
}
@keyframes lds-dual-ring {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
.play-back-icon1{
  width: 30px;
    float: left;
}
.play-back-span{
      font-size: 1em;
    font-weight: bold;
    padding-top: 8px;
    float: left;
    margin-left: 0;
}



.dropdownContainer {
position: relative;
    float: right;
    margin-left: 15px;
}

.dropdown-toggle {
    cursor: pointer;
    color:red;
}
.notification-icon {
    position: absolute;
    top: 20%;
    right: 3%;
    text-align: center;
}
.noti-alert-count{
     position: absolute;
    right: -11px;
    top: -13px;
    border: 2px #fff solid;
    border-radius: 60px;
    background: #ffc108;
    padding: 5px 8px;
    border-radius: 60px;
    color: #fff;
    line-height: 100%;
    z-index: 9;
    font-size: 0.7em;}

.dropdown {
    display: none;
    position: absolute;
    top: 100%;
    right: 0;
    min-width: 274px;
    padding: 0;
    border: 1px solid rgb(243, 243, 243);
    border-radius: 7px;
    box-shadow: 0 1px 1px rgba(50,50,50,0.1);
    z-index: 9;
    background: #ffffff;
}
/* up arrow*/
.dropdown:before {
    content: "";
    width: 0;
    height: 0;
    position: absolute;
    bottom: 100%;
     right: 10px;
    border-width: 0 10px 10px 10px;
    border-style: solid;
    border-color: #fff transparent;
}
.dropdown:after {
content: "";
    width: 0;
    height: 0;
    position: absolute;
    bottom: 100%;
    right: 10px;
    border-width: 0 8px 7px 7px;
    border-style: solid;
    border-color: #fff transparent;
}


.dropdown li {
  list-style-type: none;
  border-top: 1px solid #f1eee1;
}

.dropdown li:hover{
  background-color:#fffbee;
}

.dropdown li:first-child {
      list-style-type: none;
    border-top: none;
    margin-top: -10px;
    padding-top: 4px;
}

.dropdown .fa-circle{
    font-size: 15px;
    color: rgba(115, 187, 22, 1);
}
    .dropdown ul{
margin: 0px;
    padding: 0px;
    width: 100%;
    float: left;
    overflow-y: scroll;
    max-height: 165px;
  }


.dropdown li a {
text-decoration: none;
    padding: 10px 1em;
    display: block;

    font-size:1em;
    width: 100%;
    font-weight: 600;
        color: #f0b100;
    float: left;
    border-bottom: 1px solid #f1f0ed;
}
.dropdown li a span{
  width: 100%;
  float: left;
  font-weight: normal;
  display: block;
  color: black;
}

/*View All Notification*/
.dropdown .fa-list{
    font-size: 15px;
    padding:5px;
    color: rgba(115, 187, 22, 1);
    border: 2px solid rgba(115, 187, 22, 1);
    border-radius: 100%;
}


  .notification-list-name{
      margin: 0px;
    padding: 6px 0;
    float: left;
    width: 100%;
    background: #f0b100;
    font-size: 16px;
    font-weight: bold;
    border-top-right-radius: 7px;
    border-top-left-radius: 7px;
    color: #fff;
  }
  .view-all-notification{
margin: 0px;
    padding: 7px 0;
    float: left;
    width: 100%;
    background:#f0b100;

    font-size: 16px;
    border-bottom-right-radius: 7px;
    border-bottom-left-radius: 7px;}
    .view-all-notification a{
    color:#fff;
  float:left;
  text-decoration:none;
  text-align:center;
  width:100%;
  }

  .notification {
    display: inline-block;
    position: relative;
    padding: 0.6em;
    background: #3498db;
    border-radius: 0.2em;
    font-size: 1.3em;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
}

.notification::before,
.notification::after {
    color: #fff;
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
}

.notification::before {
    display: block;
    content: "\f0f3";
    font-family: "FontAwesome";
    transform-origin: top center;
}

.dropdown ul ::-webkit-scrollbar {
  width: 10px;
}

/* Track */
.dropdown ul ::-webkit-scrollbar-track {
  background: #f1f1f1;
}

/* Handle */
.dropdown ul ::-webkit-scrollbar-thumb {
  background: #a98004;
    border-radius: 10px;
}

/* Handle on hover */
.dropdown ul ::-webkit-scrollbar-thumb:hover {
  background: #a98004;
    border-radius: 10px;
}
.time-dis{
    width: 100%;
    float: left;
    border-radius: 7px;
    font-size: 0.8em;
    padding-top: 1px;
    color: #000;
}

@media only screen and (max-width: 1600px) {

.col-lg-12.cover_date.cover-date1 {
      max-height: 14vh;
}
.left-alert-box-1 {
    top: 14.5vh;
    max-height: 84vh;
}
.row-mrg-1 {
    margin-left: 0px;
}
.back_button_image-1 {
    margin-top: 3%;
}
.play-back-icon1 {
    width: 24px;
}
.play-back-span {
    font-size: 0.96em;
    padding-top: 2px;
}

}
            </style>

</body>
</html>