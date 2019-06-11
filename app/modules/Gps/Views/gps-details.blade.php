@extends('layouts.gps') 
@section('title')
   Device details
@endsection
@section('content')

    <section class="content-header">
     <h1>Device details</h1>
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
            <i class="fa fa-tablet"></i> 
          </h2>
        </div>
        <!-- /.col -->
      </div>
    <form  method="POST" action="#">
        {{csrf_field()}}
    <div class="row">
        <div class="col-md-6">

          <div class="form-group has-feedback">
            <label>Name</label>
            <input type="text" class="form-control" value="{{ $gps->name}}" disabled>
            <span class="glyphicon glyphicon-phone form-control-feedback"></span>
          </div>

          <div class="form-group has-feedback">
            <label>IMEI</label>
            <input type="text" class="form-control" value="{{ $gps->imei}}" disabled> 
            <span class="glyphicon glyphicon-list-alt form-control-feedback"></span>
          </div>

          <div class="form-group has-feedback">
            <label>Manufacturing Date</label>
            <input type="text" class="form-control" value="{{ $gps->manufacturing_date}}" disabled> 
            <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
          </div>

          <div class="form-group has-feedback">
            <label>Version</label>
            <input type="text" class="form-control" value="{{ $gps->version}}" disabled> 
            <span class="glyphicon glyphicon-book form-control-feedback"></span>
          </div>

        </div>
   </div>
<!--  -->
    </form>
</section>

<div class="clearfix"></div>

@endsection