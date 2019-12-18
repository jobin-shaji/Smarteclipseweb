<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Vehicle Live Track</title>

      <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="{{asset('playback/assets/img/icon.png')}}" type="image/x-icon" />
    <!-- Fonts and icons -->
     <!-- <link rel="stylesheet" href="{{asset('playback_assets/assets/css/bootstrap.min.css')}}"> -->
    <!-- <link rel="stylesheet" href="{{asset('playback_assets/assets/css/atlantis.min.css')}}"> -->
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <!-- <link rel="stylesheet" href="{{asset('playback_assets/assets/css/demo.css')}}"> -->

    <script src="{{asset('playback/assets/Scripts/jquery-3.3.1.js')}}"></script>
    <script src="{{asset('playback/assets/Scripts/jquery-3.3.1.min.js')}}"></script>
     <script src="{{asset('playback_assets/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>

    <link rel="stylesheet" type="text/css" href="https://js.api.here.com/v3/3.0/mapsjs-ui.css?dp-version=1549984893" />
    <link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="screen"
     href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">


</head>


    <div class="wrapper overlay-sidebar">
<input type="hidden" name="vid" id="vehicle_id" value="{{$Vehicle_id}}">
          <div id="datetimepicker_live1" class="input-append date" style="margin-bottom: 0px!important">
            <div  style="float: left;margin-left: 3%">
              <label style="font-weight:bold">Start Date</label>
              <input type="text" id="fromDate" name="fromDate">
              <span class="add-on">
                <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
              </span>
            </div>
          </div>
          <div id="datetimepicker_live2" class="input-append date" style="margin-bottom: 0px!important">
            <div style="float: left;margin-left: 3%">
              <label style="font-weight:bold">End Date</label>
              <input type="text" id="toDate" name="toDate">
              <span class="add-on">
                <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
              </span>
            </div>
          </div>
          <div class="contoller" style="float: left;margin-left: 3%;margin-top: 1.7%">
            <span class="contoller">                           
              <button class="btn btn-primary btn-sm" onclick="getLocationData()" id="btnPlay">Play</button>

            </span>
          </div>
          
        <div class="main-panel">
            <div class="content">
                <!--<div id="markers" style="width:1800px;height:780px"></div>-->
                <div id="markers" style="width:1360px;height:595px"></div>
                <div class="page-inner mt--5">
                </div>
            </div>
        </div>
    </div>

    <!-- Style -->
    <style>
        #cover-spin {
            position: fixed;
            width: 100%;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            background-color: rgba(255,255,255,0.7);
            z-index: 9999;
            display: none;
        }

        @-webkit-keyframes spin {
            from {
                -webkit-transform: rotate(0deg);
            }

            to {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        #cover-spin::after {
            content: '';
            display: block;
            position: absolute;
            left: 48%;
            top: 40%;
            width: 40px;
            height: 40px;
            border-style: solid;
            border-color: black;
            border-top-color: transparent;
            border-width: 4px;
            border-radius: 50%;
            -webkit-animation: spin .8s linear infinite;
            animation: spin .8s linear infinite;
        }
    </style>
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
      
    <script>
        var startPointLatitude  = null;
        var startPointLongitude = null;
        var endPointLatitude    = null;
        var endPointLongitude   = null;
        var bearsMarkeronStartPoint;
        var blPlaceCaronMap = false;
        var FirstLoop = false;

        //var parisMarker = new H.map.Marker({ lat: 10.192656, lng: 76.386666 });
        var objImg = document.createElement('img');
        objImg.src = '/assets/images/Car.png';
        var outerElement = document.createElement('div')
        var domIcon = new H.map.DomIcon(outerElement);
        var bearsMarker;

        var hidpi = ('devicePixelRatio' in window && devicePixelRatio > 1);
        var secure = (location.protocol === 'https:') ? true : false; // check if the site was loaded via secure connection
        var app_id = "vvfyuslVdzP04AK3BlBq",
            app_code = "f63d__fBLLCuREIGNr6BjQ";

        var mapContainer = document.getElementById('markers');
        var platform = new H.service.Platform({ app_code: app_code, app_id: app_id, useHTTPS: secure });
        var maptypes = platform.createDefaultLayers(hidpi ? 512 : 256, hidpi ? 320 : null);

        var map = new H.Map(mapContainer, maptypes.normal.map);
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
        var offset=1;
        var isDataLoadInProgress = false;
        var dataLoadingCompleted = false;
        // getLocationData();
    
         
        // window.setInterval(function(){
        //     getLocationData();
        // }, 20000);



        var locationQueue=[];
        var mapUpdateInterval = window.setInterval(function(){
            plotLocationOnMap();
        }, 500);

    
        function getLocationData(){
            var id = document.getElementById('vehicle_id').value;
        var from_time = document.getElementById('fromDate').value;
        var to_time = document.getElementById('toDate').value;
            isDataLoadInProgress = true;
            var Objdata = {
             "fromDateTime": from_time,
             "toDateTime": to_time,
             "vehicleid": id,
             "offset": offset
            }

            $.ajax({
                type: "POST",
                //url: 'http://app.smarteclipse.com/api/v1/vehicle_playback',
                url: 'http://app.rayfleet.com/api/v1/vehicle_playback',
                data: Objdata,
                async: true,
                success: function (response) {

                    if( typeof response.playback != undefined)
                    {
                        locationStore(response.playback);
                        offset = offset+1;
                    }
                    else
                    {
                        if( typeof response == undefined)
                        {
                            console.log('something went wrong with the server data');
                        }
                        else
                        {
                            console.log('No more data to display');
                        }
                    }
                },
                failure: function (response) {
                 
                },
                error: function (response) {
                 
                }
            }); 
        }

        function locationStore(data){

            
            for (var i = 0; i < data.length; i++) {
              
                var location_data = {   "lat"   : data[i].latitude, 
                                        "lng"   : data[i].longitude,
                                        "angle" : data[i].angle
                                    };                   
                location_data_que.push(location_data);
                isDataLoadInProgress = false;
                if( data.total_offset == offset)
                {
                    dataLoadingCompleted = true;
                    console.log('data loading completed');
                }                     
            }
        }

        function plotLocationOnMap()
        {
            console.log('Current length '+location_data_que.length);
            if(location_data_que.length >0)
            {
               
                moveMap(location_data_que[0].lat,location_data_que[0].lng);

                if( (startPointLatitude != null) && (startPointLongitude!=null) )
                {
                    endPointLatitude    = location_data_que[0].lat;
                    endPointLongitude   = location_data_que[0].lng;
                    // calculate the direction of movement   
                    var direction = calculateCarDirection(startPointLatitude,startPointLongitude,endPointLatitude,endPointLongitude);

                    console.log('direction' + direction);

                    moveMarker(direction,endPointLatitude,endPointLongitude);
                    addPolylineToMap(startPointLatitude,startPointLongitude,endPointLatitude,endPointLongitude);
                }
                startPointLatitude  = location_data_que[0].lat;
                startPointLongitude = location_data_que[0].lng;
                // remove the already plotted locations
                popFromLocationQueue();
                // want to load new set of data ?
                if( (location_data_que.length <= 29) && (!isDataLoadInProgress) && (!dataLoadingCompleted) )
                {
                    console.log('Loading fresh set of data');
                    getLocationData();
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
                console.log('no more map updation calls');
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
            lineString, { style: { lineWidth: 4 }}
          ));
        }

        function moveMarker(RotateDegree,lat,lng){
            if ((bearsMarkeronStartPoint != null) && (blPlaceCaronMap == true)) {
                map.removeObject(bearsMarkeronStartPoint);
                blPlaceCaronMap = false;
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
            var domIcon = new H.map.DomIcon(outerElement);
            bearsMarkeronStartPoint = new H.map.DomMarker({ lat:lat, lng:lng }, {
                icon: domIcon
            });
            map.addObject(bearsMarkeronStartPoint);
            blPlaceCaronMap = true;
            
        }


    </script>


    <script src="{{asset('playback_assets/assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js')}}"></script>
    <script type="text/javascript"
     src="{{asset('playback/assets/js/bootstrap-datetimepicker.min.js')}}">
    </script>
    <script type="text/javascript">
      $('#datetimepicker_live1').datetimepicker({
        format: 'yyyy-MM-dd HH:mm:ss',
   
      });
    </script>
    <script type="text/javascript">
      $('#datetimepicker_live2').datetimepicker({
        format: 'yyyy-MM-dd HH:mm:ss',
      });
    </script>


</body>
</html>