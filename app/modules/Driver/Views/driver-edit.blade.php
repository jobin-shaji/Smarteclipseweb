@extends('layouts.gps')
@section('title')
    Update Driver Details
@endsection
@section('content')
    <section class="content-header">
     <h1>Edit Driver</h1>
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
            <i class="fa fa-edit">Driver details</i> 
          </h2>
         
        </div>
        <!-- /.col -->
      </div>
    <form  method="POST" action="{{route('driver.update.p',$driver->id)}}">
        {{csrf_field()}}
    <div class="row">
        <div class="col-md-6">
          
          <div class="form-group has-feedback">
            <label class="srequired">Name</label>
            <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{ $driver->name}}"> 
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          @if ($errors->has('name'))
            <span class="help-block">
            <strong class="error-text">{{ $errors->first('name') }}</strong>
            </span>
          @endif

        <div class="form-group has-feedback">
          <label class="srequired">Address.</label>
          <input type="text" class="form-control {{ $errors->has('address') ? ' has-error' : '' }}" placeholder="Address" name="address" value="{{ $driver->address}}">
          <span class="glyphicon glyphicon-phone form-control-feedback"></span>
        </div>
        @if ($errors->has('address'))
          <span class="help-block">
          <strong class="error-text">{{ $errors->first('address') }}</strong>
          </span>
        @endif
        
        <div class="form-group has-feedback">
          <label class="srequired">Mobile No.</label>
          <input type="text" class="form-control {{ $errors->has('mobile') ? ' has-error' : '' }}" placeholder="Mobile" name="mobile" value="{{ $driver->mobile}}">
          <span class="glyphicon glyphicon-phone form-control-feedback"></span>
        </div>
        @if ($errors->has('mobile'))
          <span class="help-block">
          <strong class="error-text">{{ $errors->first('mobile') }}</strong>
          </span>
        @endif
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