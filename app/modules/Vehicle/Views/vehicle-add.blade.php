@extends('layouts.eclipse')
@section('title')
Add Vehicle
@endsection
@section('content')   
<div class="page-wrapper_new">

  
  <div class="page-breadcrumb">
    <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
        <h4 class="page-title">Add Vehicle</h4>
         @if(Session::has('message'))
          <div class="pad margin no-print">
            <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
            {{ Session::get('message') }}  
          </div>
          </div>
        @endif 
      </div>
    </div>
  </div>

     
   <form  method="POST" action="{{route('vehicles.create.p')}}">
      {{csrf_field()}}
      
      <div class="row">
         <div class="col-lg-6 col-md-12">
            <div id="zero_config_wrapper" class="container-fluid dt-bootstrap4">
               <div class="row">
                  <div class="col-sm-12">
                     <h2 class="page-header">
                        <i class="fa fa-user"></i> 
                     </h2>
                     <div class="row">
                        <div class="col-md-6">
                           <div class="card-body_vehicle wizard-content">
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
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

         </div>
         <div class="col-lg-6 col-md-12">
            <div id="zero_config_wrapper" class=" container-fluid dt-bootstrap4 profile_image vehicle_details_row2">
               <div class="row">
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
               </div>
            </div>
         </div>
         <div class="col-lg-12 col-md-12">
            <div id="zero_config_wrapper" class=" container-fluid dt-bootstrap4 profile_image">
               <div class="row">
                  @foreach($ota_types as $ota_type)
                  <div class="col-lg-6 col-md-5">
                     <div class="form-group has-feedback">
                        <label>{{$ota_type->name}}</label>
                        <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="{{$ota_type->name}}" name="ota[]" value="{{$ota_type->default_value}}" readonly> 
                     </div>
                  </div>
                  @endforeach
               </div>

          </div>
       
    </div>

     <div class="col-lg-12 col-md-12">
            <div class="custom_fom_group">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
         </div>

   </form>
    </div>

   <div class="page-wrapper_cover"></div>
   <footer class="footer text-center">
      All Rights Reserved by VST Mobility Solutions. Designed and Developed by <a href="http://vstmobility.com">VST</a>.
   </footer>
</div>
<div class="clearfix"></div>
@endsection