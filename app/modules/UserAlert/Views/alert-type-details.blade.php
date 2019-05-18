@extends('layouts.gps') 
@section('title')
   Alert Type details
@endsection
@section('content')
    <section class="content-header">
     <h1>Alert Type details</h1>
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
        @foreach($alert_type as $alert_type)
          <div class="form-group has-feedback">
            <label>Code</label>
            <input type="text" class="form-control {{ $errors->has('code') ? ' has-error' : '' }}" placeholder="Code" name="code" value="{{ $alert_type->code}}" disabled>
          </div>
          <div class="form-group has-feedback">
            <label>Description</label>
            <input type="text" class="form-control {{ $errors->has('description') ? ' has-error' : '' }}" placeholder="description" name="description" value="{{ $alert_type->description}}" disabled>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
           
      @endforeach
        </div>
       
      </div>
<!--  -->
    </form>
</section>
<div class="clearfix"></div>
@endsection