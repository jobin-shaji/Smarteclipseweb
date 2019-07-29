@extends('layouts.eclipse') 
@section('title')
    Create Sos Button
@endsection
@section('content')


<div class="page-wrapper page-wrapper-root page-wrapper_new">
<div class="page-wrapper-root1">
  
  <nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Create Sos Button</li>
  </ol>
</nav>       
        <div class="row">
          <div class="col-sm-12">
            <form  method="POST" action="{{route('sos.create.p')}}">
            {{csrf_field()}}
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group has-feedback">
                    <label class="srequired">Serial NO</label>
                    <input type="number" class="form-control {{ $errors->has('imei') ? ' has-error' : '' }}" placeholder="Serial NO" name="imei" value="{{ old('imei') }}" required> 
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
                    manufacturing_date form-control {{ $errors->has('manufacturing_date') ? ' has-error' : '' }}" placeholder="Purchase Date" name="manufacturing_date" value="{{ old('manufacturing_date') }}" required> 
                     @if ($errors->has('manufacturing_date'))
                    <span class="help-block">
                        <strong class="error-text">{{ $errors->first('manufacturing_date') }}</strong>
                    </span>
                  @endif
                  </div>

                  <div class="form-group has-feedback">
                    <label class="srequired">Brand</label>
                    <input type="text" class="form-control {{ $errors->has('brand') ? ' has-error' : '' }}" placeholder="Brand" name="brand" value="{{ old('brand') }}" required> 
                     @if ($errors->has('brand'))
                    <span class="help-block">
                        <strong class="error-text">{{ $errors->first('brand') }}</strong>
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