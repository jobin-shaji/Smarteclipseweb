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
        <b>Create Device</b>
      </ol>
       @if(Session::has('message'))
          <div class="pad margin no-print">
            <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
                {{ Session::get('message') }}  
            </div>
          </div>
        @endif  
    </nav>

    <form  method="POST" action="{{route('gps.stock.p')}}">
      {{csrf_field()}}
      <div class="form-group">
        <label class="srequired" style="padding: 0 9.3% 0 2%;">Serial No</label>
        <select class="select2 GpsData" id="serial_no" name="serial_no" data-live-search="true" title="Select Serial number" required>
          <option value="" selected="selected" disabled="disabled">Select Serial number</option>
          @foreach($devices as $device)
            <option value="{{$device->id}}">{{$device->serial_no}}</option>
          @endforeach
        </select>
        @if ($errors->has('serial_no'))
          <span class="help-block">
            <strong class="error-text">{{ $errors->first('serial_no') }}</strong>
          </span>
        @endif   
      </div>


      <div class="form-group">
        <label class="srequired" style="padding: 0 12.2% 0 2%;">IMEI</label>
        <input type="number" class="{{ $errors->has('imei') ? ' has-error' : '' }}" placeholder="IMEI" id="imei" name="imei" value="{{ old('imei') }}" required  readonly="readonly"> 
        @if ($errors->has('imei'))
          <span class="help-block">
            <strong class="error-text">{{ $errors->first('imei') }}</strong>
          </span>
        @endif 
      </div>
      <div class="form-group">
        <label class="srequired" style="padding: 0 7.2% 0 2%;">Model Name</label>
        <input type="text" class="{{ $errors->has('model_name') ? ' has-error' : '' }}" placeholder="Model Name" id="model_name" name="model_name" value="{{ old('model_name') }}" required readonly="readonly">
        @if ($errors->has('model_name'))
          <span class="help-block">
            <strong class="error-text">{{ $errors->first('model_name') }}</strong>
          </span>
        @endif
      </div>
      <div class="form-group">
        <label class="srequired" style="padding: 0 3% 0 2%;">Manufacturing Date</label>
        <input type="text" class="manufacturing_date {{$errors->has('manufacturing_date') ? ' has-error' : '' }}" placeholder="Manufacturing Date" name="manufacturing_date" value="{{ old('manufacturing_date') }}" required> 
        @if ($errors->has('manufacturing_date'))
          <span class="help-block">
            <strong class="error-text">{{ $errors->first('manufacturing_date') }}</strong>
          </span>
        @endif
      </div>
      <div class="form-group">
        <label class="srequired" style="padding: 0 11.3% 0 2%;">ICC ID</label>
        <input type="text" class="{{ $errors->has('icc_id') ? ' has-error' : '' }}" placeholder="ICC ID" id="icc_id" name="icc_id" value="{{ old('icc_id') }}" required readonly="readonly"> 
        @if ($errors->has('icc_id'))
          <span class="help-block">
            <strong class="error-text">{{ $errors->first('icc_id') }}</strong>
          </span>
        @endif
      </div>
      <div class="form-group">
        <label class="srequired" style="padding: 0 6.2% 0 2%;">E-SIM Number</label>
        <input type="number" class="{{ $errors->has('e_sim_number') ? ' has-error' : '' }}" placeholder="E-SIM Number" id="e_sim_number" name="e_sim_number"  >
        @if ($errors->has('e_sim_number'))
          <span class="help-block">
            <strong class="error-text">{{ $errors->first('e_sim_number') }}</strong>
          </span>
        @endif
      </div>
      <div class="form-group">
        <label class="srequired" style="padding: 0 6.2% 0 2%;">Batch Number</label>
        <input type="text" class="{{ $errors->has('brand') ? ' has-error' : '' }}" placeholder="Batch Number" id="batch_number" name="batch_number" value="{{ old('batch_number') }}" required readonly="readonly"> 
        @if ($errors->has('batch_number'))
          <span class="help-block">
            <strong class="error-text">{{ $errors->first('batch_number') }}</strong>
          </span>
        @endif
      </div>
      <div class="form-group">
        <label class="srequired" style="padding: 0 5.6% 0 2%;">Employee Code</label>
        <input type="text" class="{{ $errors->has('employee_code') ? ' has-error' : '' }}" placeholder="Employee Code" id="employee_code" name="employee_code" value="{{ old('employee_code') }}" required readonly="readonly"> 
        @if ($errors->has('employee_code'))
          <span class="help-block">
            <strong class="error-text">{{ $errors->first('employee_code') }}</strong>
          </span>
        @endif
      </div>
      <div class="form-group">
        <label class="srequired " style="padding: 0 12.3% 0 2%;">IMSI</label>
        <input type="text" class=" {{ $errors->has('imsi') ? ' has-error' : '' }}" placeholder="IMSI" id="imsi" name="imsi" value="{{ old('imsi') }}" required readonly="readonly"> 
        @if ($errors->has('imsi'))
          <span class="help-block">
            <strong class="error-text">{{ $errors->first('imsi') }}</strong>
          </span>
        @endif
      </div>
      <div class="form-group">
        <label class="srequired " style="padding: 0 10.3% 0 2%;">Version</label>
        <input type="text" class="{{ $errors->has('version') ? ' has-error' : '' }}" placeholder="Version" id="version" name="version" value="{{ old('version') }}" required readonly="readonly"> 
        @if ($errors->has('version'))
          <span class="help-block">
            <strong class="error-text">{{ $errors->first('version') }}</strong>
          </span>
        @endif
      </div>      
      <div class="form-group">
        <button type="submit" class="btn btn-primary address_btn">Create</button>  
      </div> 
    </form>
  </div>
</section>

<div class="clearfix"></div>
@section('script')
  <script src="{{asset('js/gps/gps-create.js')}}"></script>
@endsection
@endsection