@extends('layouts.eclipse')
@section('content')


<section class="content box">
<div class="page-wrapper_new_map">

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
</div>
</section>




@section('script')
    <script src="{{asset('js/h-moment.js')}}"></script>
<!--     <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> -->
    <script src="https://d3js.org/d3.v3.min.js"></script>
    <script src="http://cdn.leafletjs.com/leaflet-0.7.2/leaflet.js"></script>
<!--     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script> -->
    <script src="{{asset('js/h-script.js')}}"></script>
   <!--  <script>
        $(document).ready(function () {

            execCommand("http://app.gpsvst.vehiclest.com/api/v1/location_data", "POST", JSON.stringify({
                "imei": "868997036366951",
                "from_date": "2019-09-02 15:42:04",
                "to_date": "2019-09-02 15:42:04"
            }), function (data1, status) {
               process(data1.locations);
            });

            // process(sample.locations);

        })
    </script> -->
@endsection
@endsection