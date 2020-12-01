@extends('layouts.eclipse')
@section('title')
Assign Servicer
@endsection
@section('content')
<!------ Include the above in your HEAD tag ---------->
<div class="page-wrapper page-wrapper-root page-wrapper_new">
<div class="page-wrapper-root1">
<nav aria-label="breadcrumb">
<ol class="breadcrumb">
<li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Vehicle Details</li>
<b>Vehicle Details</b>
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
<a href="#step-1" type="button" class="btn btn-success btn-circle" disabled="disabled">1</a>
<p><small>Installation Job checklist</small></p>
</div>
<div class="stepwizard-step col-xs-3"> 
<a href="#step-2" type="button" class="btn btn-default btn-circle">2</a>
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


<div class="panel panel-primary setup-content" id="step-2">
<form method="POST" action="{{route('vehiclejob.complete.save.p',$pass_servicer_jobid)}}"enctype="multipart/form-data">
<div class="row">
<div class="col-md-6"> 
{{csrf_field()}}
<div class="card">
<div class="card-body"> 
<div class="form-group row" style="float:none!important">
<label for="fname" class="col-sm-3 text-right control-label col-form-label">End User</label>
<div class="form-group has-feedback">
<input type="text" class="form-control {{ $errors->has('client') ? ' has-error' : '' }}" name="client" value="{{$servicer_job->clients->name}}" required readonly>
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
<input type="text" class="form-control {{ $errors->has('job_type') ? ' has-error' : '' }}" name="job_type" value="<?php if($servicer_job['job_type']==1){echo 'Installation';} else if($servicer_job['job_type']==2){echo 'Service';} else if($servicer_job['job_type']==3){echo 'Reinstallation';} ?>" required readonly>
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



<input type="hidden" name="client_id" id="client_id" value="{{$servicer_job->clients->id}}" >
<input type="hidden" name="servicer_job_id" id="servicer_job_id" value="{{$servicer_job->id}}" > 

@if ($servicer_job['job_type']==1)
    <div class="form-group row" style="float:none!important">
    <label for="fname" class="col-sm-3 text-right control-label col-form-label">Vehicle Name</label>
    <div class="form-group has-feedback">
    <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" id="name" value="{{ old('name') }}" maxlength="50" required> 
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
    <input type="text" class="form-control {{ $errors->has('register_number') ? ' has-error' : '' }}" placeholder="Registration Number" name="register_number" maxlength="20" value="{{ old('register_number') }}" maxlength="20" id="register_number" required>
    <p style="color:#FF0000" id="message1"> Spaces not  allowed for registration number</p>
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
    <input type="text" class="form-control {{ $errors->has('engine_number') ? ' has-error' : '' }}" placeholder="Engine Number" name="engine_number" maxlength="50" value="{{ old('engine_number') }}" maxlength="20" id="engine_number" required>
    <p style="color:#FF0000" id="message2"> Spaces not  allowed for engine number</p>
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
    <input type="text" class="form-control {{ $errors->has('chassis_number') ? ' has-error' : '' }}" placeholder="Chassis Number" name="chassis_number" maxlength="50" value="{{ old('chassis_number') }}" maxlength="20" id="chassis_number" required>
    <p style="color:#FF0000" id="message3"> Spaces not  allowed for chassis number</p>
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
    <input type="file" class="form-control {{ $errors->has('file') ? ' has-error' : '' }}" placeholder="Choose File" name="file" id="file" value="{{ old('file') }}" required accept="image/png, image/jpeg"> 
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
    <input type="file" class="form-control {{ $errors->has('installation_photo') ? ' has-error' : '' }}" placeholder="Choose File" name="installation_photo" id="installation_photo" value="{{ old('installation_photo') }}" required accept="image/png, image/jpeg"> 
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
    <input type="file" class="form-control {{ $errors->has('activation_photo') ? ' has-error' : '' }}" placeholder="Choose File" name="activation_photo" id="activation_photo" value="{{ old('activation_photo') }}" required accept="image/png, image/jpeg"> 
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
    <input type="file" class="form-control {{ $errors->has('vehicle_photo') ? ' has-error' : '' }}" placeholder="Choose File" name="vehicle_photo" id="vehicle_photo" value="{{ old('vehicle_photo') }}" required accept="image/png, image/jpeg"> 
    </div>
    @if ($errors->has('vehicle_photo'))
    <span class="help-block">
    <strong class="error-text">{{ $errors->first('vehicle_photo') }}</strong>
    </span>
    @endif
    </div>


     <div class="form-group row" style="float:none!important">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label" id="expiry_heading" > Rc Expiry Date</label> 
                          <div class="form-group has-feedback">
                            <input type="text" class="date_expiry form-control {{ $errors->has('expiry_date') ? ' has-error' : '' }}" placeholder="Choose Expiry Date" name="expiry_date" id="expiry_date"  value="{{ old('expiry_date') }}" > 
                          </div>
                          <span class="error_expiry_date" style='color:red;'></span>
                      </div>

    <div class="form-group row" style="float:none!important">
    <label for="fname" class="col-sm-5 text-right control-label col-form-label">Vehicle Type</label>
    <div class="form-group has-feedback">
    <select class="form-control {{ $errors->has('vehicle_type_id') ? ' has-error' : '' }}" placeholder="Name" name="vehicle_type_id" value="{{ old('vehicle_type_id') }}" id="vehicle_type_id" required>
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
    <select class="form-control {{ $errors->has('make') ? ' has-error' : '' }}" placeholder="Name" name="make" value="{{ old('make') }}" id="make" required onchange="getvehicleModel(this.value)">
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
    <select class="form-control {{ $errors->has('vehicle_type_id') ? ' has-error' : '' }}" placeholder="Name" name="model" value="{{ old('model') }}" id="model" required>
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
@elseif ($servicer_job['job_type']==3)
    <div class="form-group row" style="float:none!important">
        <label class="col-sm-5 text-right control-label col-form-label">Vehicle</label>
        <div class="form-group has-feedback">
            <select class="form-control selectpicker" data-live-search="true" title="Select Vehicle" id="vehicle_id" name="vehicle_id" required>
                <option value="{{$servicer_job->reinstallationVehicle->id}}">{{$servicer_job->reinstallationVehicle->name}} || {{$servicer_job->reinstallationVehicle->register_number}}</option>
            </select> 
        </div>
        @if ($errors->has('vehicle_id'))
            <span class="help-block">
                <strong class="error-text">{{ $errors->first('vehicle_id') }}</strong>
            </span>
        @endif 
    </div> 
@endif

<!-- <div class="form-group row" style="float:none!important">
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
</div> -->

<div class="row">
<div class="col-md-3 ">
<button type="submit" class="btn btn-primary btn-md form-btn ">Next</button>
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
<form method="POST" id="form1">
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
<label for="fname" class="col-sm-3 text-right control-label col-form-label ">Name&nbsp<font color="red">*</font></label>
<div class="form-group has-feedback">
<input type="text" pattern="[A-Za-z]{1,50}" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="driver_name" id="driver_name" maxlength='50' value="{{ old('name') }}"> 
<p style="color:#FF0000;display:none;" class="name_message">only characters are allowed</p>

</div>
@if ($errors->has('name'))
<span class="help-block">
<strong class="error-text">{{ $errors->first('name') }}</strong>
</span>
@endif
</div>
<?php
$url=url()->current();
$rayfleet_key="rayfleet";
$eclipse_key="eclipse";
if (strpos($url, $rayfleet_key) == true) {  ?>
    <div class="form-group row form-group-driver">
    <label for="fname" class="col-sm-9 text-right control-label col-form-label label-form-drive">Mobile Number</label>
    <div class="form-group has-feedback form-drive-outer">
        <input type="text" id="mobile" required pattern="[0-9]{11}" class="form-control {{ $errors->has('mobile') ? ' has-error' : '' }}" placeholder="Mobile Number" name="mobile" value="{{ old('mobile') }}" maxlength="11" title="Mobile number should be exactly 11 digits" /> 
    </div>
    @if ($errors->has('mobile'))
    <span class="help-block">
        <strong class="error-text">{{ $errors->first('mobile') }}</strong>
    </span>
    @endif
</div>
<?php } 
else if (strpos($url, $eclipse_key) == true) { ?>
    <div class="form-group row form-group-driver">
    <label for="fname" class="col-sm-9 text-right control-label col-form-label label-form-drive">Mobile Number</label>
    <div class="form-group has-feedback form-drive-outer">
    <input type="text" id="mobile" required pattern="[0-9]{10}" class="form-control {{ $errors->has('mobile') ? ' has-error' : '' }}" placeholder="Mobile Number" name="mobile" value="{{ old('mobile') }}"  maxlength="10" title="Mobile number should be exactly 10 digits" />
    </div>
    @if ($errors->has('mobile'))
    <span class="help-block">
        <strong class="error-text">{{ $errors->first('mobile') }}</strong>
    </span>
    @endif
</div>
<?php }
else { ?>
    <div class="form-group row form-group-driver">
    <label for="fname" class="col-sm-9 text-right control-label col-form-label label-form-drive">Mobile Number</label>
    <div class="form-group has-feedback form-drive-outer">
    <input type="text" id="mobile" required pattern="[0-9]{10}" class="form-control {{ $errors->has('mobile') ? ' has-error' : '' }}" placeholder="Mobile Number" name="mobile" value="{{ old('mobile') }}"  maxlength="10" title="Mobile number should be exactly 10 digits" />
    </div>
    @if ($errors->has('mobile'))
    <span class="help-block">
        <strong class="error-text">{{ $errors->first('mobile') }}</strong>
    </span>
    @endif
</div>
<?php } ?>
<div class="form-group row" style="float:none!important">
<label for="fname" class="col-sm-3 text-right control-label col-form-label">Address</label>
<div class="form-group has-feedback">
<textarea class="form-control driver_address {{ $errors->has('address') ? ' has-error' : '' }}" placeholder="Address" name="address" id="address" maxlength='150' rows=5></textarea>
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
</div> --> 
<div class="modal-footer" style="padding: 3% 34% 1% 18%!important"> 
<button type="button" id="btn" class="btn btn-primary" onclick="createDriver({{$servicer_job->id}})">Create</button>
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
</form> 
</div>
<!-- <p>Some text in the modal.</p> -->
</div>
</div> 
</div>

</div>
</div>
</div>
</div>
@endsection
@section('script')
<link rel="stylesheet" href="{{asset('css/installation-step-servicer.css')}}">
<!-- <script src="{{asset('js/gps/new-installation-step.js')}}"></script> -->
<script src="{{asset('js/gps/servicer-driver-create.js')}}"></script>
<script>
$(document).ready(function() {
  $("#message1").hide();
  $("#message2").hide();
  $("#message3").hide();
});
$('#engine_number').keypress(function(e) {
  $("#message2").hide();

  if (e.which === 32) {
      $("#message2").show();
      e.preventDefault();
  }
});
$('#chassis_number').keypress(function(e) {
  $("#message3").hide();

  if (e.which === 32) {
      $("#message3").show();
      e.preventDefault();
  }
});
$('#register_number').keypress(function(e) {
  $("#message1").hide();

  if (e.which === 32) {
      $("#message1").show();
      e.preventDefault();
  }
});

$('#driver_name').keypress(function(e) {
    var keyCode = e.which;
    if (keyCode >= 48 && keyCode <= 57) {
        $(".name_message").show();
        e.preventDefault();
    }
});
</script>
@endsection
