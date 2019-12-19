<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title> <?php
        $url=url()->current();
        $rayfleet_key="rayfleet";
        $eclipse_key="eclipse";
        if (strpos($url, $rayfleet_key) == true) {  ?>
            Rayfleet
        <?php }else{ ?>
            Eclipse
        <?php } ?> </title>

      <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
      <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{asset('playback/assets/img/icon.png')}}" type="image/x-icon" />
    <!-- Fonts and icons -->
     <!-- <link rel="stylesheet" href="{{asset('playback_assets/assets/css/bootstrap.min.css')}}"> -->
    <!-- <link rel="stylesheet" href="{{asset('playback_assets/assets/css/atlantis.min.css')}}"> -->
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <!-- <link rel="stylesheet" href="{{asset('playback_assets/assets/css/demo.css')}}"> -->

    <script src="{{asset('playback/assets/Scripts/jquery-3.3.1.js')}}"></script>
    <script src="{{asset('playback/assets/Scripts/jquery-3.3.1.min.js')}}"></script>
     <script src="{{asset('playback_assets/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.4.0/jszip.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://js.api.here.com/v3/3.0/mapsjs-ui.css?dp-version=1549984893" />
    <link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="screen"
     href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">


</head>


    <div class="wrapper overlay-sidebar">
{{csrf_field()}}
  <input type="hidden" name="vid" id="vehicle_id" value="{{$vehicle_id}}" > 

   

<div class="top-date">
          <div id="datetimepicker_live1" class="input-append date" style="margin-bottom: 0px!important">
            <div  style="float: left;margin-left: 2%">
              <label style="font-weight:bold">Start Date</label>
              <input type="text" id="fromDate" name="fromDate">
              <span class="add-on">
                <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
              </span>
            </div>
          </div>
          <div id="datetimepicker_live2" class="input-append date" style="margin-bottom: 0px!important">
            <div style="float: left;margin-left: 2%">
              <label style="font-weight:bold">End Date</label>
              <input type="text" id="toDate" name="toDate">
              <span class="add-on">
                <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
              </span>
            </div>
          </div>


            <div>
            <div style="float: left;margin-left: 2%">

              <label style="font-weight:bold">Speed</label>
              <select name="speed" id="speed">
                  <option value="1">1X</option>
                  <option value="2">2X</option>
                  <option value="3">3X</option>
                  <option value="4">4X</option>
                  <option value="5">5X</option>
                  <option value="6">6X</option>
              </select>
            </div>
          </div>

          <div class="contoller" style="float: left; margin-left: 15px;margin-top: 25px;">
                         
              <button class="btn btn-primary btn-sm" onclick="startPlayBack()" id="btnPlay">Play</button>

           
          </div>
             <div class="contoller" style="float: left; margin-left: 15px;;margin-top: 25px;">
            <span class="contoller">                           
              <button class="btn btn-primary btn-sm" onclick="getLocationData()" id="btnPlay">pause</button>

            </span>
          </div>
             <div class="contoller" style="float: left; margin-left: 15px;margin-top: 25px;">
            <span class="contoller">                           
              <button class="btn btn-primary btn-sm" onclick="getLocationData()" id="btnPlay">Stop</button>

            </span>
          </div>
          
</div>

        <div class="main-panel main-pane-bg">
            <div class="content">
                <!--<div id="markers" style="width:1800px;height:780px"></div>-->
                <div id="markers" style="width:100%px;height:595px; position: relative;">
                    <div class="left-alert-box">
                    <div class="left-alert-inner">
                            <div class="left-alert-text">
                                <h5>Heading</h5>
                             <p>Place</p>
                                <p>alert count
       <a href="#">
          +
        </a>
                                </p>  
                                <p>05:28:22 03-12-19</p>

                                <div class="left-alert-time"></div>
                            </div>

                        </div>

                             <div class="left-alert-inner">
                            <div class="left-alert-text">
                                <h5>Heading</h5>
                             <p>Place</p>
                                <p>alert count
       <a href="#">
          +
        </a>
                                </p>  
                                <p>05:28:22 03-12-19</p>

                                <div class="left-alert-time"></div>
                            </div>

                        </div>

                                <div class="left-alert-inner">
                            <div class="left-alert-text">
                                <h5>Heading</h5>
                             <p>Place</p>
                                <p>alert count
       <a href="#">
          +
        </a>
                                </p>  
                                <p>05:28:22 03-12-19</p>

                                <div class="left-alert-time"></div>
                            </div>

                        </div>
                         <div class="left-alert-inner">
                            <div class="left-alert-text">
                                <h5>Heading</h5>
                             <p>Place</p>
                                <p>alert count
       <a href="#">
          +
        </a>
                                </p>  
                                <p>05:28:22 03-12-19</p>

                                <div class="left-alert-time"></div>
                            </div>

                        </div>

                    </div>


                </div>
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
.left-alert-box{
           width: 20%;
    float: left;
    display: block;
    max-height: 500px;
    background-color: #fff;
    /* border: 1px solid #dee2e6; */
    position: absolute;
    z-index: 99;
    padding: 0 0px;
    left: 0;
    overflow-y: scroll;}
    .left-alert-inner{
    width: 90%;
    float: left;
    display: block;
    background: #fff;
    padding: 10px 0;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    border-radius: 4px;
    margin: 10px 5%;

    }
     .left-alert-text
     {
    width: 94%;
    float: left;
    margin: 0 3% 0px;
    padding: 5px 0;

     }

   .left-alert-text h5{
width: 100%;
    float: left;
    font-size: 16px;
    display: block;
    font-weight: normal;
    text-transform: uppercase;
    margin: 0;
    padding-bottom: 10px;
    color: #f0b102;
    border-bottom: 1px solid #dcdcdc;
   }
        .left-alert-text p{
            width: 100%;
            float: left;
                font-size: 15px;
            display: block;
            margin: 0;
            padding: 8px 0;
   
        }
.left-alert-time{
width: 100%;
float: right;
display: block;
text-align: right;

}
.alert-plus-bt{
padding: 5px 10px;
    font-size: 12px;
    line-height: 1.5;
    border-radius: 3px;

}
.left-alert-text p a{
    color: #fff;
    float: right;
    padding: 3px 7px;
    background: #f0b101;
    border-radius: 52%;
    text-decoration: none;
    /* font-weight: bold; */
    font-size: 20px;}
.place-div{
    margin: 0;
    width: 100%;
    margin-bottom: 15px;
    border-radius: 0;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
}

.place-div .left-alert-text {
    width: 88%;
    float: left;
    margin: 0 6% 0px;
    padding: 5px 0;
}
.top-date{

    width: 100%;
    float: left;
    display: block;
    padding: 10px 0 20px;
}
.main-pane-bg{
        width: 100%;
    float: left;
}


@media only screen and (max-width: 1400px)  {}


    </style>
    <!-- Style -->
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
        var objImg                   = document.createElement('img');
        var vehicle_online      =   '{{asset("playback/assets/img/car_online.png")}}';
        var vehicle_halt        =   '{{asset("playback/assets/img/car_halt.png")}}';
        var vehicle_sleep       =   '{{asset("playback/assets/img/car_sleep.png")}}';
        var vehicle_offline     =   '{{asset("playback/assets/img/car_offline.png")}}';
        var outerElement        = document.createElement('div')
        var domIcon             = new H.map.DomIcon(outerElement);
        var start_icon          = new H.map.Icon('{{asset("playback/assets/img/start.png")}}');
        var stop_icon           = new H.map.Icon('{{asset("playback/assets/img/flag.png")}}');
        var hidpi               = ('devicePixelRatio' in window && devicePixelRatio > 1);
        var secure              = (location.protocol === 'https:') ? true : false; // check if the site was loaded via secure connection
        var app_id              = "vvfyuslVdzP04AK3BlBq",
            app_code            = "f63d__fBLLCuREIGNr6BjQ";
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
        var offset=1;
        var isDataLoadInProgress = false;
        var dataLoadingCompleted = false;
        var vehicle_mode;
        var previousCoorinates;
        var blacklineStyle;
        var speed_val            = 1;
        var Speed                = 600;
    
         

        var locationQueue       = [];

         
        function startPlayBack(){
                speed_val   =   $('#speed').val();
                speed       =   speed/speed_val;
                getLocationData();
        }
        function getLocationData(){
             var mapUpdateInterval   = window.setInterval(function(){
            plotLocationOnMap();
             }, Speed);

            isDataLoadInProgress = true;
           var Objdata = {
                vehicleid: 7, 
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

                    if( typeof response.playback != undefined)
                    {


                        total_offset=response.total_offset;
                        if(offset < total_offset){
                         locationStore(response.playback);
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

        function locationStore(data)
        {
            for (var i = 0; i < data.length; i++)
            {

                   location_data_que.push({   
                            "lat"   : data[i].latitude, 
                            "lng"   : data[i].longitude,
                            "angle" : data[i].angle,
                            "mode"  : data[i].vehicleStatus
                        });

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
                    var direction = calculateCarDirection(startPointLatitude,startPointLongitude,endPointLatitude,endPointLongitude);

                    moveMarker(direction,endPointLatitude,endPointLongitude,vehicle_mode);
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

                // stop point
                if(last_offset==true && location_data_que.length==0){
                     
                     var flag = new H.map.Marker({lat:startPointLatitude, lng:startPointLongitude},{ icon: stop_icon});
                     map.addObject(flag);
                }
                // stop point
                
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
            lineString, { style: { lineWidth: 6 ,
                                    strokeColor: 'rgb(25, 25, 25,0.8)'
                                 }}
          ));
        }

        function moveMarker(RotateDegree,lat,lng,vehicle_mode){
            console.log('mode '+vehicle_mode);
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
            outerElement.style.top = "-30px";
            outerElement.style.width = "200px";

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