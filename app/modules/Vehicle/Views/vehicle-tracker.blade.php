@extends('layouts.gps')

@section('content')

  <section class="content-header">
        <h1>
          Live Track
          <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Live Track</li>
        </ol>
  </section>

  <section class="content">
    <div style="position: absolute;">
      <div id="map" style="position: "></div>
    </div>
  </section>

    @section('script')
      
  
   <script src="{{asset('js/gps/location-track.js')}}"></script>
 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDl9Ioh5neacm3nsLzjFxatLh1ac86tNgE&libraries=drawing&callback=initMap"
         async defer></script>
    @endsection

@endsection