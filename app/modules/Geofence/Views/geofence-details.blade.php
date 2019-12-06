@extends('layouts.eclipse')
@section('title')
  View Geofence
@endsection
@section('content')

<!-- ============================================================== -->
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper_new_map">
  <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Geofence View</li>
        <b>Geofence View</b>
     </ol>
     @if(Session::has('message'))
          <div class="pad margin no-print">
            <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
                {{ Session::get('message') }}  
            </div>
          </div>
        @endif 
    </nav>
 
            
    <input type="hidden" name="hd_id" id="g_id" value="{{$id}}">
    <div class="row">
      <div class="col-md-4">
        <span><b>Name</b> : {{$geofence->name}}</span>
      </div>
      <div class="col-md-4">
        <span><b>Created At</b> : {{($geofence->created_at)}}</span>
      </div>
      <div class="col-md-4">
        <span><b>Updated At</b> : {{($geofence->updated_at)}}</span>
      </div>
    </div>
           
    <div id="map" style=" width:100%;height:520px; margin-top: 10px;"></div>

</div>
@endsection

  @section('script')
    <script src="{{asset('js/gps/geofence-details.js')}}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAyB1CKiPIUXABe5DhoKPrVRYoY60aeigo&libraries=drawing&callback=initMap"
         async defer></script>
  @endsection
  