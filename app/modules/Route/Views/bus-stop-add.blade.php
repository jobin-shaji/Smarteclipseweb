@extends('layouts.eclipse')
@section('title')
  Bus Stop Creation
@endsection
@section('content')   
<style type="text/css">
  .pac-container { position: relative !important;top: -570px !important;margin:0px }
</style>
<section class="hilite-content">
  <div class="page-wrapper_new">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-page-heading">Bus Stop Creation</li>
        <h4>Create Bus Stop</h4>
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Create Bus Stop</li>
     </ol>
       @if(Session::has('message'))
          <div class="pad margin no-print">
            <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
                {{ Session::get('message') }}  
            </div>
          </div>
        @endif  
    </nav>
    <form  method="POST" action="{{route('bus-stop.create.p')}}" enctype="multipart/form-data">
      {{csrf_field()}}
      <div class="row">
        <div class="col-lg-6 col-md-12">
          <div id="zero_config_wrapper" class="container-fluid dt-bootstrap4">
            <div class="row">
              <div class="col-sm-12">                    
                <div class="row">
                  <div class="col-md-6">
                    <div class="card-body_vehicle wizard-content">   
                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Stop Name</label>
                        <div class="form-group has-feedback">
                          <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Stop Name" name="name" value="{{ old('name') }}" autocomplete="off" > 
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
                          <select class="form-control  select2 {{ $errors->has('route_id') ? ' has-error' : '' }}" name="route_id" required>
                          <option selected disabled>Select Route</option>
                          @foreach($routes as $route)
                          <option value="{{$route->id}}">{{$route->name}}</option>  
                          @endforeach
                          </select>
                        </div>
                        @if ($errors->has('route_id'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('route_id') }}</strong>
                          </span>
                        @endif
                      </div>

                      <input type="hidden"  name="latitude" id="latitude" value="">
                      <input type="hidden"  name="longitude" id="longitude" value="">
                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Location</label>
                        <div class="form-group has-feedback">
                          <input type="text" class="form-control {{ $errors->has('stop_location') ? ' has-error' : '' }}" placeholder="Location" name="stop_location" id="stop_location" value="{{ old('stop_location') }}" required>
                        </div>
                        @if ($errors->has('stop_location'))
                        <span class="help-block">
                          <strong class="error-text">{{ $errors->first('stop_location') }}</strong>
                        </span>
                        @endif
                      </div>                                    
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-12">
          <div id="map" style=" width:100%;height:100%;"></div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6 col-md-12">
          <div id="zero_config_wrapper" class="container-fluid dt-bootstrap4">
            <div class="row">
              <button type="submit" class="btn btn-primary address_btn">Create</button>
            </div>
          </div> 
        </div> 
      </div>
    </form>
  </div>
</section>

@section('script')
  <script src="{{asset('js/gps/bus_stop_location_map.js')}}"></script>
  <script async defer
   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAyB1CKiPIUXABe5DhoKPrVRYoY60aeigo&libraries=places&callback=initMap">
  </script>
@endsection
@endsection