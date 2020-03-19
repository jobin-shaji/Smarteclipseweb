@extends('layouts.eclipse')
@section('title')
    Assign Servicer
@endsection
@section('content')
<!-- added code -->


<!------ Include the above in your HEAD tag ---------->
        <div class="page-wrapper page-wrapper-root page-wrapper_new">
        <div class="page-wrapper-root1">
        <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Job Details</li>
                    <b>Job Details</b>
                </ol>
                @if(Session::has('message'))
                <div class="pad margin no-print">
                    <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
                        {{ Session::get('message') }}  
                    </div>
                </div>
                @endif           
                </nav>           
     
<div class="container">
    <div class="stepwizard">
        <div class="stepwizard-row setup-panel">
            <div class="stepwizard-step col-xs-3"> 
                <a href="#step-1" type="button" class="btn btn-success btn-circle">1</a>
                <p><small>Installation Job checklist</small></p>
            </div>
            <div class="stepwizard-step col-xs-3"> 
                <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
                <p><small>Vehicle Details</small></p>
            </div>
            <div class="stepwizard-step col-xs-3"> 
                <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
                <p><small>Command</small></p>
            </div>
            <div class="stepwizard-step col-xs-3"> 
                <a href="#step-4" type="button" class="btn btn-default btn-circle" disabled="disabled">4</a>
                <p><small>Device Test</small></p>
            </div>
        </div>
    </div>
   
    <form role="form">
        <div class="panel panel-primary setup-content" id="step-1">
            <div class="panel-heading">
                 <h4 class="panel-title">Installation check list</h4>
            </div>
            <div class="panel-body">
            <div class="row">
            <?php foreach ($unboxing_checklist['checklist'][0]['items'] as $list){ ?>
            <div class="col-lg-6">
            <div class="funkyradio">
            <div class="funkyradio-success">
                <input type="checkbox" name="checkbox[]" value="{{$list['id']}}" id="checkbox{{$list['id']}}"/>
                <label for="checkbox{{$list['id']}}">{{$list['label']}}</label>
            </div>
            </div>
            </div>
          
            <?php } ?>
            <button class="btn btn-primary nextBtn pull-right" type="button">Next</button>
            </div>
             </div>
            </div>
        
        <div class="panel panel-primary setup-content" id="step-2">
        <form  method="POST" action="{{route('job.complete.save',$servicer_job->id)}}"enctype="multipart/form-data">
                <div class="row">
                  <div class="col-md-6">      
                    {{csrf_field()}}
                    <div class="card">
                      <div class="card-body">                                     
                        <div class="form-group row" style="float:none!important">
                          <label for="fname" class="col-sm-3 text-right control-label col-form-label">End User</label>
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
                            <input type="text" class="form-control {{ $errors->has('description') ? ' has-error' : '' }}" placeholder="description" name="description" value="{{$servicer_job->description}}" required readonly maxlength="250">
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
                            <select class="form-control select2" data-live-search="true" title="Select Servicer" id="driver" name="driver" >
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
                           
                    </div>
    
                    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" style="margin-bottom: 1%!important;margin-top: 3%!important">Create Driver </button>



                      

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
                          <label for="fname" class="col-md-6 text-right control-label col-form-label">Registration Number</label>
                          <div class="form-group has-feedback">
                            <input type="text" class="form-control {{ $errors->has('register_number') ? ' has-error' : '' }}" placeholder="Registration Number" name="register_number" value="{{ old('register_number') }}" id="register_number" required>
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
                              <input type="file" class="form-control {{ $errors->has('file') ? ' has-error' : '' }}" placeholder="Choose File" name="file" id="file" value="{{ old('file') }}" required> 
                              </div>
                              @if ($errors->has('file'))
                                <span class="help-block">
                                    <strong class="error-text">{{ $errors->first('file') }}</strong>
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
                       <div class="form-group row" style="float:none!important">
                         <label for="fname" class="col-sm-5 text-right control-label col-form-label">Manufacturer</label>
                         <div class="form-group has-feedback">
                            <select class="form-control {{ $errors->has('make') ? ' has-error' : '' }}" placeholder="Name" name="make" value="{{ old('make') }}"  id="make" required onchange="getvehicleModel(this.value)">
                                <option value="" selected disabled>Select Vehicle Make</option>
                                 @foreach($makes as $make)
                                 <option value="{{$make->id}}">{{$make->name}}</option>
                                 @endforeach
                            </select>
                         </div>
                         @if ($errors->has('make'))
                         <span class="help-block">
                         <strong class="error-text">{{ $errors->first('make') }}</strong>
                         </span>
                         @endif
                      </div>

                       <div class="form-group row" style="float:none!important">
                         <label for="fname" class="col-sm-5 text-right control-label col-form-label">model</label>
                         <div class="form-group has-feedback">
                            <select class="form-control {{ $errors->has('vehicle_type_id') ? ' has-error' : '' }}" placeholder="Name" name="model" value="{{ old('model') }}"  id="model" required>
                                <option value="" selected disabled>Select Vehicle Model</option>
                                 @foreach($models as $model)
                                 <option value="{{$model->id}}">{{$model->name}}</option>
                                 @endforeach
                            </select>
                         </div>
                         @if ($errors->has('model'))
                         <span class="help-block">
                         <strong class="error-text">{{ $errors->first('model') }}</strong>
                         </span>
                         @endif
                      </div>
                     
                  
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
      <div class="modal-content" style="width: 60%!important">
        <button type="button" class="close" data-dismiss="modal" style="margin-left: 90%;margin-top: 2%">&times;</button>
        <div class="modal-header">
          
          <b>Create Driver</b>
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
        <div class="modal-footer" style="padding: 3% 34% 1% 18%!important">   
          <button type="button" id="btn" class="btn btn-primary" onclick="createDriver({{$servicer_job->id}})">Create</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
     
      </form> 
    </div>
         <!--  <p>Some text in the modal.</p> -->
        </div>
        </div>  
         </div>
         <button class="btn btn-primary nextBtn pull-right" type="button">Next</button>            
        </div>
      
        <div class="panel panel-primary setup-content" id="step-3">
            <div class="panel-heading">
                 <h4 class="panel-title">Command</h4>
            </div>
            <div class="panel-body">
            <div class="row">
            <?php foreach ($command_configuration as $command){ ?>
            <div class="col-lg-6">
            <div class="funkyradio">
            <div class="funkyradio-success">
                <input type="checkbox" name="checkbox[]" value="{{$list['id']}}" id="command{{$command['id']}}"/>
                <label for="command{{$command['id']}}">{{$command['command']}}</label>
            </div>
            </div>
            </div>
          
            <?php } ?>
            
            </div>
            
            <button class="btn btn-primary nextBtn pull-right" type="button">Next</button>
               
                
            </div>
            </div>
      
        
        <div class="panel panel-primary setup-content" id="step-4">
        <div id="email-list" class="col s10 m8 l8 card-panel z-depth-1">
  <ul class="collection">
    <li class="collection-item avatar email-unread">
      <label>
        <input type="checkbox" />
        <span></span>
      </label>
      <div class="mail-card-el">
        <span class="circle red lighten-1">A</span>
        <span class="email-title">Test card</span>
        <p class="truncate grey-text ultra-small">Summer sale is now going on.</p>
        <a href="#!" class="secondary-content email-time">
          <span class="blue-text ultra-small">12:10 am</span>
        </a>
      </div>
    </li>
  </ul>
</div>
             <!-- <div class="panel-heading">
                  <h3 class="panel-title">Cargo</h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="control-label">Company Name</label>
                    <input maxlength="200" type="text" required="required" class="form-control" placeholder="Enter Company Name" />
                </div>
                <div class="form-group">
                    <label class="control-label">Company Address</label>
                    <input maxlength="200" type="text" required="required" class="form-control" placeholder="Enter Company Address" />
                </div>
                <button class="btn btn-success pull-right" type="submit">Finish!</button>
            </div>
        </div>
    </form>
    </div>        
     </div>   -->
    </div>
   
       
<div class="clearfix"></div>
<link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet"/>
<style>
    #email-list .collection .collection-item.avatar {
  height: auto;
  padding-left: 72px;
  position: relative;
}

#email-list .collection .collection-item.avatar .secondary-content {
  position: absolute;
  top: 10px;
}

#email-list .collection .collection-item.avatar .secondary-content.email-time {
  right: 8px;
}

#email-list .collection .collection-item.avatar .icon {
  position: absolute;
  width: 42px;
  height: 42px;
  overflow: hidden;
  left: 15px;
  display: inline-block;
  text-align: center;
  vertical-align: middle;
  top: 20px;
}

#email-list .collection .collection-item.avatar .circle {
  position: absolute;
  width: 42px;
  height: 42px;
  overflow: hidden;
  left: 15px;
  display: inline-block;
  vertical-align: middle;
  text-align: center;
  font-size: 1.5rem;
  color: #fff;
  font-weight: 300;
  padding: 10px;
}

#email-list .collection .collection-item.avatar img.circle {
  padding: 0;
}

#email-list .collection .collection-item:hover {
  background: #e1f5fe;
  cursor: pointer;
}

#email-list .collection .collection-item.selected {
  background: #e1f5fe;
  border-left: 4px solid #29b6f6;
}

#email-list .attach-file {
  -ms-transform: rotate(90deg);
  -webkit-transform: rotate(90deg);
  transform: rotate(90deg);
  color: #bdbdbd;
  font-size: 1.1rem;
}


.select2{

width: 100% !important;

}
/* Latest compiled and minified CSS included as External Resource*/

/* Optional theme */

/*@import url('//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-theme.min.css');*/

.stepwizard-step p {
    margin-top: 0px;
    color:#666;
}
.stepwizard-row {
    display: table-row;
}
.stepwizard {
    display: table;
    width: 100%;
    position: relative;
}
.stepwizard-step button[disabled] {
    /*opacity: 1 !important;
    filter: alpha(opacity=100) !important;*/
}
.stepwizard .btn.disabled, .stepwizard .btn[disabled], .stepwizard fieldset[disabled] .btn {
    opacity:1 !important;
    color:#bbb;
}
.stepwizard-row:before {
    top: 14px;
    bottom: 0;
    position: absolute;
    content:" ";
    width: 100%;
    height: 1px;
    background-color: #ccc;
    z-index: 0;
}
.stepwizard-step {
    display: table-cell;
    text-align: center;
    position: relative;
}
.btn-circle {
    width: 30px;
    height: 30px;
    text-align: center;
    padding: 6px 0;
    font-size: 12px;
    line-height: 1.428571429;
    border-radius: 15px;
}


/* -------------checkbox styles----------------------- */
.funkyradio div {
  clear: both;
  overflow: hidden;
  padding-left: 20px;
}

.funkyradio label {
  width: 100%;
  border-radius: 3px;
  border: 1px solid #D1D3D4;
  font-weight: normal;
}

.funkyradio input[type="radio"]:empty,
.funkyradio input[type="checkbox"]:empty {
  display: none;
}

.funkyradio input[type="radio"]:empty ~ label,
.funkyradio input[type="checkbox"]:empty ~ label {
  position: relative;
  line-height: 2.5em;
  text-indent: 3.25em;
  margin-top: 2em;
  cursor: pointer;
  -webkit-user-select: none;
     -moz-user-select: none;
      -ms-user-select: none;
          user-select: none;
}

.funkyradio input[type="radio"]:empty ~ label:before,
.funkyradio input[type="checkbox"]:empty ~ label:before {
  position: absolute;
  display: block;
  top: 0;
  bottom: 0;
  left: 0;
  content: '';
  width: 2.5em;
  background: #D1D3D4;
  border-radius: 3px 0 0 3px;
}

.funkyradio input[type="radio"]:hover:not(:checked) ~ label,
.funkyradio input[type="checkbox"]:hover:not(:checked) ~ label {
  color: #888;
}

.funkyradio input[type="radio"]:hover:not(:checked) ~ label:before,
.funkyradio input[type="checkbox"]:hover:not(:checked) ~ label:before {
  content: '\2714';
  text-indent: .9em;
  color: #C2C2C2;
}

.funkyradio input[type="radio"]:checked ~ label,
.funkyradio input[type="checkbox"]:checked ~ label {
  color: #777;
}

.funkyradio input[type="radio"]:checked ~ label:before,
.funkyradio input[type="checkbox"]:checked ~ label:before {
  content: '\2714';
  text-indent: .9em;
  color: #333;
  background-color: #ccc;
}

.funkyradio input[type="radio"]:focus ~ label:before,
.funkyradio input[type="checkbox"]:focus ~ label:before {
  box-shadow: 0 0 0 3px #999;
}

.funkyradio-default input[type="radio"]:checked ~ label:before,
.funkyradio-default input[type="checkbox"]:checked ~ label:before {
  color: #333;
  background-color: #ccc;
}

.funkyradio-primary input[type="radio"]:checked ~ label:before,
.funkyradio-primary input[type="checkbox"]:checked ~ label:before {
  color: #fff;
  background-color: #337ab7;
}

.funkyradio-success input[type="radio"]:checked ~ label:before,
.funkyradio-success input[type="checkbox"]:checked ~ label:before {
  color: #fff;
  background-color: #5cb85c;
}

.funkyradio-danger input[type="radio"]:checked ~ label:before,
.funkyradio-danger input[type="checkbox"]:checked ~ label:before {
  color: #fff;
  background-color: #d9534f;
}

.funkyradio-warning input[type="radio"]:checked ~ label:before,
.funkyradio-warning input[type="checkbox"]:checked ~ label:before {
  color: #fff;
  background-color: #f0ad4e;
}

.funkyradio-info input[type="radio"]:checked ~ label:before,
.funkyradio-info input[type="checkbox"]:checked ~ label:before {
  color: #fff;
  background-color: #5bc0de;
}
/* -------------checkbox styles----------------------- */


</style>
@endsection
 @section('script')
 <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

 <script src="{{asset('js/gps/new-installation-step.js')}}"></script>
<script src="{{asset('js/gps/servicer-driver-create.js')}}"></script>
  @endsection