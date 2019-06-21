@extends('layouts.gps') 
@section('title')
   Ota Type Details
@endsection
@section('content')

    <section class="content-header">
     <h1>Ota Type Details</h1>
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
    <form  method="POST" action="#">
        {{csrf_field()}}
    <div class="row">
        <div class="col-md-6">
           
          <div class="form-group has-feedback">
            <label>Name</label>
            <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{ $ota_type->name}}" disabled>
          </div>
          <div class="form-group has-feedback">
            <label>Code</label>
            <input type="text" class="form-control {{ $errors->has('code') ? ' has-error' : '' }}" placeholder="Code" name="code" value="{{ $ota_type->code}}" disabled>
          </div>
          <div class="form-group has-feedback">
            <label>Default</label>
            <input type="text" class="form-control {{ $errors->has('default_value') ? ' has-error' : '' }}"  name="default_value" value="{{ $ota_type->default_value}}" disabled>
          </div>
          
        </div>
       
      </div>
<!--  -->
    </form>
</section>

<div class="clearfix"></div>

@endsection