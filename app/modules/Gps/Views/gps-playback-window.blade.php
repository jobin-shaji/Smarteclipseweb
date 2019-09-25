<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Vehicle Playback</title>

    <link rel='stylesheet' href='https://api.tiles.mapbox.com/mapbox.js/v1.6.4/mapbox.css' />
    <link rel="stylesheet" type="text/css" href="{{asset('css/h-style.css')}}">
</head>

<body>
    <div id="map"></div>
    <div class="dateTimeBox box">
      
        <div class="controls">
            <button type="button" class="btn btn-default btn-xs slower"><span class="glyphicon glyphicon-backward"></span>
                Slower</button>
            <button type="button" class="btn btn-default btn-xs faster">Faster <span class="glyphicon glyphicon-forward"></span>
            </button>
        </div>
        <div>Time Factor: <span class="timeFactor"></span> minutes per second</div>
    </div>
    



    <script src="{{asset('js/h-moment.js')}}"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://d3js.org/d3.v3.min.js"></script>
    <script src="http://cdn.leafletjs.com/leaflet-0.7.2/leaflet.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script src="{{asset('js/h-script.js')}}"></script>
    <script src="{{asset('js/gps/gps-playback_data.js')}}"></script>

     
</body>

</html>