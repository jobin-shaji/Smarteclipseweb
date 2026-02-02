@extends('layouts.eclipse')
@section('title')
  Schedule Route
@endsection
@section('content')   
<style type="text/css">
  .pac-container { position: relative !important;top: -570px !important;margin:0px }
</style>
<section class="hilite-content">
  <div class="page-wrapper_new">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Schedule Route</li>
        <b>Schedule Route</b>
     </ol>
       @if(Session::has('message'))
          <div class="pad margin no-print">
            <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
                {{ Session::get('message') }}  
            </div>
          </div>
        @endif  
    </nav>
    <form  method="POST" action="{{route('route.schedule.p')}}">
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
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Route Batch</label>
                        <div class="form-group has-feedback">
                          <select class="form-control route_batch  select2 {{ $errors->has('route_batch_id') ? ' has-error' : '' }}" id="route_batch_id" name="route_batch_id" required>
                          <option selected disabled>Select Route Batch</option>
                          @foreach($route_batches as $route_batch)
                          <option value="{{$route_batch->id}}">{{$route_batch->name}}</option>  
                          @endforeach
                          </select>
                        </div>
                        @if ($errors->has('route_batch_id'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('route_batch_id') }}</strong>
                          </span>
                        @endif
                      </div>

                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Route</label>
                        <div class="form-group has-feedback">
                          <input type="hidden" class="form-control route_id {{ $errors->has('route_id') ? ' has-error' : '' }}" placeholder="Route" name="route_id" value="{{ old('route_id') }}" > 
                          <input type="text" name="route_name" class="form-control route_name" readonly="" >
                        @if ($errors->has('route_id'))
                          <span class="help-block">
                              <strong class="error-text">{{ $errors->first('route_id') }}</strong>
                          </span>
                        @endif
                        </div> 
                      </div>

                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Vehicle</label>
                        <div class="form-group has-feedback">
                          <select class="form-control vehicle_id  select2 {{ $errors->has('vehicle_id') ? ' has-error' : '' }}" id="vehicle_id" name="vehicle_id" required>
                          <option selected disabled>Select Vehicle</option>
                          @foreach($vehicles as $vehicle)
                          <option value="{{$vehicle->id}}">{{$vehicle->name}} || {{$vehicle->register_number}}</option>  
                          @endforeach
                          </select>
                        </div>
                        @if ($errors->has('vehicle_id'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('vehicle_id') }}</strong>
                          </span>
                        @endif
                      </div>

                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Driver</label>
                        <div class="form-group has-feedback">
                          <input type="hidden" class="form-control driver_id {{ $errors->has('driver_id') ? ' has-error' : '' }}" placeholder="Driver" name="driver_id" value="{{ old('driver_id') }}" > 
                          <input type="text" name="driver_name" class="form-control driver_name" readonly="" >
                        @if ($errors->has('driver_id'))
                          <span class="help-block">
                              <strong class="error-text">{{ $errors->first('driver_id') }}</strong>
                          </span>
                        @endif
                        </div> 
                      </div>

                      <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Helper</label>
                        <div class="form-group has-feedback">
                          <select class="form-control select2 {{ $errors->has('helper_id') ? ' has-error' : '' }}" id="helper_id" name="helper_id" required>
                          <option selected disabled>Select Helper</option>
                          @foreach($helpers as $helper)
                          <option value="{{$helper->id}}">{{$helper->name}}</option>  
                          @endforeach
                          </select>
                        </div>
                        @if ($errors->has('helper_id'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('helper_id') }}</strong>
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
  <script src="{{asset('js/gps/route-schedule.js')}}"></script>
@endsection
@endsection