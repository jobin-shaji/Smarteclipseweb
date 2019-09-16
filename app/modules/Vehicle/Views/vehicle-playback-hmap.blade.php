@extends('layouts.eclipse')
@section('content')
  <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html#"><span class="glyphicon glyphicon-road    "></span> VST trips
                    visualization through XYZ</a>
            </div>
        </div>
    </div>
    <div id="map">

    </div>
    <!-- <div class="container overlay">
        <div class="jumbotron">
            <h1>XYZ Taxi Trips</h1>
            <p>Select a Random Taxi</p><br />
            <div>
                <table class="table">
                    <tr>
                        <td>Taxi 1</td>
                        <td><a class="btn btn-primary btn-lg taxi" id="taxi1">Play</a></td>
                    </tr>
                    <tr>
                        <td>Taxi 2</td>
                        <td><a class="btn btn-primary btn-lg taxi" id="taxi2">Play</a></td>
                    </tr>
                </table>
            </div>
            <br />
            <div class="badges">

            </div>
        </div>
    </div> -->



    <div class="dateTimeBox box">
        <!-- <div class="date"></div>
        <div class="time"><span class="glyphicon glyphicon-time"></span> <span class="readableTime"></span></div>
       -->
        <div class="controls">
            <button type="button" class="btn btn-default btn-xs slower"><span class="glyphicon glyphicon-backward"></span>
                Slower</button>
            <button type="button" class="btn btn-default btn-xs faster">Faster <span class="glyphicon glyphicon-forward"></span>
            </button>
        </div>
        <div>Time Factor: <span class="timeFactor"></span> minutes per second</div>
    </div>
    <div class="legendBox box">
        <div class="boxHeader"><span class="glyphicon glyphicon-map-marker"></span> Legend</div>
        <div class='legendItem'>
            <svg>
                <circle r="5" id="marker" transform="translate(20,20)"></circle>
            </svg>
            <p>Vehicle</p>
        </div>
        <!-- <div class='legendItem'>
            <svg>
                <circle r="20" id="marker" transform="translate(20,20)" style="opacity:0.30000000000000004"></circle>
            </svg>
            <p>Empty Taxi<sup>*</sup></p>
        </div> -->
        <div class='legendItem'>
            <svg>
                <circle r="5" class="startPoint" transform="translate(20,20)"></circle>
            </svg>
            <p>Vehicle Start Point</p>
        </div>
        <div class='legendItem'>
            <svg>
                <circle r="5" class="endPoint" transform="translate(20,20)"></circle>
            </svg>
            <p>Vehicle End Point</p>
        </div>
        <div class='legendItem'>
            <svg>
                <path class="trip true" style="opacity:.7" d="M10,10L30,30"></path>
            </svg>
            <p>Vehicle Route<sup>*</sup></p>
        </div>
    </div>

    <!-- <div class="newBox box">
        <button type="button" class="btn btn-default btn-lg reload">
            <span class="glyphicon glyphicon-refresh"></span> Load Another Trip!
        </button>
    </div> -->




@section('script')
    <script src="{{asset('js/h-moment.js')}}"></script>
<!--     <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> -->
    <script src="https://d3js.org/d3.v3.min.js"></script>
    <script src="http://cdn.leafletjs.com/leaflet-0.7.2/leaflet.js"></script>
<!--     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script> -->
    <script src="{{asset('js/h-script.js')}}"></script>

    <script>
        $(document).ready(function () {

            execCommand("https://app.gpsvst.vehiclest.com/api/v1/location_data", "POST", JSON.stringify({
                "imei": "868997036366951",
                "from_date": "2019-09-02 15:42:04",
                "to_date": "2019-09-03 15:42:04"
            }), function (data1, status) {
               process(data1.locations);
            });

            // process(sample.locations);

        })
    </script>

@endsection
@endsection