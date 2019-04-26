@extends('layouts.gps') 
@section('title')
   Vehicle details
@endsection
@section('content')

    <section class="content-header">
     <h1>Vehicle Details</h1>
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
            <i class="fa fa-bus"></i> 
          </h2>
        </div>
        <!-- /.col -->
      </div>
   
      <div class="row">
          <div class="col-md-6">
              <div class="form-group has-feedback">
                <label class="srequired">Register Number</label>
                <input type="text" class="form-control {{ $errors->has('register_number') ? ' has-error' : '' }}" placeholder="Register Number" name="register_number" value="{{$vehicle->register_number}}" disabled> 
                <span class="glyphicon glyphicon-text-size form-control-feedback"></span>
              </div>
            


              <div class="form-group has-feedback">
                <label class="srequired">Vehicle Type</label>
                <input type="text" class="form-control" value="{{$vehicle->vehicleType->name}} || {{$vehicle->vehicleType->code}}" disabled> 
                 <span class="glyphicon glyphicon-plus form-control-feedback"></span>
                
              </div>
              


             

               <div class="form-group has-feedback">
                <label class="srequired">Vehicle Depot</label>
                <input type="text" class="form-control" value="{{$vehicle->vehicleDepot->name}} || {{$vehicle->vehicleDepot->code}}" disabled> 

                <span class="glyphicon glyphicon-home form-control-feedback"></span>
                
              </div>
            

           </div>





            <div class="col-md-6">
                <div class="form-group has-feedback">
                <label class="srequired">Occupancy</label>
                <input type="text" class="form-control {{ $errors->has('vehicle_occupancy') ? ' has-error' : '' }}" placeholder="Occupancy" name="vehicle_occupancy" value="{{ $vehicle->bus_occupancy}}" disabled> 
                <span class="glyphicon  glyphicon-th form-control-feedback"></span>
              </div>
              @if ($errors->has('vehicle_occupancy'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('name') }}</strong>
                </span>
              @endif


                <div class="form-group has-feedback">
                <label class="srequired">Speed</label>
                <input type="text" class="form-control {{ $errors->has('vehicle_speed') ? ' has-error' : '' }}" placeholder="Speed" name="vehicle_speed" value="{{$vehicle->speed_limit}}" disabled> 
                <span class="glyphicon glyphicon-dashboard form-control-feedback"></span>
              </div>
             

         
            </div>
        </div>
        
    
</section>
 
<div class="clearfix"></div>


   @endsection