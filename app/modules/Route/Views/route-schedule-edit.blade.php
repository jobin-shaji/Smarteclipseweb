@extends('layouts.eclipse')
@section('title')
  Update Schedule Route
@endsection
@section('content')   
   

<section class="hilite-content">
  <!-- title row -->
  <div class="page-wrapper_new">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Edit Schedule Route</li>
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
        <form  method="POST" action="{{route('route.schedule-update.p',$route_schedule->id)}}">
          {{csrf_field()}}
          <div class="row">
            <div class="col-lg-6 col-md-12">
              <div class="form-group row" style="float:none!important">
                <label for="fname" class="col-sm-3 text-right control-label col-form-label">Route Batch</label>
                <div class="form-group has-feedback">
                  <select class="form-control route_batch  select2 {{ $errors->has('route_batch_id') ? ' has-error' : '' }}"  name="route_batch_id" value="{{ old('route_batch_id') }}" required>
                    <option>Select Route Batch</option>
                    @foreach($route_batches as $route_batch)
                    <option value="{{$route_batch->id}}" @if($route_batch->id==$route_schedule->route_batch_id){{"selected"}} @endif>{{$route_batch->name}}</option>
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
                  <input type="hidden" class="form-control route_id {{ $errors->has('route_id') ? ' has-error' : '' }}" placeholder="Route" name="route_id" value="{{$route_schedule->route_id}}" > 
                  <input type="text" name="route_name" class="form-control route_name" value="{{$route_schedule->route->name}}" readonly="" >
                </div>
                @if ($errors->has('route_batch_id'))
                  <span class="help-block">
                      <strong class="error-text">{{ $errors->first('route_batch_id') }}</strong>
                  </span>
                @endif
              </div>

              <div class="form-group row" style="float:none!important">
                <label for="fname" class="col-sm-3 text-right control-label col-form-label">Vehicle</label>
                <div class="form-group has-feedback">
                  <select class="form-control route_batch  select2 {{ $errors->has('vehicle_id') ? ' has-error' : '' }}"  name="vehicle_id" value="{{ old('vehicle_id') }}" required>
                    <option>Select Vehicle</option>
                    @foreach($vehicles as $vehicle)
                    <option value="{{$vehicle->id}}" @if($vehicle->id==$route_schedule->vehicle_id){{"selected"}} @endif>{{$vehicle->name}}</option>
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
                  <input type="hidden" class="form-control driver_id {{ $errors->has('driver_id') ? ' has-error' : '' }}" placeholder="Driver" name="driver_id" value="{{$route_schedule->driver_id}}" > 
                  <input type="text" name="route_name" class="form-control route_name" value="{{$route_schedule->driver->name}}" readonly="" >
                </div>
                @if ($errors->has('driver_id'))
                  <span class="help-block">
                      <strong class="error-text">{{ $errors->first('driver_id') }}</strong>
                  </span>
                @endif
              </div>

              <div class="form-group row" style="float:none!important">
                <label for="fname" class="col-sm-3 text-right control-label col-form-label">Helper</label>
                <div class="form-group has-feedback">
                  <select class="form-control route_batch  select2 {{ $errors->has('helper_id') ? ' has-error' : '' }}"  name="helper_id" value="{{ old('helper_id') }}" required>
                    <option>Select Helper</option>
                    @foreach($helpers as $helper)
                    <option value="{{$helper->id}}" @if($helper->id==$route_schedule->helper_id){{"selected"}} @endif>{{$helper->name}}</option>
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
 @endsection