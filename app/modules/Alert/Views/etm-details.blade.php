@extends('layouts.etm') 
@section('title')
   ETM details
@endsection
@section('content')

    <section class="content-header">
     <h1>ETM details</h1>
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
            <span class="glyphicon glyphicon-phone form-control-feedback"></span>
          </div>

          <div class="form-group has-feedback">
            <label>IMEI</label>
            <input type="text" class="form-control" value="{{ $etm->imei}}" disabled> 
            <span class="glyphicon glyphicon-list-alt form-control-feedback"></span>
          </div>

          <div class="form-group has-feedback">
            <label>Purchase Date</label>
            <input type="text" class="form-control" value="{{ $etm->purchase_date}}" disabled> 
            <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
          </div>

          <div class="form-group has-feedback">
            <label>Version</label>
            <input type="text" class="form-control" value="{{ $etm->version}}" disabled> 
            <span class="glyphicon glyphicon-book form-control-feedback"></span>
          </div>

          <div class="form-group has-feedback">
            <label>Depot</label>
            <input type="text" class="form-control" value="{{ $etm->depot->name}}" disabled> 
            <span class="glyphicon glyphicon-book form-control-feedback"></span>
          </div>
          
        </div>
   </div>
<!--  -->
    </form>
</section>

<div class="clearfix"></div>

@endsection