@extends('layouts.gps') 
@section('title')
   Geofence View
@endsection
@section('content')
    <section class="content-header">
     <h1>Geofence View</h1>
    </section>
    @if(Session::has('message'))
    <div class="pad margin no-print">
      <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
          {{ Session::get('message') }}  
      </div>
    </div>
    @endif  
  <section class="content">
    <div style="position: absolute;">
      <div id="map" style="position: "></div>
    </div>
  </section>
  @section('script')
    <script src="{{asset('js/gps/geofence-details.js')}}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDl9Ioh5neacm3nsLzjFxatLh1ac86tNgE&libraries=drawing&callback=initMap"
         async defer></script>
    @endsection
    @endsection
