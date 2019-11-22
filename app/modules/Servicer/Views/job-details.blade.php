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


               <form  method="POST" action="{{route('job.complete.save',$servicer_job->id)}}"enctype="multipart/form-data">
                <div class="row">
                  <div class="col-md-6">      
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
                          <label for="fname" class="col-md-5 text-right control-label col-form-label">Job Type</label>
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
                          <label for="fname" class="col-md-5 text-right control-label col-form-label">Description</label> 
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
                         <label for="fname" class="col-sm-5 text-right control-label col-form-label">GPS</label>
                         <div class="form-group has-feedback">
                           <select class="form-control selectpicker" data-live-search="true" title="Select Servicer" id="gps_id" name="gps_id" required>
                              <option value="{{$servicer_job->gps->id}}">{{$servicer_job->gps->serial_no}}</option>
                            </select>                           
                         </div>
                         @if ($errors->has('gps_id'))
                         <span class="help-block">
                         <strong class="error-text">{{ $errors->first('gps_id') }}</strong>
                         </span>
                         @endif 
                      </div>   
                      <div class="form-group row" style="float:none!important">
                         <label for="fname" class="col-sm-5 text-right control-label col-form-label">Driver</label>
                         <div class="form-group has-feedback">
                           <select class="form-control select2" data-live-search="true" title="Select Servicer" id="driver" name="driver" required>
                               <option value="">Select</option>
                                  @foreach ($drivers as $driver)
                                  <option value="{{$driver->id}}">{{$driver->name}}</option>
                                  @endforeach  

                            </select>                           
                         </div>
                         @if ($errors->has('driver'))
                         <span class="help-block">
                         <strong class="error-text">{{ $errors->first('driver') }}</strong>
                         </span>
                         @endif


                        <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Create Driver </button>
                      </div>               
                        <input type="hidden"   name="client_id" id="client_id" value="{{$servicer_job->clients->id}}" >
                        <input type="hidden" name="servicer_job_id" id="servicer_job_id" value="{{$servicer_job->id}}" > 
                        <div class="form-group row" style="float:none!important">
                         <label for="fname" class="col-sm-3 text-right control-label col-form-label">Vehicle Name</label>
                         <div class="form-group has-feedback">
                            <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" id="name" value="{{ old('name') }}" required> 
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
                            <input type="text" class="form-control {{ $errors->has('register_number') ? ' has-error' : '' }}" placeholder="Register Number" name="register_number" value="{{ old('register_number') }}" id="register_number" required>
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
                              <input type="text" class="form-control {{ $errors->has('engine_number') ? ' has-error' : '' }}" placeholder="Engine Number" name="engine_number" value="{{ old('engine_number') }}" id="engine_number" required>
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
                              <input type="text" class="form-control {{ $errors->has('chassis_number') ? ' has-error' : '' }}" placeholder="Chassis Number" name="chassis_number" value="{{ old('chassis_number') }}" id="chassis_number" required>
                           </div>
                           @if ($errors->has('chassis_number'))
                           <span class="help-block">
                           <strong class="error-text">{{ $errors->first('chassis_number') }}</strong>
                           </span>
                           @endif
                        </div>
                        
                       <div class="form-group row" style="float:none!important">
                           <label for="fname" class="col-md-6 text-right control-label col-form-label">RC Book</label>
                           <div class="form-group has-feedback">
                              <input type="file" class="form-control {{ $errors->has('path') ? ' has-error' : '' }}" placeholder="Choose File" name="path" id="path" value="{{ old('path') }}" required> 
                              </div>
                              @if ($errors->has('path'))
                                <span class="help-block">
                                    <strong class="error-text">{{ $errors->first('path') }}</strong>
                                </span>
                              @endif
                        </div>
                        <div class="form-group row" style="float:none!important">
                          <label for="fname" class="col-md-6 text-right control-label col-form-label">Installation Photo</label>
                           <div class="form-group has-feedback">
                              <input type="file" class="form-control {{ $errors->has('installation_photo') ? ' has-error' : '' }}" placeholder="Choose File" name="installation_photo" id="installation_photo" value="{{ old('installation_photo') }}" required> 
                              </div>
                              @if ($errors->has('installation_photo'))
                                <span class="help-block">
                                    <strong class="error-text">{{ $errors->first('installation_photo') }}</strong>
                                </span>
                              @endif
                        </div>


                          <div class="form-group row" style="float:none!important">
                           <label for="fname" class="col-md-6 text-right control-label col-form-label">Activation Photo</label>
                           <div class="form-group has-feedback">
                              <input type="file" class="form-control {{ $errors->has('activation_photo') ? ' has-error' : '' }}" placeholder="Choose File" name="activation_photo" id="activation_photo" value="{{ old('activation_photo') }}" required> 
                              </div>
                              @if ($errors->has('activation_photo'))
                                <span class="help-block">
                                    <strong class="error-text">{{ $errors->first('activation_photo') }}</strong>
                                </span>
                              @endif
                        </div>
                          <div class="form-group row" style="float:none!important">
                           <label for="fname" class="col-md-6 text-right control-label col-form-label">Vehicle Photo</label>
                           <div class="form-group has-feedback">
                              <input type="file" class="form-control {{ $errors->has('vehicle_photo') ? ' has-error' : '' }}" placeholder="Choose File" name="vehicle_photo" id="vehicle_photo" value="{{ old('vehicle_photo') }}" required> 
                              </div>
                              @if ($errors->has('vehicle_photo'))
                                <span class="help-block">
                                    <strong class="error-text">{{ $errors->first('vehicle_photo') }}</strong>
                                </span>
                              @endif
                        </div>
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
                     
                    <!--   <div class="form-group row" style="float:none!important">
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
                    </div> -->
                      <div class="form-group row" style="float:none!important">
                      <label for="fname" class="col-md-6 text-right control-label col-form-label">Comment</label>
                      <div class="form-group has-feedback">
                        <textarea name="comment" id="comment" value="" class=" form-control {{ $errors->has('comment') ? ' has-error' : '' }}" required></textarea>
                        
                        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                      </div>
                      @if ($errors->has('comment'))
                      <span class="help-block">
                      <strong class="error-text">{{ $errors->first('comment') }}</strong>
                      </span>
                      @endif
                    </div>
                   <div class="row">
                      <div class="col-md-3 ">
                        <button type="submit" class="btn btn-primary btn-md form-btn ">Job completion</button>
                      </div>
                    </div>
                  </div>                
              </div>
            
              </div>
            </div>
          </form>
           <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog" >
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body" >
          <form  method="POST" id="form1">
      {{csrf_field()}}
      <div class="row">
      <div class="col-lg-12 col-md-12">
            <div id="zero_config_wrapper" class="container-fluid dt-bootstrap4">
               <div class="row">
                  <div class="col-sm-12">                    
                     <div class="row">
                        <div class="col-md-6">
                           <div class="card-body_vehicle wizard-content">                             
                              <div class="form-group row" style="float:none!important">
                                 <label for="fname" class="col-sm-3 text-right control-label col-form-label">Name</label>
                                 <div class="form-group has-feedback">
                                    <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="driver_name" id="driver_name" value="{{ old('name') }}" > 
                                 </div>
                                 @if ($errors->has('name'))
                                  <span class="help-block">
                                      <strong class="error-text">{{ $errors->first('name') }}</strong>
                                  </span>
                                @endif
                              </div>
                               <div class="form-group row" style="float:none!important">
                                 <label for="fname" class="col-sm-3 text-right control-label col-form-label">Mobile</label>
                                 <div class="form-group has-feedback">
                                     <input type="number" class="form-control {{ $errors->has('mobile') ? ' has-error' : '' }}" placeholder="Mobile No." name="mobile" id="mobile" value="{{ old('mobile') }}" > 
                                  </div>
                                  @if ($errors->has('mobile'))
                                    <span class="help-block">
                                        <strong class="error-text">{{ $errors->first('mobile') }}</strong>
                                    </span>
                                  @endif
                              </div>
                              <div class="form-group row" style="float:none!important">
                                 <label for="fname" class="col-sm-3 text-right control-label col-form-label">Address</label>
                                 <div class="form-group has-feedback">
                                    <textarea class="form-control driver_address {{ $errors->has('address') ? ' has-error' : '' }}" placeholder="Address" name="address" id="address" rows=5></textarea>
                                  </div>
                                   @if ($errors->has('address'))
                                <span class="help-block">
                                    <strong class="error-text">{{ $errors->first('address') }}</strong>
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
       </div>
       <!-- <div class="row">
         <div class="col-lg-6 col-md-12">
            <div id="zero_config_wrapper" class="container-fluid dt-bootstrap4">
              <div class="row">
              
              </div>
            </div>
          </div>
        </div>  -->   
        <div class="modal-footer">   
          <button type="button" id="btn" class="btn btn-primary" onclick="createDriver({{$servicer_job->id}})">Create</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
     
      </form> 
    </div>
         <!--  <p>Some text in the modal.</p> -->
        </div>
      
      
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
 <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <script src="{{asset('js/gps/servicer-driver-create.js')}}"></script>
  
  @endsection