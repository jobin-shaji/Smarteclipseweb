@extends('layouts.gps')

@section('content')

  <section class="content-header">
        <h1>
          Alert
          <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Alert</li>
        </ol>
  </section>

  <section class="content">
    <div class="row">
     <div class="col-md-4">
         <div class="form-group has-feedback">
            <label class="srequired">Name</label>
            <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" id="name" value="" required> 
           
          </div>
        </div>
      </div>   
    <button id="savebutton" class="btn btn-success">SAVE FENCE</button>
    <div style="position: absolute;">
      <div id="map" style="position: "></div>
    </div>
  </section>

    @section('script')

        <script src="{{asset('js/gps/geofence.js')}}"></script>
 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDl9Ioh5neacm3nsLzjFxatLh1ac86tNgE&libraries=drawing&callback=initMap"
         async defer></script>
    @endsection

@endsection