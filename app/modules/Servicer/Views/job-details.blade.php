@extends('layouts.eclipse')
@section('title')
    Assign Servicer
@endsection
@section('content')
<div class="page-wrapper page-wrapper-root page-wrapper_new">
<div class="page-wrapper-root1">
 <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/ Job</li>
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
        <div class="card-body">
          <div class="table-responsive">
              <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                <div class="row">
                  <div class="col-sm-6">      
                 
                    <form  method="POST" action="{{route('job.complete.save',$servicer_job->id)}}">
                    {{csrf_field()}}
                    <div class="card">
                    <div class="card-body">                    
                 
                    <div class="form-group row" style="float:none!important">
                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">Client</label>
                      <div class="form-group has-feedback">
                       <input type="text" class="form-control {{ $errors->has('client') ? ' has-error' : '' }}"  name="client" value="{{$servicer_job->clients->name}}" required readonly>
                        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                      </div>
                      @if ($errors->has('client'))
                      <span class="help-block">
                      <strong class="error-text">{{ $errors->first('client') }}</strong>
                      </span>
                      @endif
                    </div>
                     
                    <div class="form-group row" style="float:none!important">
                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">Job Type</label>
                      <div class="form-group has-feedback">
                       <input type="text" class="form-control {{ $errors->has('job_type') ? ' has-error' : '' }}"  name="job_type" value="<?php if($servicer_job['job_type']==1){echo 'installation';} else { echo 'Services'; } ?>" required readonly>
                        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                      </div>
                      @if ($errors->has('job_type'))
                      <span class="help-block">
                      <strong class="error-text">{{ $errors->first('job_type') }}</strong>
                      </span>
                      @endif
                    </div>
                    <div class="form-group row" style="float:none!important">               
                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">Description</label> 
                      <div class="form-group has-feedback">
                        <input type="text" class="form-control {{ $errors->has('description') ? ' has-error' : '' }}" placeholder="description" name="description" value="{{$servicer_job->description}}" required readonly>
                        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                      </div>
                      @if ($errors->has('description'))
                      <span class="help-block">
                      <strong class="error-text">{{ $errors->first('description') }}</strong>
                      </span>
                      @endif
                    </div>
                    <div class="form-group row" style="float:none!important">
                      <label for="fname" class="col-sm-3 text-right control-label col-form-label">Job Date</label>
                      <div class="form-group has-feedback">
                        <input type="text" class="form-control {{ $errors->has('job_date') ? ' has-error' : '' }}" placeholder="Mobile" name="job_date" value=" {{date('d-m-Y', strtotime($servicer_job->job_date))}}" required readonly="">
                        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                      </div>
                      @if ($errors->has('job_date'))
                      <span class="help-block">
                      <strong class="error-text">{{ $errors->first('job_date') }}</strong>
                      </span>
                      @endif
                    </div>

               

                     <div class="form-group row" style="float:none!important">
                      <label for="fname" class="col-md-6 text-right control-label col-form-label">Job Complete Date</label>
                      <div class="form-group has-feedback">
                        <input type="text" class=" date_expiry form-control {{ $errors->has('job_completed_date') ? ' has-error' : '' }}"  name="job_completed_date" value=" " required >
                        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                      </div>
                      @if ($errors->has('job_completed_date'))
                      <span class="help-block">
                      <strong class="error-text">{{ $errors->first('job_completed_date') }}</strong>
                      </span>
                      @endif
                    </div>
                    
                   
                   
                    </div>
                    <div class="row">
                      <div class="col-md-3 ">
                        <button type="submit" class="btn btn-primary btn-md form-btn ">Create</button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <div class="col-sm-6">      
                    <div class="row">
                     
                    </div>
                    <!-- <form  method="POST" action="{{route('servicer.vehicles.create.p')}}"> -->
      <!-- {{csrf_field()}} -->
      
      <div class="row">
         <div class="col-lg-6 col-md-12">
            <div id="zero_config_wrapper" class="container-fluid dt-bootstrap4">
               <div class="row">
                  <div class="col-sm-12">
                     <h2 class="page-header">
                        
                        <input type="hidden"   name="client_id" id="client_id" value="{{$servicer_job->clients->id}}" >
                        <input type="hidden" name="servicer_job_id" id="servicer_job_id" value="{{$servicer_job->id}}" > 
                     </h2>
                     <div class="row">
                        <div class="col-md-6">
                           <div class="card-body_vehicle wizard-content">
                              <div class="form-group row" style="float:none!important">
                                 <label for="fname" class="col-sm-3 text-right control-label col-form-label">Name</label>
                                 <div class="form-group has-feedback">
                                    <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" id="name" value="{{ old('name') }}" > 
                                 </div>
                                 @if ($errors->has('name'))
                                 <span class="help-block">
                                 <strong class="error-text">{{ $errors->first('name') }}</strong>
                                 </span>
                                 @endif
                              </div>
                              <div class="form-group row" style="float:none!important">
                                 <label for="fname" class="col-md-6 text-right control-label col-form-label">Register Number</label>
                                 <div class="form-group has-feedback">
                                    <input type="text" class="form-control {{ $errors->has('register_number') ? ' has-error' : '' }}" placeholder="Register Number" name="register_number" value="{{ old('register_number') }}" id="register_number" >
                                 </div>
                                 @if ($errors->has('register_number'))
                                 <span class="help-block">
                                 <strong class="error-text">{{ $errors->first('register_number') }}</strong>
                                 </span>
                                 @endif
                              </div>
                              <div class="form-group row" style="float:none!important">
                                 <label for="fname" class="col-md-6 text-right control-label col-form-label">Engine Number</label>
                                 <div class="form-group has-feedback">
                                    <input type="text" class="form-control {{ $errors->has('engine_number') ? ' has-error' : '' }}" placeholder="Engine Number" name="engine_number" value="{{ old('engine_number') }}" id="engine_number" >
                                 </div>
                                 @if ($errors->has('engine_number'))
                                 <span class="help-block">
                                 <strong class="error-text">{{ $errors->first('engine_number') }}</strong>
                                 </span>
                                 @endif
                              </div>
                              <div class="form-group row" style="float:none!important">
                                 <label for="fname" class="col-md-6 text-right control-label col-form-label">Chassis Number</label>
                                 <div class="form-group has-feedback">
                                    <input type="text" class="form-control {{ $errors->has('chassis_number') ? ' has-error' : '' }}" placeholder="Chassis Number" name="chassis_number" value="{{ old('chassis_number') }}" id="chassis_number" >
                                 </div>
                                 @if ($errors->has('chassis_number'))
                                 <span class="help-block">
                                 <strong class="error-text">{{ $errors->first('chassis_number') }}</strong>
                                 </span>
                                 @endif
                              </div>
                               
<!-- 
                                <div class="form-group row" style="float:none!important">
                                <label class="srequired">RC Book </label>
                               <div class="form-group has-feedback">
                                   <input type="file" class="form-control {{ $errors->has('path') ? ' has-error' : '' }}" placeholder="Choose File" name="path" id="path" value="{{ old('path') }}" > 
                                    </div>
                                    @if ($errors->has('path'))
                                      <span class="help-block">
                                          <strong class="error-text">{{ $errors->first('path') }}</strong>
                                      </span>
                                    @endif
                                </div> -->
                               <div class="form-group row" style="float:none!important">
                                 <label for="fname" class="col-sm-5 text-right control-label col-form-label">Vehicle Type</label>
                                 <div class="form-group has-feedback">
                                    <select class="form-control {{ $errors->has('vehicle_type_id') ? ' has-error' : '' }}" placeholder="Name" name="vehicle_type_id" value="{{ old('vehicle_type_id') }}"  id="vehicle_type_id" required>
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
                                 <label for="fname" class="col-sm-5 text-right control-label col-form-label">GPS</label>
                                 <div class="form-group has-feedback">
                                    <select class="form-control" name="gps_id"  id="gps_id"data-live-search="true" title="Select GPS" required>
                                        <option selected disabled>Select GPS</option>
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

                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
              <div class="col-lg-12 col-md-12">
            <div class="custom_fom_group">
              <button style="margin-top: 19px;" class="btn btn-sm btn-info btn3 form-control" onclick="create_vehicle()">Tag GPS to Vehicle </button>
              <!-- <button type="submit" class="btn btn-primary">Create Vehicle</button> -->
            </div>
         </div>



         </div>
         <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                <thead>
                  <tr>
                      <th>#</th>
                     
                      <th >Vehicle</th>
                       <th >Register Number</th>
                      <th >GPS</th>
                     
                  </tr>
                </thead>
              </table>
        </div>
   <!-- </form> -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>            
  </div>
</div>

<div class="clearfix"></div>

@endsection
 @section('script')
    <script src="{{asset('js/gps/servicer-vehicle-create.js')}}"></script>
  @endsection