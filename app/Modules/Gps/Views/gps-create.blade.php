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
    <form  method="POST" action="{{route('gps.create.p')}}">
      {{csrf_field()}}     
      <div class="row">
        <div class="col-lg-6 col-md-12">
          <div id="zero_config_wrapper" class="container-fluid dt-bootstrap4">
            <div class="row">
              <div class="col-sm-12">                    
                <div class="row">
                  <div class="col-md-6">
                    <div class="card-body_vehicle wizard-content">   
                      <div class="form-group has-feedback">
                        <label class="srequired">Serial No</label>
                        <input type="text" class="form-control {{ $errors->has('serial_no') ? ' has-error' : '' }}" placeholder="Serial No" name="serial_no"  min="0" required> 
                          @if ($errors->has('serial_no'))
                            <span class="help-block">
                              <strong class="error-text">{{ $errors->first('serial_no') }}</strong>
                            </span>
                          @endif
                      </div>

                      <div class="form-group has-feedback">
                        <label class="srequired">IMEI</label>
                        <input type="number" value="{{ old('imei') }}" class="form-control {{ $errors->has('imei') ? ' has-error' : '' }}" placeholder="IMEI" name="imei" maxlength="15" required> 
                          @if ($errors->has('imei'))
                            <span class="help-block">
                              <strong class="error-text">{{ $errors->first('imei') }}</strong>
                            </span>
                          @endif
                      </div>
                    
                      <div class="form-group has-feedback">
                        <label class="srequired">Manufacturing Date</label>
                        <input type="date" class="form-control {{ $errors->has('manufacturing_date') ? ' has-error' : '' }}"  name="manufacturing_date" value="{{ old('manufacturing_date') }}" required> 
                        @if ($errors->has('manufacturing_date'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('manufacturing_date') }}</strong>
                          </span>
                        @endif
                      </div>

                      <div class="form-group has-feedback">
                        <label class="srequired">ICC ID-1</label>
                        <input type="text" class="form-control {{ $errors->has('icc_id') ? ' has-error' : '' }}" placeholder="ICC ID-1" name="icc_id" value="{{ old('icc_id') }}" required  min="0"> 
                          @if ($errors->has('icc_id'))
                            <span class="help-block">
                              <strong class="error-text">{{ $errors->first('icc_id') }}</strong>
                            </span>
                          @endif
                      </div>
                      <div class="form-group has-feedback">
                        <label class="srequired">ICC ID-2</label>
                        <input type="text" class="form-control {{ $errors->has('icc_id1') ? ' has-error' : '' }}" placeholder="ICC ID-2" name="icc_id1" value="{{ old('icc_id1') }}" required  min="0"> 
                          @if ($errors->has('icc_id1'))
                            <span class="help-block">
                              <strong class="error-text">{{ $errors->first('icc_id1') }}</strong>
                            </span>
                          @endif
                      </div>

                      <div class="form-group has-feedback">
                        <label class="srequired">IMSI</label>
                        <input type="text" class="form-control {{ $errors->has('imsi') ? ' has-error' : '' }}" placeholder="IMSI" name="imsi"  value="{{ old('imsi') }}" required min="0"> 
                          @if ($errors->has('imsi'))
                            <span class="help-block">
                              <strong class="error-text">{{ $errors->first('imsi') }}</strong>
                            </span>
                          @endif
                      </div>   
                      <div class="form-group has-feedback">
                        <label class="srequired">Vehicle No</label>
                        <input type="text" class="form-control {{ $errors->has('vehicle_no') ? ' has-error' : '' }}" placeholder="Vehicle No" name="vehicle_no"  min="0"> 
                          @if ($errors->has('vehicle_no'))
                            <span class="help-block">
                              <strong class="error-text">{{ $errors->first('vehicle_no') }}</strong>
                            </span>
                          @endif
                      </div>   
                      <div class="form-group has-feedback">
                        <label class="srequired">Validity</label>
                        <input type="text" class="form-control {{ $errors->has('validity') ? ' has-error' : '' }}" placeholder="Validity" name="validity"  min="0"> 
                          @if ($errors->has('validity'))
                            <span class="help-block">
                              <strong class="error-text">{{ $errors->first('validity') }}</strong>
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
          <div id="zero_config_wrapper" class="container-fluid dt-bootstrap4">
            <div class="row">
              <div class="col-sm-12">                    
                <div class="row">
                  <div class="col-md-6">
                    <div class="card-body_vehicle wizard-content"> 
                    <div class="form-group has-feedback">
                        <label class="srequired">Service Provider-1</label>
                        <select class="form-control {{ $errors->has('provider1') ? ' has-error' : '' }}"  name="provider1" id="provider1" value="{{ old('provider1') }}" required>
                      <option>Select A Provider</option>
                      <option value="BSNL">BSNL</option>
                      <option value="VODAFONE">VODAFONE</option>
                      <option value="AIRTEL">AIRTEL</option>
                      <option value="JIO">JIO</option>
                    
                    </select>   
                      @if ($errors->has('provider1'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('provider1') }}</strong>
                          </span>
                        @endif
                      </div>  
                      <div class="form-group has-feedback">
                        <label class="srequired">E-SIM Number-1</label>
                        <input type="number" required pattern="[0-9]{13}" class="form-control {{ $errors->has('e_sim_number') ? ' has-error' : '' }}" placeholder="E-SIM Number-1" id="e_sim_number" name="e_sim_number"  maxlength="13"> 
                         @if ($errors->has('e_sim_number'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('e_sim_number') }}</strong>
                          </span>
                        @endif
                      </div>
                      <div class="form-group has-feedback">
                        <label class="srequired">Service Provider-2</label>
                        <select class="form-control {{ $errors->has('provider2') ? ' has-error' : '' }}"  name="provider2" id="provider2" value="{{ old('provider2') }}" required>
                      <option>Select A Provider</option>
                      <option value="BSNL">BSNL</option>
                      <option value="VODAFONE">VODAFONE</option>
                      <option value="AIRTEL">AIRTEL</option>
                      <option value="JIO">JIO</option>
                    
                    </select>
                        @if ($errors->has('e_sim_number'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('e_sim_number') }}</strong>
                          </span>
                        @endif
                      </div>  
                      <div class="form-group has-feedback">
                        <label class="srequired">E-SIM Number-2</label>
                        <input type="number" required pattern="[0-9]{13}" class="form-control {{ $errors->has('e_sim_number1') ? ' has-error' : '' }}" placeholder="E-SIM Number-2" name="e_sim_number1"  maxlength="13"> 
                         @if ($errors->has('e_sim_number1'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('e_sim_number1') }}</strong>
                          </span>
                        @endif
                      </div>

                      <div class="form-group has-feedback">
                        <label class="srequired">Batch Number</label>
                        <input type="text" class="form-control {{ $errors->has('batch_number') ? ' has-error' : '' }}" placeholder="Batch Number" name="batch_number" value="{{ old('batch_number') }}" required > 
                         @if ($errors->has('batch_number'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('batch_number') }}</strong>
                          </span>
                        @endif
                      </div>

                       <div class="form-group has-feedback">
                        <label class="srequired">Employee Code</label>
                        <input type="text" class="form-control {{ $errors->has('employee_code') ? ' has-error' : '' }}" placeholder="Employee Code" id="employee_code" name="employee_code" value="{{ old('employee_code') }}" required > 
                         @if ($errors->has('employee_code'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('employee_code') }}</strong>
                          </span>
                        @endif
                      </div>

                      <div class="form-group has-feedback">
                        <label class="srequired">Model Name</label>
                        <input type="text" class="form-control {{ $errors->has('model_name') ? ' has-error' : '' }}" id="model_name" name="model_name" value="{{ old('model_name') }}" > 
                         @if ($errors->has('model_name'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('model_name') }}</strong>
                          </span>
                        @endif
                      </div>

                      <div class="form-group has-feedback">
                        <label class="srequired">Version</label>
                        <input type="text" class="form-control {{ $errors->has('version') ? ' has-error' : '' }}" placeholder="Version" id="version" name="version" value="{{ old('version') }}" required >
                        @if ($errors->has('version'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('version') }}</strong>
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
      <div class="row">
        <div class="col-lg-6 col-md-12">
          <div id="zero_config_wrapper" class="container-fluid dt-bootstrap4">
            <div class="row">
              <button type="submit" class="btn btn-primary address_btn">Create</button>
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