@extends('layouts.etm') 
@section('title')
   Employment Type Details
@endsection
@section('content')

    <section class="content-header">
     <h1>Employment Type Details</h1>
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
            <i class="fa fa-user"></i> 
          </h2>
        </div>
        <!-- /.col -->
      </div>
    <form  method="POST" action="#">
        {{csrf_field()}}
    <div class="row">
        <div class="col-md-6">

          <div class="form-group has-feedback">
            <label>Employment Type</label>
            <input type="text" class="form-control {{ $errors->has('type') ? ' has-error' : '' }}" placeholder="Employment Type" name="type" value="{{ $emp_type->type}}" disabled> 
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          @if ($errors->has('type'))
            <span class="help-block">
            <strong class="error-text">{{ $errors->first('type') }}</strong>
            </span>
          @endif
        </div>
   </div>
<!--  -->
    </form>
</section>

<div class="clearfix"></div>

@endsection