@extends('layouts.eclipse')
@section('title')
  Update Bus Stop Details
@endsection
@section('content')   
   
<style type="text/css">
  .pac-container { position: relative !important;top: -380px !important;margin:0px }
</style>
<section class="hilite-content">
  <!-- title row -->
  <div class="page-wrapper_new">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Edit Bus Stop</li>
        <b>Bus Stop Updation</b>
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
      <div class="card-body wizard-content">
        <form  method="POST" action="{{route('bus-stop.update.p',$bus_stop->id)}}" enctype="multipart/form-data">
          {{csrf_field()}}
          <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="form-group row" style="float:none!important">
                  <label for="fname" class="col-sm-3 text-right control-label col-form-label">Bus Stop Name</label>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Bus Stop Name" name="name" value="{{ $bus_stop->name}}">  
                  </div>
                  @if ($errors->has('name'))
                    <span class="help-block">
                        <strong class="error-text">{{ $errors->first('name') }}</strong>
                    </span>
                  @endif
                </div>

                <div class="form-group row" style="float:none!important">
                  <label for="fname" class="col-sm-3 text-right control-label col-form-label">Route</label>
                  <div class="form-group has-feedback">
                    <select class="form-control {{ $errors->has('route_id') ? ' has-error' : '' }}"  name="route_id" value="{{ old('route_id') }}" required>
                      <option>Select Route</option>
                      @foreach($routes as $route)
                        <option value="{{$route->id}}" @if($route->id==$bus_stop->route_id){{"selected"}} @endif>{{$route->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  @if ($errors->has('route_id'))
                    <span class="help-block">
                        <strong class="error-text">{{ $errors->first('route_id') }}</strong>
                    </span>
                  @endif
                </div> 

                <input type="hidden"  name="latitude" id="latitude" value="{{$bus_stop->latitude}}">
                <input type="hidden"  name="longitude" id="longitude" value="{{$bus_stop->longitude}}">

                <div class="form-group row" style="float:none!important">            
                  <label for="fname" class="col-sm-3 text-right control-label col-form-label">Location</label>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control {{ $errors->has('address') ? ' has-error' : '' }}" placeholder="Location" name="stop_location" id="stop_location" value="{{$location}}" required>
                  </div> 
                  @if ($errors->has('stop_location'))
                    <span class="help-block">
                      <strong class="error-text">{{ $errors->first('stop_location') }}</strong>
                    </span>
                  @endif
                </div>  
            </div>
            <div class="col-lg-6 col-md-12">
              <div id="map" style=" width:100%;height:100%;"></div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-5">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

@section('script')
  <script src="{{asset('js/gps/bus_stop_location_map.js')}}"></script>
  <script async defer
   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAyB1CKiPIUXABe5DhoKPrVRYoY60aeigo&libraries=places&callback=initMap">
  </script>
@endsection
@endsection