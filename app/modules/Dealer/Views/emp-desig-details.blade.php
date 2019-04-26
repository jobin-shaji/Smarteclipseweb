@extends('layouts.etm') 
@section('title')
   Designation details
@endsection
@section('content')

    <section class="content-header">
     <h1>Designation details</h1>
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
            <label>Designation</label>
            <input type="text" class="form-control {{ $errors->has('designation') ? ' has-error' : '' }}" placeholder="Designation" name="designation" value="{{ $emp_desig->designation}}" disabled> 
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          @if ($errors->has('designation'))
            <span class="help-block">
            <strong class="error-text">{{ $errors->first('designation') }}</strong>
            </span>
          @endif
        </div>
   </div>
<!--  -->
    </form>
</section>

<div class="clearfix"></div>

@endsection