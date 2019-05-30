@extends('layouts.gps')

@section('content')
    <meta name="viewport" content="initial-scale=1.0, 
      width=device-width" />
    <script src="http://js.api.here.com/v3/3.0/mapsjs-core.js" 
      type="text/javascript" charset="utf-8"></script>
    <script src="http://js.api.here.com/v3/3.0/mapsjs-service.js" 
      type="text/javascript" charset="utf-8"></script>
    <script src="http://js.api.here.com/v3/3.0/mapsjs-ui.js" 
      type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" type="text/css" 
      href="http://js.api.here.com/v3/3.0/mapsjs-ui.css" />
      <script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-mapevents.js"></script>


      
<section class="content-header">
    <h1>
        Playback
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">PlayBack</li>
    </ol>
</section>
<input type="hidden" name="vid" id="vehicle_id" value="{{$Vehicle_id}}">
<section class="content box">
  <div class="row">
    <div class="col-lg-12 col-sm-12">


                    
         <div class="panel-heading">
                   <label> From Date</label>
                  <input type="text" class="datetimepicker" id="fromDate" name="fromDate">
                  <label> To date</label>
                  <input type="text" class="datetimepicker" id="toDate" name="toDate">

                  <button class="btn btn-xs btn-info" onclick="playback()"> <i class="fa fa-filter"></i> Playback </button>                 
              </div>               
             <div id="mapContainer" style="width:100%;height:500px;"></div>
        <!-- <div id="map" style="width:100%;height:500px;"></div> -->
    </div>
    </div>
</section>

@section('script')

<script src="{{asset('js/gps/ui.js')}}"></script>
<script src="{{asset('js/gps/location-playback-hmap.js')}}"></script>

@endsection

@endsection