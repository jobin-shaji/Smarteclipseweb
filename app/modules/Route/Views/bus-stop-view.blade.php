@extends('layouts.eclipse')
@section('title')
  Bus Stop Details
@endsection
@section('content')   
@if(Session::has('message'))
<div class="pad margin no-print">
  <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
      {{ Session::get('message') }}  
  </div>
</div>
@endif  

<section class="hilite-content">
  <div class="page-wrapper_new">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Bus Stop Details</li>
        <b>Bus Stop Details</b>
      </ol>
      @if(Session::has('message'))
        <div class="pad margin no-print">
          <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
              {{ Session::get('message') }}  
          </div>
        </div>
      @endif  
    </nav>
    <div class="container-fluid">
      <div class="card" style="margin:0 0 0 1%">
        <div class="card-body wizard-content">
          <div class="row">
            <div class="col-lg-6 col-md-12">
              <div class="form-group row" style="float:none!important">
                <label for="fname" class="col-sm-3 text-right control-label col-form-label">Bus Stop Name</label>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Bus Stop Name" name="name" value="{{ $bus_stop->name}}" disabled>
                  </div>
              </div>

              <div class="form-group row" style="float:none!important">
                <label for="fname" class="col-sm-3 text-right control-label col-form-label">Route</label>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control {{ $errors->has('class_id') ? ' has-error' : '' }}" placeholder="Route" name="class_id" value="{{ $bus_stop->route->name}}" disabled>
                  </div>
              </div>

              <input type="hidden"  name="latitude" id="latitude" value="{{$bus_stop->latitude}}">
              <input type="hidden"  name="longitude" id="longitude" value="{{$bus_stop->longitude}}">

              <div class="form-group row" style="float:none!important">
                <label for="fname" class="col-sm-3 text-right control-label col-form-label">Location</label>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control {{ $errors->has('stop_location') ? ' has-error' : '' }}" placeholder="Location" name="stop_location" value="{{ $location}}" disabled>
                  </div>
              </div>

            </div>
            <div class="col-lg-6 col-md-12">
              <div id="map" style=" width:100%;height:100%;"></div>
            </div>
          </div>
       </div>
    </div>
  </div>
</section>

@section('script')
  <script src="{{asset('js/gps/bus-stop_location_map_view.js')}}"></script>
  <script async defer
   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAyB1CKiPIUXABe5DhoKPrVRYoY60aeigo&libraries=places&callback=initMap">
  </script>
@endsection
@endsection