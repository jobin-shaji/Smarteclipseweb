<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Smart Eclipse Monitoring Panel</title>

      <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{asset('smart/assets/img/allicons/favicon.ico')}}" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://js.api.here.com/v3/3.0/mapsjs-ui.css?dp-version=1549984893" />
    <link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
    <link href="{{ url('/') }}/dist/css/playback_style.css" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('alertify/css/alertify.min.css')}}" />
    <link rel="stylesheet" href="{{asset('alertify/css/themes/default.min.css')}}" />

    <script src="{{asset('playback/assets/Scripts/jquery-3.3.1.js')}}"></script>
    <script src="{{asset('playback/assets/Scripts/jquery-3.3.1.min.js')}}"></script>
     <script src="{{asset('playback_assets/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.4.0/jszip.min.js"></script>

    <script src="{{asset('alertify/alertify.min.js')}}"></script>

</head>

<div class="wrapper overlay-sidebar">




      

        <div class="main-panel main-pane-bg">
            <div class="content map-outer">
              <div class="lorder-cover-bg" id="lorder-cover-bg-image">
                <div class="lorder-cover-bg-image" >
                   <img id="loading-image" src="{{asset('playback/assets/img/loader.gif')}}" />
               </div>
               </div>
               <div class ="cover_bell_icon">
                 <div class ="bell_icon_image">
                  <img src="{{asset('images/bell.png')}}">
                  <span id ="cover_alert_count" class="alert_count_bell">
                    0
                  </span>
                 </div>
               </div>
                <!--<div id="markers" style="width:1800px;height:780px"></div>-->
                <div id="markers" style="width:100%;height:100vh; position: relative;">
      
                </div>
               
            </div>
        </div>
    </div>
    <style type="text/css">
      .map-outer{
        position: relative;
      }
      .cover_bell_icon
      {
        position: absolute;
    z-index: 9;
    display: block;
      }
      .bell_icon_image{
        position: relative;
        width: 80px;
        float: left;
      }
      .bell_icon_image img
      {margin-top: 12px;}
       .bell_icon_image span
      {
    
    position: absolute;
    top: 5px;
    background: #f00;
    color: #fff;
    border-radius: 50%;
    line-height: 23px;
    width: auto;
    height: auto;
    padding-top: 2px;
    top: 12px;
    right: 16px;
    padding: 5px 8px;
    font-size: 19px;
    text-align: center;
      }
    
    </style>

    <audio id="myAudio">
      <source src="../assets/sounds/alerts.mp3" type="audio/ogg">
      <source src="../assets/sounds/alerts.mp3" type="audio/mpeg">
    </audio>


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
      
    <script>
        var remove_marker_flag = false;
        var map_markers;
        
        var audio               = document.getElementById("myAudio");
        var pauseMapRendering = false;
        var bearsMarkeronStartPoint;
        var bearsMarker;
        var hidpi = ('devicePixelRatio' in window && devicePixelRatio > 1);
      
        var secure              = (location.protocol === 'https:') ? true : false; // check if the site was loaded via secure connection
        var app_id              = "RN9UIyGura2lyToc9aPg",
           app_code            = "4YMdYfSTVVe1MOD_bDp_ZA";
        var mapContainer        = document.getElementById('markers');
        var platform            = new H.service.Platform({ app_code: app_code, app_id: app_id, useHTTPS: secure });
        var maptypes            = platform.createDefaultLayers(hidpi ? 512 : 256, hidpi ? 320 : null);  
        var map = new H.Map(mapContainer, maptypes.normal.map);
        map.setCenter({ lat: 21.7679, lng: 78.8718 });
        map.setZoom(5);

        var zoomToResult = true;
        var mapTileService = platform.getMapTileService({
            type: 'base'
        });
        var parameters = {};
        var uTurn = false;
        new H.mapevents.Behavior(new H.mapevents.MapEvents(map)); // add behavior control
        var ui = H.ui.UI.createDefault(map, maptypes); // add UI

        var locationQueue = [];
        var location_data = [];
        var location_alert_ids = [];

        var first_set_data = 1;
          var alert_icon          = '{{asset("playback/assets/img/alert-icon.gif")}}';
        var  group = new H.map.Group();
        


        var outerElement = document.createElement('div'),
         objImg  = document.createElement('img');
         innerElement = document.createElement('div');
   
  

         objImg.src = alert_icon;
         el = objImg;
          outerElement.appendChild(el);
           outerElement.style.top = "-25px";
           outerElement.style.left = "-25px";
           outerElement.style.width = "150px";

       
        var domIcon = new H.map.DomIcon(outerElement);


  $(document).ready(function(){
    $('.mlt').click(function(){
        current_active_tab = $(this).attr('value');
    });

    setInterval(function(){
        $.ajax({
            type    :'POST',
            url     : 'check-emergency-alerts',
            data    : {},
            async   : true,
            headers : {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (res){
                // prepare content
                if(res.data.length > 0)
                {    
                  remove_marker_flag =true;
                  if(res.data.length < location_data.length)
                   {
                    
                    map.removeObject(group);
                    group.removeObject(map_markers);
                    console.log("data -- data");
                    // group = new H.map.Group();
                    location_data  = [];
                   }   
                   res.data.forEach(function(vehicle_alerts)
                    {
                      if(vehicle_alerts.emergency_status == 1)
                      {
                        alert_title = "Emergency Alert";
                      }
                      else if(vehicle_alerts.tilt_status == 1)
                      {
                        alert_title = "Tilt Alert";
                      }
                      else
                      {
                        alert_title = "Alert";
                      }
                      // console.log(vehicle_alerts);
                      var need_to_append   = true;
                      
                      location_data.forEach(function(location_alerts){

                        
                         if(location_data.length > 0){

                          if(vehicle_alerts.id == location_alerts.alert_id)
                            {
                                need_to_append = false;
                                return false;
                               // critical_alerts.push(alert);
                            }
                          }
                        
                       });
                      if(need_to_append)
                        {
                        var location_alerts = {
                        "alert_id" : vehicle_alerts.id,
                        "latitude" : vehicle_alerts.lat,
                        "longitude": vehicle_alerts.lon
                        } ;
                       location_data.push(location_alerts); 
                       $('#cover_alert_count').text(location_data.length);
                        addInfoBubble(vehicle_alerts.lat,
                                      vehicle_alerts.lon,
                                      vehicle_alerts.id,
                                      alert_title,
                                      vehicle_alerts.vehicle.client.name,
                                      vehicle_alerts.vehicle.name,
                                      vehicle_alerts.vehicle.register_number,
                                      vehicle_alerts.imei,
                                      vehicle_alerts.serial_no
                                      );
                        
                      }
                
                         

                });     
            }else{
              if(remove_marker_flag==true)
              {
                console.log("last data");
               location_data  = [];
               map.removeObject(group);
               group.removeObject(map_markers);
                

                $('#cover_alert_count').text(location_data.length);
                remove_marker_flag = false;
              }
            }
        }
         });
       }, 5000); 
    
         });


        function addMarkerToGroup(group, coordinate, html,alert_id) {
          map_markers = new H.map.DomMarker(coordinate,{icon: domIcon});
          map_markers.setData(html);
          group.addObject(map_markers);
           map.addObject(group);

        }

        // bearsMarkeronStartPoint = new H.map.DomMarker({ lat:lat, lng:lng }, {
        //         icon: domIcon
        //     });
        //     map.addObject(bearsMarkeronStartPoint);

        function addInfoBubble(lat,lng,alert_id,alert,owner_name,vehicle_name,vehicle_regno,imei,serial_no) {
       
       
          group.addEventListener('tap', function (evt) {
            var bubble =  new H.ui.InfoBubble(evt.target.getGeometry(), {
              content: evt.target.getData()
            });
            ui.addBubble(bubble);
          }, false);

          var message ='<table style="font-size: 15px;">'+
          '<tr>'+
          '<td><i class="fa fa-exclamation-triangle"></i>:</td>'+
          '<td>'+alert+'</td>'+
          '</tr><tr>'+
          '<td><i class="fa fa-user"></i>:</td>'+
          '<td>'+owner_name+'</td>'+
          '</tr><tr>'+
          '<td><i class="fa fa-id-card-o"></i>:</td>'+
          '<td>'+vehicle_name+'</td>'+
          '</tr><tr>'+
          '<td><i class="fa fa-window-maximize"></i>:</td>'+
          '<td>'+vehicle_regno+'</td>'+
          '</tr><tr>'+
          '<td><i class="fa fa-tablet"></i>:</td>'+
          '<td>'+imei+'</td>'+
          '</tr><tr>'+
          '<td><i class="fa fa-tag"></i>:</td>'+
          '<td>'+serial_no+'</td>'+
          '</tr>'
          '</table>'
          addMarkerToGroup(group, {lat:lat, lng:lng},
            message,alert_id);

          map.setZoom(12);
          map.setCenter({lat:lat, lng:lng});
          audio.play();
          }




    </script>


 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script>


</body>
</html>