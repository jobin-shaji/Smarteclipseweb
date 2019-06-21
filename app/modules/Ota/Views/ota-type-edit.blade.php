@extends('layouts.gps')
@section('title')
    Update Ota Type
@endsection
@section('content')
    <section class="content-header">
     <h1>Edit Ota Type</h1>
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
            <i class="fa fa-edit">Update Ota Type</i> 
          </h2>
        </div>
        <!-- /.col -->
      </div>
    <form  method="POST" action="{{route('ota-type.update.p',$ota_type->id)}}">
        {{csrf_field()}}
    <div class="row">
        <div class="col-md-6">
          
          <div class="form-group has-feedback">
            <label class="srequired">Name</label>
            <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{ $ota_type->name}}"> 
          </div>
          @if ($errors->has('name'))
            <span class="help-block">
            <strong class="error-text">{{ $errors->first('name') }}</strong>
            </span>
          @endif

          <div class="form-group has-feedback">
            <label class="srequired">Code</label>
            <input type="text" class="form-control {{ $errors->has('code') ? ' has-error' : '' }}" placeholder="Code" name="code" value="{{ $ota_type->code}}"> 
          </div>
          @if ($errors->has('code'))
            <span class="help-block">
            <strong class="error-text">{{ $errors->first('code') }}</strong>
            </span>
          @endif

          <div class="form-group has-feedback">
            <label>Default</label>
            <input type="text" class="form-control {{ $errors->has('default_value') ? ' has-error' : '' }}" placeholder="Default Value" name="default_value" value="{{ $ota_type->default_value}}"> 
          </div>
          @if ($errors->has('default_value'))
            <span class="help-block">
            <strong class="error-text">{{ $errors->first('default_value') }}</strong>
            </span>
          @endif

        
          <div class="col-md-3 ">
          <button type="submit" class="btn btn-primary btn-md form-btn">Update</button>
        </div>
      </div>
    </form>
</section>


<div class="clearfix"></div>

@endsection