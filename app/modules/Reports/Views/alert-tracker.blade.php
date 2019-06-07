@extends('layouts.gps') 
@section('title')
   Alert View
@endsection
@section('content')
    <section class="content-header">
     <h1>Alert View</h1>
    </section>
    @if(Session::has('message'))
    <div class="pad margin no-print">
      <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
          {{ Session::get('message') }}  
      </div>
    </div>
    @endif  
  <section class="content">
    <input type="hidden" name="hd_id" id="hd_id" value="{{$alert_id}}">
    <input type="hidden" name="lat" id="lat" value="{{$alertmap->latitude}}">
    <input type="hidden" name="lng" id="lng" value="{{$alertmap->longitude}}">
     <div style="position: absolute;">
      <div id="map" style="position: "></div>
    </div>
  </section>
  @section('script')
    <script src="{{asset('js/gps/alert-track.js')}}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDl9Ioh5neacm3nsLzjFxatLh1ac86tNgE&libraries=drawing&callback=initMap"
         async defer></script>
    @endsection
    @endsection
