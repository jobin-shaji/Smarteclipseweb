@extends('layouts.eclipse')
  @section('title')
    Add Vehicle
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
  <div class="page-wrapper">
    <div class="page-breadcrumb">
      <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
          <h4 class="page-title">Add Vehicle</h4>                      
        </div>
      </div>
    </div>           
  <div class="container-fluid">
    <div class="card" style="margin:0 0 0 1%">
      <div class="card-body wizard-content">
        <form  method="POST" action="{{route('vehicles.create.p')}}">
        {{csrf_field()}}
          <h4 class="card-title"><span style="margin:0;padding:0 10px 0 0;line-height:50px"><img src="{{ url('/') }}/assets/images/vehicle.png" width="40" height="40"></span>VEHICLE INFO</h4>
        <div class="form-group row" style="float:none!important">
          <label for="fname" class="col-sm-3 text-right control-label col-form-label">Name</label>
          <div class="form-group has-feedback">
            <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{ old('name') }}" > 
          </div>
          @if ($errors->has('name'))
            <span class="help-block">
              <strong class="error-text">{{ $errors->first('name') }}</strong>
            </span>
          @endif
        </div>

        <div class="form-group row" style="float:none!important">
          <label for="fname" class="col-sm-3 text-right control-label col-form-label">Register Number</label>
          <div class="form-group has-feedback">
            <input type="text" class="form-control {{ $errors->has('register_number') ? ' has-error' : '' }}" placeholder="Register Number" name="register_number" value="{{ old('register_number') }}" >
          </div>
          @if ($errors->has('register_number'))
            <span class="help-block">
              <strong class="error-text">{{ $errors->first('register_number') }}</strong>
            </span>
          @endif
        </div>

        <div class="form-group row" style="float:none!important">
          <label for="fname" class="col-sm-3 text-right control-label col-form-label">E-SIM Number</label>
          <div class="form-group has-feedback">
            <input type="text" class="form-control {{ $errors->has('e_sim_number') ? ' has-error' : '' }}" placeholder="E-SIM Number" name="e_sim_number" value="{{ old('e_sim_number') }}" > 
          </div>
          @if ($errors->has('e_sim_number'))
            <span class="help-block">
              <strong class="error-text">{{ $errors->first('e_sim_number') }}</strong>
            </span>
          @endif
        </div>

        <div class="form-group row" style="float:none!important">
          <label for="fname" class="col-sm-3 text-right control-label col-form-label">Vehicle Type</label>
          <div class="form-group has-feedback">
            <select class="form-control {{ $errors->has('vehicle_type_id') ? ' has-error' : '' }}" placeholder="Name" name="vehicle_type_id" value="{{ old('vehicle_type_id') }}" required>
              <option value="" selected disabled>Select Vehicle Type</option>
              @foreach($vehicleTypes as $type)
                <option value="{{$type->id}}">{{$type->name}}</option>
              @endforeach
            </select>
          </div>
          @if ($errors->has('vehicle_type_id'))
            <span class="help-block">
              <strong class="error-text">{{ $errors->first('vehicle_type_id') }}</strong>
            </span>
          @endif
        </div>

        <div class="form-group row" style="float:none!important">
          <label for="fname" class="col-sm-3 text-right control-label col-form-label">GPS</label>
          <div class="form-group has-feedback">
            <select class="form-control selectpicker" name="gps_id" data-live-search="true" title="Select GPS" required>
              @foreach($devices as $gps)
                <option value="{{$gps->id}}">{{$gps->name}}||{{$gps->imei}}</option>
              @endforeach
            </select>
          </div>     
          @if ($errors->has('gps_id'))
            <span class="help-block">
              <strong class="error-text">{{ $errors->first('gps_id') }}</strong>
            </span>
          @endif 
        </div>

        <div class="form-group row" style="float:none!important">
          <label for="fname" class="col-sm-3 text-right control-label col-form-label">Driver</label>
          <div class="form-group has-feedback">
            <select class="form-control selectpicker" name="driver_id" data-live-search="true" title="Select Driver" required>
              @foreach($drivers as $driver)
                <option value="{{$driver->id}}">{{$driver->name}}</option>
              @endforeach
            </select>
          </div>     
          @if ($errors->has('driver_id'))
            <span class="help-block">
              <strong class="error-text">{{ $errors->first('driver_id') }}</strong>
            </span>
          @endif 
        </div>

        <div class="row">
          @foreach($ota_types as $ota_type)
            <div class="col-md-6">
              <div class="form-group has-feedback">
                <label>{{$ota_type->name}}</label>
                <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="{{$ota_type->name}}" name="ota[]" value="{{$ota_type->default_value}}" readonly> 
              </div>
            </div>
          @endforeach
        </div>

        <div class="border-top">
          <div class="card-body">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>
</section>
@endsection