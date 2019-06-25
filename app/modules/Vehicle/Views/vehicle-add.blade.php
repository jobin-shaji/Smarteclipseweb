@extends('layouts.eclipse')
@section('title')
  Add Vehicle
@endsection

@section('content')

    <section class="content-header">
        <h1>Create vehicle</h1>
    </section>
    @if(Session::has('message'))
    <div class="pad margin no-print">
      <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
          {{ Session::get('message') }}  
      </div>
    </div>
    @endif  

<section class="hilite-content">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-user-plus"></i> 
          </h2>
        </div>
        <!-- /.col -->
      </div>
     <form  method="POST" action="{{route('vehicles.create.p')}}">
        {{csrf_field()}}
      <div class="bottom">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group has-feedback">
                  <label class="srequired">Name</label>
                  <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{ old('name') }}" > 
                  <span class="glyphicon glyphicon-car form-control-feedback"></span>
                </div>
                @if ($errors->has('name'))
                  <span class="help-block">
                      <strong class="error-text">{{ $errors->first('name') }}</strong>
                  </span>
                @endif

                <div class="form-group has-feedback">
                  <label class="srequired">Register Number</label>
                  <input type="text" class="form-control {{ $errors->has('register_number') ? ' has-error' : '' }}" placeholder="Register Number" name="register_number" value="{{ old('register_number') }}" > 
                  <span class="glyphicon glyphicon-car form-control-feedback"></span>
                </div>
                @if ($errors->has('register_number'))
                  <span class="help-block">
                      <strong class="error-text">{{ $errors->first('register_number') }}</strong>
                  </span>
                @endif

                <div class="form-group has-feedback">
                  <label class="srequired">E-SIM Number</label>
                  <input type="text" class="form-control {{ $errors->has('e_sim_number') ? ' has-error' : '' }}" placeholder="E-SIM Number" name="e_sim_number" value="{{ old('e_sim_number') }}" > 
                  <span class="glyphicon glyphicon-car form-control-feedback"></span>
                </div>
                @if ($errors->has('e_sim_number'))
                  <span class="help-block">
                      <strong class="error-text">{{ $errors->first('e_sim_number') }}</strong>
                  </span>
                @endif

              </div>

              <div class="col-md-6">
                <div class="form-group has-feedback">
                  <label class="srequired">Vehicle Type</label>
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


                <div class="form-group has-feedback">
                  <label class="srequired">GPS</label>
                  <select class="form-control selectpicker" name="gps_id" data-live-search="true" title="Select GPS" required>
                    @foreach($devices as $gps)
                    <option value="{{$gps->id}}">{{$gps->name}}||{{$gps->imei}}</option>
                    @endforeach
                  </select>
                  <span class="glyphicon glyphicon-car form-control-feedback"></span>
                </div>     
                @if ($errors->has('gps_id'))
                  <span class="help-block">
                      <strong class="error-text">{{ $errors->first('gps_id') }}</strong>
                  </span>
                @endif 

              </div>
          </div>
        </div>
        <br>
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


          <div class="row">
            <!-- /.col -->
            <div class="col-md-3 ">
              <button type="submit" class="btn btn-primary btn-md form-btn ">Save</button>
            </div>
            <!-- /.col -->
          </div>
    </form>
</section>
 
<div class="clearfix"></div>


@endsection