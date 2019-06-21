@extends('layouts.gps')
@section('title')
    Create Ota Type
@endsection


@section('content')
    <section class="content-header">
        <h1>Create Ota Type</h1>
    </section>
    @if(Session::has('message'))
    <div class="pad margin no-print">
      <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
          {{ Session::get('message') }}  
      </div>
    </div>
    @endif  
    <section class="hilite-content">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-plus-square"></i> 
          </h2>
        </div>
        <!-- /.col -->
      </div>
     <form  method="POST" action="{{route('ota-type.create.p')}}">
        {{csrf_field()}}
      <div class="row">
          <div class="col-md-6">
              <div class="form-group has-feedback">
                <label class="srequired">Name</label>
                <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{ old('name') }}" required> 
              </div>
              @if ($errors->has('name'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('name') }}</strong>
                </span>
              @endif
              <div class="form-group has-feedback">
                    <label class="srequired">Code</label>
                    <input type="text" class="form-control {{ $errors->has('code') ? ' has-error' : '' }}" placeholder="Code" name="code" value="{{ old('code') }}" required>
              </div>
              @if ($errors->has('code'))
                 <span class="help-block">
                    <strong class="error-text">{{ $errors->first('code') }}</strong>
                 </span>
              @endif
              <div class="form-group has-feedback">
                    <label>Default</label>
                    <input type="text" class="form-control {{ $errors->has('default_value') ? ' has-error' : '' }}" placeholder="Default Value" name="default_value" value="{{ old('default_value') }}">
              </div>
              @if ($errors->has('default_value'))
                 <span class="help-block">
                    <strong class="error-text">{{ $errors->first('default_value') }}</strong>
                 </span>
              @endif

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
</section>
 
<div class="clearfix"></div>

@endsection