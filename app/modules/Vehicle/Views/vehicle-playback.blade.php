@extends('layouts.gps')

@section('content')

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


      <input type="hidden" name="vid" id="vehicle_id" value="{{$Vehicle_id}}">
                      
         <div class="panel-heading">
                  <label> From Date</label>
                  <input type="text" id="fromDate" name="fromDate">
                  <label> To date</label>
                  <input type="text" id="toDate" name="toDate">
                  <button class="btn btn-xs btn-info" onclick="check()"> <i class="fa fa-filter"></i> Playback </button>                 
              </div>               

        <div id="map" style="width:100%;height:500px;"></div>
    </div>
    </div>
</section>

@section('script')

<script src="{{asset('js/gps/location-playback.js')}}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDl9Ioh5neacm3nsLzjFxatLh1ac86tNgE&libraries=drawing&callback=initMap" async defer></script>
@endsection

@endsection