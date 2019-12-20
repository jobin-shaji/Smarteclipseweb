<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Vehicle Live Track</title>

      <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{asset('playback/assets/img/icon.png')}}" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
<input type="hidden" name="vid" id="vehicle_id" value="{{$vehicle_id}}">

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
        <input type="hidden" name="online_icon" id="online_icon" value="{{$vehicle_type->online_icon}}">
        <input type="hidden" name="offline_icon" id="offline_icon" value="{{$vehicle_type->offline_icon}}">
        <input type="hidden" name="ideal_icon" id="ideal_icon" value="{{$vehicle_type->ideal_icon}}">
        <input type="hidden" name="sleep_icon" id="sleep_icon" value="{{$vehicle_type->sleep_icon}}">

        <div class="main-panel main-pane-bg">
            <div class="content">
              <div class="lorder-cover-bg" id="lorder-cover-bg-image">
                <div class="lorder-cover-bg-image" >
                   <img id="loading-image" src="{{asset('playback/assets/img/loader.gif')}}" />
               </div>
               </div>
                <!--<div id="markers" style="width:1800px;height:780px"></div>-->
                <div id="markers" style="width:100%px;height:595px; position: relative;">
                 
                    <div class="left-alert-box">
                    <div id="details" class="left-alert-inner">  
                       <span id="location_details">
                        <h1 data-text="It's loading…" id="location_details_text">It's loading…</h1>
                    </span>                     
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


     
   #location_details_text {
    position: relative;
    color: rgba(0, 0, 0, .3);
    font-size: 1em
   }
  #location_details_text:before {
    content: attr(data-text);
    position: absolute;
    overflow: hidden;
    max-width: 7em;
    white-space: nowrap;
    color: #dab606;
    animation: loading 8s linear;
  }
@keyframes loading {
    0% {
        max-width: 0;
    }
}
h1#location_details_text {
    margin-left: 45px;
}
    .lorder-cover-bg {
    width: 100%;
    position: absolute;
    z-index: 9;
    background: #00000075;
    height: 595px;
    display: none;
}
     .lorder-cover-bg-image{
        width: 75px;
        margin: 0px auto;
     }
          .lorder-cover-bg-image img{
       width: 100%;
    padding-top: 280px;
          }
         .lorder-cover-bg-image span{
            width: 100%;
            float: left;
            text-align: center;
         }
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

.place_data{
    padding-right: 10px;
    font-weight: bold;
    color: #dab606;
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
    padding: 0 0;

     }
     .left-alert-text p.datetime_cover{
        text-align: right;
        font-weight: bold;
        margin-top: 16px;
        font-size: 11px;
        padding: 5px 0 0;
        color: #86710b;
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
            padding: 5px 0;
   
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
        var location_details_que =  new Array();

        var offset=1;
        var isDataLoadInProgress = false;
        var dataLoadingCompleted = false;
        var vehicle_mode;
        var previousCoorinates;
        var blacklineStyle;
        var speed_val            = 1;
        var Speed                = 600;
        var loader               = false;
    
         

        var locationQueue       = [];

         
        function startPlayBack(){
           



                loader      =   true;
                speed_val   =   $('#speed').val();
                speed       =   speed/speed_val;

                if(loader == true){
                 $("#lorder-cover-bg-image").css("display","block");
                }

                getLocationData();
               $('.left-alert-box').css('display','block');

               


        }

        function getLocationData(){
             
             var mapUpdateInterval   = window.setInterval(function(){
             plotLocationOnMap();
             }, Speed);
            // --------2019-12-19-2:20--------------------------------------------------------
            var mapUpdateInterval   = window.setInterval(function(){
             dataShownOnList();
             }, 500);
            // --------2019-12-19-2:20--------------------------------------------------------
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
                    console.log('data loading completed');
                } 


              
                  
            }
        }

     

        function plotLocationOnMap()
        {
            console.log('Current length '+location_data_que.length);
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
            outerElement.style.top = "-25px";
            outerElement.style.width = "200px";

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
                console.log(location_details_que.length);
                // for(i=0;i<=location_details_que.length)
               console.log(location_details_que);
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


              var details = ' <div class="left-alert-text">'+
                                '<h5></h5>'+
                             '<p class="location_name" id="location_name">'+
                             '<span class="place_data"><i class="fa fa-map-marker" aria-hidden="true"></i></span>'+location_name+'</p>'+
                              '<p><span class="place_data"><i class="fa fa-car" aria-hidden="true"></i></span>'+status+'</p>'+
                              '<p><span class="place_data">'+
                              '<i class="fa fa-tachometer" aria-hidden="true"></i></span>'+ Number(speed).toString()+
                                ' km/h <p class="datetime_cover" id="date">'+date+'</p>'+
                                '<div class="left-alert-time"></div>'+
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
                console.log('no more map updation calls');
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
                console.log('no more map updation calls');
                return null;
            }
        }


       // --------2019-12-19-2:20-------------------------------------------------------
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