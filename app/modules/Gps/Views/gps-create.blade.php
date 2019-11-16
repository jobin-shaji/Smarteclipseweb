@extends('layouts.eclipse')
@section('title')
  Device Creation
@endsection
@section('content')   
<style type="text/css">
  .pac-container { position: relative !important;top: -290px !important;margin:0px }
</style>
<section class="hilite-content">
  <div class="page-wrapper_new">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Create Device</li>
     </ol>
       @if(Session::has('message'))
          <div class="pad margin no-print">
            <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
                {{ Session::get('message') }}  
            </div>
          </div>
        @endif  
    </nav>
    <form  method="POST" action="{{route('gps.create.p')}}">
      {{csrf_field()}}     
      <div class="row" style="margin-left: 40%;width: 100%;height: 100%">
        <div class="col-md-4">
          <div class="card-body_vehicle wizard-content">   
            <div class="form-group has-feedback">
              <label class="srequired">Serial No</label>
              <input type="text" class="{{ $errors->has('serial_no') ? ' has-error' : '' }}" placeholder="serial_no" id="serial_no" name="serial_no" value="{{ old('serial_no') }}" style="margin-left: 23%" required > 
              <!-- 
               <select class="form-control select2 GpsData" id="serial_no" name="serial_no" data-live-search="true" title="Select Serial number" required>
                <option value="" selected="selected" disabled="disabled">Select Serial number</option>
                @foreach($devices as $device)
                <option value="{{$device->id}}">{{$device->serial_no}}</option>
                @endforeach
              </select>
               @if ($errors->has('serial_no'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('serial_no') }}</strong>
                </span>
              @endif -->               
            </div>
            <div class="form-group has-feedback">
              <label class="srequired pdd">IMEI</label>
              <input type="number" class=" {{ $errors->has('imei') ? ' has-error' : '' }}" placeholder="IMEI" id="imei" name="imei" value="{{ old('imei') }}" style="margin-left: 31.5%" required > 
              @if ($errors->has('imei'))
                <span class="help-block">
                  <strong class="error-text">{{ $errors->first('imei') }}</strong>
                </span>
              @endif
            </div>             
            <div class="form-group has-feedback">
              <label class="srequired">Model Name</label>
              <input type="text" class=" {{ $errors->has('model_name') ? ' has-error' : '' }}" placeholder="Model Name" id="model_name" name="model_name" value="{{ old('model_name') }}" style="margin-left: 17.5%" required >   
              @if ($errors->has('model_name'))
                <span class="help-block">
                  <strong class="error-text">{{ $errors->first('model_name') }}</strong>
                </span>
              @endif
            </div>
            <div class="form-group has-feedback">
              <label class="srequired">Manufacturing Date</label>
              <input type="text" class="manufacturing_date {{ $errors->has('manufacturing_date') ? ' has-error' : '' }}" placeholder="Manufacturing Date" name="manufacturing_date" value="{{ old('manufacturing_date') }}" style="margin-left: 5%" required> 
              @if ($errors->has('manufacturing_date'))
                <span class="help-block">
                  <strong class="error-text">{{ $errors->first('manufacturing_date') }}</strong>
                </span>
              @endif
            </div>
            <div class="form-group has-feedback">
              <label class="srequired">ICC ID</label>
              <input type="text" class="{{ $errors->has('icc_id') ? ' has-error' : '' }}" placeholder="ICC ID" id="icc_id" name="icc_id" value="{{ old('icc_id') }}" style="margin-left: 29%" required > 
              @if ($errors->has('icc_id'))
                <span class="help-block">
                  <strong class="error-text">{{ $errors->first('icc_id') }}</strong>
                </span>
              @endif
            </div>                           
          </div>
        </div>       
        <div class="row">
          <div class="col-md-4">
            <div class="card-body_vehicle wizard-content"> 
              <div class="form-group has-feedback">
                <label class="srequired">E-SIM Number</label>
                <input type="number" class="{{ $errors->has('e_sim_number') ? ' has-error' : '' }}" placeholder="E-SIM Number" id="e_sim_number" name="e_sim_number" style="margin-left: 15.5%" required>
                @if ($errors->has('e_sim_number'))
                  <span class="help-block">
                    <strong class="error-text">{{ $errors->first('e_sim_number') }}</strong>
                  </span>
                @endif
              </div>
            <div class="form-group has-feedback">
              <label class="srequired ">Batch Number</label>
              <input type="text" class="{{ $errors->has('brand') ? ' has-error' : '' }}" placeholder="Batch Number" id="batch_number" name="batch_number" value="{{ old('batch_number') }}" style="margin-left: 15.5%" required>
              @if ($errors->has('batch_number'))
                <span class="help-block">
                  <strong class="error-text">{{ $errors->first('batch_number') }}</strong>
                </span>
              @endif
            </div>
            <div class="form-group has-feedback">
              <label class="srequired">Employee Code</label>
              <input type="text" class="{{ $errors->has('employee_code') ? ' has-error' : '' }}" placeholder="Employee Code" id="employee_code" name="employee_code" value="{{ old('employee_code') }}" style="margin-left: 14%" required > 
              @if ($errors->has('employee_code'))
                <span class="help-block">
                  <strong class="error-text">{{ $errors->first('employee_code') }}</strong>
                </span>
              @endif
            </div>
            <div class="form-group has-feedback">
              <label class="srequired">IMSI</label>
              <input type="text" class="{{ $errors->has('imsi') ? ' has-error' : '' }}" placeholder="IMSI" id="imsi" name="imsi" value="{{ old('imsi') }}" style="margin-left: 34%" required > 
              @if ($errors->has('imsi'))
                <span class="help-block">
                  <strong class="error-text">{{ $errors->first('imsi') }}</strong>
                </span>
              @endif
            </div>   
            <div class="form-group has-feedback">
              <label class="srequired ">Version</label>
              <input type="text" class="{{ $errors->has('version') ? ' has-error' : '' }}" placeholder="Version" id="version" name="version" value="{{ old('version') }}" style="margin-left: 28%" required > 
              @if ($errors->has('version'))
                <span class="help-block">
                  <strong class="error-text">{{ $errors->first('version') }}</strong>
                </span>
              @endif
              <div class="row">
                <button type="submit" class="btn btn-primary address_btn">Create</button>
              </div>
            </div> 
          </div>
        </div>
      </div>
    </form>
  </div>
</section>

<div class="clearfix"></div>
<!-- @section('script')
  <script src="{{asset('js/gps/gps-create.js')}}"></script>
@endsection -->
@endsection