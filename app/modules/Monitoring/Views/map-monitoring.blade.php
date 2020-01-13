<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Alert Listing</title>

      <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{asset('playback/assets/img/icon.png')}}" type="image/x-icon" />
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
            <div class="content">
              <div class="lorder-cover-bg" id="lorder-cover-bg-image">
                <div class="lorder-cover-bg-image" >
                   <img id="loading-image" src="{{asset('playback/assets/img/loader.gif')}}" />
               </div>
               </div>
                <!--<div id="markers" style="width:1800px;height:780px"></div>-->
                <div id="markers" style="width:100%px;height:595px; position: relative;">
      
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
      
    <script>
        var pauseMapRendering = false;
        var bearsMarkeronStartPoint;
        var bearsMarker;
        var hidpi = ('devicePixelRatio' in window && devicePixelRatio > 1);
        var alert_icon = new H.map.Icon('{{asset("playback/assets/img/alert-icon.png")}}');
        var secure              = (location.protocol === 'https:') ? true : false; // check if the site was loaded via secure connection
        var app_id              = "RN9UIyGura2lyToc9aPg",
           app_code            = "4YMdYfSTVVe1MOD_bDp_ZA";
        var mapContainer        = document.getElementById('markers');
        var platform            = new H.service.Platform({ app_code: app_code, app_id: app_id, useHTTPS: secure });
        var maptypes            = platform.createDefaultLayers(hidpi ? 512 : 256, hidpi ? 320 : null);  
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
    </script>


 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script>


</body>
</html>