@extends('layouts.eclipse') 
@section('title')
   Update Sos Button details
@endsection
@section('content')

     

  <div class="page-wrapper page-wrapper_new">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Edit Sos Button</li>
         @if(Session::has('message'))
        <div class="pad margin no-print">
          <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
              {{ Session::get('message') }}  
          </div>
        </div>
        @endif 
      </ol>
    </nav>
  
      <div class="container-fluid">
        <div class="card-body">
          <section class="hilite-content">
       
   <form  method="POST" action="{{route('sos.update.p',$sos->id)}}">
        {{csrf_field()}}
    <div class="row">
        <div class="col-md-6">
          <div class="form-group has-feedback">
            <label class="srequired">Serial NO</label>
            <input type="number" class="form-control {{ $errors->has('serial_no') ? ' has-error' : '' }}" placeholder="Serial NO" name="serial_no" value="{{ $sos->imei}}"> 
          @if ($errors->has('serial_no'))
            <span class="help-block">
            <strong class="error-text">{{ $errors->first('serial_no') }}</strong>
            </span>
          @endif
          </div>

          <div class="form-group has-feedback">
            <label class="srequired">Model Name</label>
            <input type="text" class="form-control {{ $errors->has('model_name') ? ' has-error' : '' }}" placeholder="Model Name" name="model_name" value="{{ $sos->model_name}}"> 
          @if ($errors->has('model_name'))
            <span class="help-block">
            <strong class="error-text">{{ $errors->first('model_name') }}</strong>
            </span>
          @endif
          </div>
          

          <div class="form-group has-feedback">
            <label class="srequired">Manufacturing Date</label>
            <input type="date" class="form-control {{ $errors->has('manufacturing_date') ? ' has-error' : '' }}" placeholder="Manufacturing Date" name="manufacturing_date" value="{{ $sos->manufacturing_date}}" max="{{date('Y-m-d')}}"> 
            @if ($errors->has('manufacturing_date'))
              <span class="help-block">
              <strong class="error-text">{{ $errors->first('manufacturing_date') }}</strong>
              </span>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">

          <div class="form-group has-feedback">
            <label class="srequired">Brand</label>
            <input type="text" class="form-control {{ $errors->has('brand') ? ' has-error' : '' }}" placeholder="Brand" name="brand" value="{{ $sos->brand}}"> 
          @if ($errors->has('brand'))
            <span class="help-block">
            <strong class="error-text">{{ $errors->first('brand') }}</strong>
            </span>
          @endif
          </div>          

          <div class="form-group has-feedback">
            <label class="srequired">Version</label>
            <input type="text" class="form-control {{ $errors->has('version') ? ' has-error' : '' }}" placeholder="Version" name="version" value="{{ $sos->version}}"> 
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
          <button type="submit" class="btn btn-primary btn-md form-btn">Update</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
</section>
 
</div>
</div>
</div>
<div class="clearfix"></div>
   
@endsection