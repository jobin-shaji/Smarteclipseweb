@extends('layouts.gps')
@section('title')
    Update Alert Type Details
@endsection
@section('content')
    <section class="content-header">
     <h1>Edit Alert Type</h1>
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
            <i class="fa fa-edit"> Alert Type details</i> 
          </h2>
          @foreach($alert_type as $alert_type)
         
        </div>
        <!-- /.col -->
      </div>
    <form  method="POST" action="{{route('alert.types.update.p',$alert_type->id)}}" enctype="multipart/form-data">
        {{csrf_field()}}
      <div class="row">
        <div class="col-md-6">          
          <div class="form-group has-feedback">
            <label class="srequired">Code</label>
            <input type="text" class="form-control {{ $errors->has('code') ? ' has-error' : '' }}" placeholder="Code" name="code" value="{{ $alert_type->code}}"> 
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          @if ($errors->has('code'))
            <span class="help-block">
            <strong class="error-text">{{ $errors->first('code') }}</strong>
            </span>
          @endif
        <div class="form-group has-feedback">
          <label class="srequired">Description</label>
          <input type="text" class="form-control {{ $errors->has('description') ? ' has-error' : '' }}" placeholder="Description" name="description" value="{{ $alert_type->description}}">
          <span class="glyphicon glyphicon-phone form-control-feedback"></span>
        </div>
        @if ($errors->has('description'))
          <span class="help-block">
          <strong class="error-text">{{ $errors->first('description') }}</strong>
          </span>
        @endif
        <div class="form-group has-feedback">
          <label class="srequired">Upload Icon
          </label>
          <input type="file" class="form-control" placeholder="Choose File" name="path" value="{{$alert_type->path}}" > 
          <span class="glyphicon glyphicon-car form-control-feedback"></span>
        </div>
        @if ($errors->has('path'))
          <span class="help-block">
            <strong class="error-text">{{ $errors->first('path') }}</strong>
          </span>
        @endif


         @endforeach
          <div class="col-md-3 ">
          <button type="submit" class="btn btn-primary btn-md form-btn">Update</button>
        </div>
      </div>

    </form>
  </section>
  <!-- add depot user -->
  
<!-- add depot user -->

<div class="clearfix"></div>

@endsection