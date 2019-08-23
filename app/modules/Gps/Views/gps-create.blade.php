@extends('layouts.eclipse') 
@section('title')
    Create Device
@endsection
@section('content')


<div class="page-wrapper page-wrapper-root page-wrapper_new">
<div class="page-wrapper-root1">
  
  <nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Create Device</li>
    @if(Session::has('message'))
      <div class="pad margin no-print">
        <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
            {{ Session::get('message') }}  
        </div>
      </div>
    @endif 
  </ol>
</nav>       
        <div class="row">
          <div class="col-sm-12">
            <form  method="POST" action="{{route('gps.create.p')}}">
            {{csrf_field()}}
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group has-feedback">
                    <label class="srequired">IMEI</label>
                    <input type="number" class="form-control {{ $errors->has('imei') ? ' has-error' : '' }}" placeholder="IMEI" name="imei" value="{{ old('imei') }}" required> 
                     @if ($errors->has('imei'))
                    <span class="help-block">
                        <strong class="error-text">{{ $errors->first('imei') }}</strong>
                    </span>
                  @endif
                  </div>
                 

                  <div class="form-group has-feedback">
                    <label class="srequired">Model Name</label>
                    <input type="text" class="form-control {{ $errors->has('model_name') ? ' has-error' : '' }}" placeholder="Model Name" name="model_name" value="{{ old('model_name') }}" required>   
                    @if ($errors->has('model_name'))
                    <span class="help-block">
                        <strong class="error-text">{{ $errors->first('model_name') }}</strong>
                    </span>
                  @endif
                  </div>
                

                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group has-feedback">
                    <label class="srequired">Manufacturing Date</label>
                    <input type="text" class="
                    manufacturing_date form-control {{ $errors->has('manufacturing_date') ? ' has-error' : '' }}" placeholder="Manufacturing Date" name="manufacturing_date" value="{{ old('manufacturing_date') }}" required> 
                     @if ($errors->has('manufacturing_date'))
                    <span class="help-block">
                        <strong class="error-text">{{ $errors->first('manufacturing_date') }}</strong>
                    </span>
                  @endif
                  </div>

                  <div class="form-group has-feedback">
                    <label class="srequired">E-SIM Number</label>
                    <input type="number" class="form-control {{ $errors->has('e_sim_number') ? ' has-error' : '' }}" placeholder="E-SIM Number" name="e_sim_number" >
                    @if ($errors->has('e_sim_number'))
                    <span class="help-block">
                        <strong class="error-text">{{ $errors->first('e_sim_number') }}</strong>
                    </span>
                    @endif
                  </div>
                 

                  <div class="form-group has-feedback">
                    <label class="srequired">Batch Number</label>
                    <input type="text" class="form-control {{ $errors->has('batch_number') ? ' has-error' : '' }}" placeholder="Batch Number" name="batch_number" value="{{ old('batch_number') }}" required> 
                     @if ($errors->has('batch_number'))
                    <span class="help-block">
                        <strong class="error-text">{{ $errors->first('batch_number') }}</strong>
                    </span>
                  @endif
                  </div>


                  <div class="form-group has-feedback">
                    <label class="srequired">Employee Code</label>
                    <input type="text" class="form-control {{ $errors->has('employee_code') ? ' has-error' : '' }}" placeholder="Employee Code" name="employee_code" value="{{ old('employee_code') }}" required> 
                     @if ($errors->has('employee_code'))
                    <span class="help-block">
                        <strong class="error-text">{{ $errors->first('employee_code') }}</strong>
                    </span>
                  @endif
                  </div>
                 

                  <div class="form-group has-feedback">
                    <label class="srequired">Version</label>
                    <input type="text" class="form-control {{ $errors->has('version') ? ' has-error' : '' }}" placeholder="Version" name="version" value="{{ old('version') }}" required> 
                     @if ($errors->has('version'))
                    <span class="help-block">
                        <strong class="error-text">{{ $errors->first('version') }}</strong>
                    </span>
                  @endif
                  </div>
                 
                
                </div>
              </div>
              <div class="row">
                <!-- /.col -->
                <div class="col-md-3 ">
                  <button type="submit" class="btn btn-primary btn-md form-btn ">Save</button>
                </div>
                <!-- /.col -->
              </div>
            </form>
          </div>
        </div>
    </div>
  </div>
<div class="clearfix"></div>


@endsection