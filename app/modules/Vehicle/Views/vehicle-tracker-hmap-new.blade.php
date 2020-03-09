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
  </div>
@endsection
@section('script')
<link rel="stylesheet" href="{{asset('css/firebaselivetrack-new-css.css')}}" type="text/css">
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
    var location_data             = [{latitude:"10.192656",longitude:"76.386666",angle:20},{latitude:"10.192740",longitude:"76.386484",angle:20},{latitude:"10.192719",longitude:"76.386044",angle:20},{latitude:"10.193142",longitude:"76.385969",angle:20},{latitude:"10.193543",longitude:"76.386108",angle:20},{latitude:"10.193955",longitude:"76.386226",angle:20},{latitude:"10.193891",longitude:"76.386462",angle:20},{latitude:"10.193532",longitude:"76.386548",angle:20},{latitude:"10.193184",longitude:"76.386731",angle:20},{latitude:"10.192783",longitude:"76.386763",angle:20},{latitude:"10.192455",longitude:"76.386827",angle:20},{latitude:"10.192117",longitude:"76.386784",angle:20},{latitude:"10.191674",longitude:"76.386688",angle:20},{latitude:"10.191521",longitude:"76.386752",angle:20},{latitude:"10.191082",longitude:"76.386666",angle:20},{latitude:"10.190766",longitude:"76.386623",angle:20},{latitude:"10.190444",longitude:"76.386484",angle:20},{latitude:"10.190180",longitude:"76.386296",angle:20},{latitude:"10.190042",longitude:"76.386200",angle:20},{latitude:"10.189826",longitude:"76.385980",angle:20},{latitude:"10.189609",longitude:"76.385749",angle:20},{latitude:"10.189430",longitude:"76.385534",angle:20},{latitude:"10.189219",longitude:"76.385309",angle:20},{latitude:"10.189071",longitude:"76.385116",angle:20},{latitude:"10.188870",longitude:"76.384762",angle:20},{latitude:"10.188712",longitude:"76.384424",angle:20},{latitude:"10.188643",longitude:"76.384204",angle:20},{latitude:"10.188479",longitude:"76.383936",angle:20},{latitude:"10.188279",longitude:"76.383544",angle:20},{latitude:"10.188057",longitude:"76.383169",angle:20},{latitude:"10.187925",longitude:"76.382831",angle:20},{latitude:"10.187735",longitude:"76.382552",angle:20},{latitude:"10.187592",longitude:"76.382305",angle:20},{latitude:"10.187397",longitude:"76.382107",angle:20},{latitude:"10.187202",longitude:"76.381967",angle:20},{latitude:"10.186890",longitude:"76.381720",angle:20},{latitude:"10.186341",longitude:"76.381366",angle:20},{latitude:"10.185950",longitude:"76.381119",angle:20},{latitude:"10.185444",longitude:"76.380905",angle:20},{latitude:"10.184778",longitude:"76.380540",angle:20},{latitude:"10.184525",longitude:"76.380444",angle:20},{latitude:"10.184145",longitude:"76.380208",angle:20},{latitude:"10.183722",longitude:"76.379961",angle:20},{latitude:"10.183300",longitude:"76.379757",angle:20},{latitude:"10.182761",longitude:"76.379575",angle:20},{latitude:"10.182233",longitude:"76.379660",angle:20},{latitude:"10.181790",longitude:"76.379725",angle:20},{latitude:"10.181294",longitude:"76.379757",angle:20},{latitude:"10.180713",longitude:"76.379735",angle:20},{latitude:"10.180153",longitude:"76.379510",angle:20},{latitude:"10.179783",longitude:"76.379424",angle:20},{latitude:"10.179245",longitude:"76.378856",angle:20},{latitude:"10.178706",longitude:"76.378416",angle:20},{latitude:"10.178009",longitude:"76.378030",angle:20},{latitude:"10.177397",longitude:"76.377676",angle:20},{latitude:"10.172202",longitude:"76.372804",angle:20},{latitude:"10.162740",longitude:"76.368341",angle:20},{latitude:"10.153953",longitude:"76.354951",angle:20},{latitude:"10.141449",longitude:"76.352891",angle:20},{latitude:"10.128606",longitude:"76.348428",angle:20},{latitude:"10.123875",longitude:"76.340189",angle:20},{latitude:"10.112045",longitude:"76.346025",angle:20},{latitude:"10.100553",longitude:"76.346368",angle:20},{latitude:"10.091089",longitude:"76.346368",angle:20},{latitude:"10.082639",longitude:"76.338472",angle:20},{latitude:"10.073512",longitude:"76.335725",angle:20},{latitude:"10.069456",longitude:"76.330576",angle:20},{latitude:"10.063371",longitude:"76.325082",angle:20},{latitude:"10.053230",longitude:"76.324739",angle:20},{latitude:"10.052891",longitude:"76.331262",angle:20},{latitude:"10.050779",longitude:"76.335189",angle:20},{latitude:"10.049004",longitude:"76.338343",angle:20},{latitude:"10.049321",longitude:"76.341755",angle:20},{latitude:"10.049659",longitude:"76.345446",angle:20},{latitude:"10.052194",longitude:"76.348364",angle:20},{latitude:"10.052786",longitude:"76.350681",angle:20},{latitude:"10.052955",longitude:"76.352999",angle:20}];
    var km_data                   = 0;
    var pauseMapRendering         = false;
    var bearsMarkeronStartPoint;
    var bearsMarker;
    var startPointLatitude        = null;
    var startPointLongitude       = null;
    var endPointLatitude          = null;
    var endPointLongitude         = null;
    var blPlaceCaronMap           = false;
    var FirstLoop                 = false;
    var first_point               = true;
    var total_offset              = 0;
    var last_offset               = false;
    var vehicle_halt,vehicle_sleep,vehicle_offline,vehicle_online;
    vehicle_halt                  =   '/documents/'+$('#ideal_icon').val();
    vehicle_sleep                 =   '/documents/'+$('#sleep_icon').val();
    vehicle_offline               =   '/documents/'+$('#offline_icon').val();
    vehicle_online                =   '/documents/'+$('#online_icon').val();
    var objImg                    = document.createElement('img');
    var outerElement              = document.createElement('div')
    var domIcon                   = new H.map.DomIcon(outerElement);
    var start_icon                = new H.map.Icon('{{asset("playback/assets/img/start.png")}}');
    var stop_icon                 = new H.map.Icon('{{asset("playback/assets/img/flag.png")}}');
    var hidpi                     = ('devicePixelRatio' in window && devicePixelRatio > 1);
    var alert_icon                = new H.map.Icon('{{asset("playback/assets/img/alert-icon.png")}}');
    var secure                    = (location.protocol === 'https:') ? true : false; // check if the site was loaded via secure connection
    var app_id                    = "RN9UIyGura2lyToc9aPg",
    app_code                      = "4YMdYfSTVVe1MOD_bDp_ZA";
    var mapContainer              = document.getElementById('markers');
    var platform                  = new H.service.Platform({ app_code: app_code, app_id: app_id, useHTTPS: secure });
    var maptypes                  = platform.createDefaultLayers(hidpi ? 512 : 256, hidpi ? 320 : null);
    var map                       = new H.Map(mapContainer, maptypes.normal.map);
    map.setCenter({ lat: 10.192656, lng: 76.386666 });
    map.setZoom(14);
    var zoomToResult              = true;
    var mapTileService              = platform.getMapTileService({
        type: 'base'
    });
    var parameters                = {};
    var uTurn                     = false;
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

    locationStore();
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




    var previous_vehicle_mode = null;
    function locationStore()
    {
      alert(location_data.length);

      for (var i = 0; i < location_data.length; i++)
      {
        alert(2);
            var current_vehicle_mode =  location_data[i].vehicleStatus;

            if(first_set_data==true){
              firstCoods(location_data[i].latitude,location_data[i].longitude,location_data[i].angle,location_data[i].vehicleStatus);
              location_data={
                                "lat"   : location_data[i].latitude,
                                "lng"   : location_data[i].longitude,
                                "angle" : location_data[i].angle,
                                "mode"  : location_data[i].vehicleStatus
                            };
                first_set_data = false;
            }else{

            var start = [previous_data['lat'], previous_data['lng']];
            var end = [location_data[i].latitude, location_data[i].longitude];
              alert(start + end );
            var total_distance = gis.calculateDistance(start, end);
            createNewCoods(location_data[i].latitude,location_data[i].longitude,location_data[i].angle,location_data[i].vehicleStatus,total_distance,previous_data);
            previous_data = {
              "lat"   : location_data[i].latitude,
              "lng"   : location_data[i].longitude,
              "angle" : location_data[i].angle,
              "mode"  : location_data[i].vehicleStatus
            };



          previous_vehicle_mode = null;
         }
        previous_vehicle_mode  = location_data[i].vehicleStatus;
      // --------2019-12-19-2:20--------------------------------------------------------
        location_details_que.push({
          "lat"   : location_data[i].latitude,
          "lng"   : location_data[i].longitude,
          "angle" : location_data[i].angle,
          "mode"  : location_data[i].vehicleStatus,
          "date"  : location_data[i].dateTime,
          "speed" : location_data[i].speed
        });
        // --------2019-12-19-2:20--------------------------------------------------------
        isDataLoadInProgress = false;

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
        lineString, {
          style: {
            lineWidth: 6 ,
            strokeColor: 'rgb(25, 25, 25,1)'
          }
        }
      ));
    }

    function moveMarker(RotateDegree,lat,lng,vehicle_mode){
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

      blPlaceCaronMap = true;
    }
    // --------2019-12-19-2:20--------------------------------------------------------

    async function dataShownOnList(){
      if(location_details_que.length >0)
      {
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
      }
    }
    // --------2019-12-19-2:20--------------------------------------------------------
    // --------2019-12-19-2:20--------------------------------------------------------
    $( document ).ready(function() {
        $('.left-alert-box').css('display','none');
    });



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


    function addMarkerToGroup(group, coordinate, html) {
      var marker = new H.map.Marker(coordinate,{icon: alert_icon});
      marker.setData(html);
      group.addObject(marker);
    }




    function kmCalculation(lat1,lng1,lat2,lng2) {
      var p1 = new google.maps.LatLng(lat1,lng1);
      var p2 = new google.maps.LatLng(lat2,lng2);
      var total_distance = google.maps.geometry.spherical.computeDistanceBetween(p1, p2) ;
      km_data            = km_data+total_distance;
      $('#km_data').text((km_data/1000).toFixed(2));
    }





  </script>
  <script src="{{asset('js/bootstrap-datetimepicker.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script>

<script type="text/javascript">

  $( document ).ready(function() {
    // makes sure the whole site is loaded
    jQuery(window).load(function() {
      // will first fade out the loading animation
      jQuery("#status").fadeOut();
      // will fade out the whole DIV that covers the website.
      jQuery("#preloader").delay(1000).fadeOut("slow");
    })
  });

</script>

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

@endsection