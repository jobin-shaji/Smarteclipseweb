@extends('layouts.eclipse')
@section('title')
Add Vehicle
@endsection
@section('content')   
<div class="page-wrapper_new">

  <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Add Vehicle</li>
          </ol>
            @if(Session::has('message'))
        <div class="pad margin no-print">
          <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
              {{ Session::get('message') }}  
          </div>
        </div>
        @endif 
        </nav>


   <form  method="POST" action="{{route('servicer.vehicles.create.p')}}">
      {{csrf_field()}}
      
      <div class="row">
         <div class="col-lg-6 col-md-12">
            <div id="zero_config_wrapper" class="container-fluid dt-bootstrap4">
               <div class="row">
                  <div class="col-sm-12">
                     <h2 class="page-header">
                        <i class="fa fa-user"></i> 
                        <input type="hidden"   name="client_id" value="{{$client_id}}" > 
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
                        <select class="form-control" name="gps_id" data-live-search="true" title="Select GPS" required>
                           <option selected disabled>Select GPS</option>
                           @foreach($devices as $gps)
                           <option value="{{$gps->id}}">{{$gps->imei}}</option>
                           @endforeach
                        </select>
                     </div>
                     @if ($errors->has('gps_id'))
                     <span class="help-block">
                     <strong class="error-text">{{ $errors->first('gps_id') }}</strong>
                     </span>
                     @endif 
                  </div>
                  
               </div>
            </div>
         </div>
         <div class="col-lg-12 col-md-12">
            <div id="zero_config_wrapper" class=" container-fluid dt-bootstrap4 profile_image">
               <div class="row">
                  
               </div>

          </div>
       
    </div>

     <div class="col-lg-12 col-md-12">
            <div class="custom_fom_group">
              <button type="submit" class="btn btn-primary">Create</button>
            </div>
         </div>

</div>
   </form>
    </div>

   <div class="page-wrapper_cover"></div>
</div>
<div class="clearfix"></div>
@endsection