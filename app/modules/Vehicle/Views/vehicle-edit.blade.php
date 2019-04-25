@extends('layouts.etm') 
@section('title')
   Update vehicle details
@endsection
@section('content')

    <section class="content-header">
     <h1>Edit Vehicle</h1>
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
   <form  method="POST" action="{{route('vehicles.update.p',$vehicle->id)}}">
        {{csrf_field()}}
      <div class="row">
          <div class="col-md-6">
              <div class="form-group has-feedback">
                <label class="srequired">Register Number</label>
                <input type="text" class="form-control {{ $errors->has('register_number') ? ' has-error' : '' }}" placeholder="Register Number" name="register_number" value="{{$vehicle->register_number}}" required> 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              @if ($errors->has('register_number'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('register_number') }}</strong>
                </span>
              @endif


              <div class="form-group has-feedback">
                <label class="srequired">Vehicle Type</label>

                <select class="form-control {{ $errors->has('vehicle_type') ? ' has-error' : '' }}" placeholder="Name" name="vehicle_type" value="{{ old('vehicle_type') }}" required>
                	<option>Select</option>
                	@foreach($vehicleTypes as $type)
                	<option value="{{$type->id}}" @if($type->id==$vehicle->bus_type_id){{"selected"}} @endif>{{$type->name}}</option>
              		  
              		@endforeach

                </select>
    
               
              </div>
              @if ($errors->has('vehicle_type'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('vehicle_type') }}</strong>
                </span>
              @endif


               <div class="form-group has-feedback">
                <label class="srequired">Vehicle Depot</label>

                <select class="form-control {{ $errors->has('vehicle_depot') ? ' has-error' : '' }}"  name="vehicle_depot" value="{{ old('vehicle_depot') }}" required>
                	<option>Select</option>
                	@foreach($depots as $depot)
                	<option value="{{$depot->id}}" @if($depot->id==$vehicle->depot_id){{"selected"}} @endif>{{$depot->name}}</option>
              		  
              		@endforeach
                </select>
              </div>
              @if ($errors->has('vehicle_depot'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('vehicle_depot') }}</strong>
                </span>
              @endif

           </div>





            <div class="col-md-6">
                <div class="form-group has-feedback">
                <label class="srequired">Occupancy</label>
                <input type="text" class="form-control {{ $errors->has('vehicle_occupancy') ? ' has-error' : '' }}" placeholder="Occupancy" name="vehicle_occupancy" value="{{ $vehicle->bus_occupancy}}" required> 
                <span class="glyphicon  glyphicon-th form-control-feedback"></span>
              </div>
              @if ($errors->has('vehicle_occupancy'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('vehicle_occupancy') }}</strong>
                </span>
              @endif


                <div class="form-group has-feedback">
                <label class="srequired">Speed</label>
                <input type="text" class="form-control {{ $errors->has('vehicle_speed') ? ' has-error' : '' }}" placeholder="Speed" name="vehicle_speed" value="{{$vehicle->speed_limit}}" required> 
                <span class="glyphicon glyphicon-dashboard form-control-feedback"></span>
              </div>
              @if ($errors->has('vehicle_speed'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('vehicle_speed') }}</strong>
                </span>
              @endif

         
            </div>
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