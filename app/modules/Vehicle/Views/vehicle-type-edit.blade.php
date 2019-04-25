@extends('layouts.etm') 
@section('title')
   Update vehicle type details
@endsection
@section('content')

    <section class="content-header">
     <h1>Edit vehicle type</h1>
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
            <i class="fa fa-edit"> vehicle type details</i> 
          </h2>
        </div>
        <!-- /.col -->
      </div>
    <form  method="POST" action="{{route('vehicle-type.update.p',$vehicle_type->id)}}">
        {{csrf_field()}}
    <div class="row">
        <div class="col-md-6">
          <div class="form-group has-feedback">
            <label class="srequired">Name</label>
            <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{ $vehicle_type->name}}"> 
            <span class="glyphicon glyphicon-phone form-control-feedback"></span>
          </div>
          @if ($errors->has('name'))
            <span class="help-block">
            <strong class="error-text">{{ $errors->first('name') }}</strong>
            </span>
          @endif

          <div class="form-group has-feedback">
            <label class="srequired">Type Code</label>
            <input type="text" class="form-control {{ $errors->has('code') ? ' has-error' : '' }}" placeholder="Type Code" name="code" value="{{ $vehicle_type->code}}"> 
            <span class="glyphicon glyphicon-list-alt form-control-feedback"></span>
          </div>
          @if ($errors->has('code'))
            <span class="help-block">
            <strong class="error-text">{{ $errors->first('code') }}</strong>
            </span>
          @endif

          
        </div>
    </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-md-3 ">
          <button type="submit" class="btn btn-primary btn-md form-btn">Update</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
</section>

<form action="{{route('vehicle.concession.add')}}" method="post">
  @csrf
<section class="hilite-content">
  <div class="row">
    <div class="col-xs-3">
      <h2 class="page-header">
        <i class="fa fa-plus"> Add Concessions</i> 
      </h2>
      <div class="form-group">
        <input type="hidden" name="vehicle_type_id" value="{{$vehicle_type->id}}">
        <label>Concession Type</label>
          <select class="form-control" name="ticket_concession_id" required>
          @foreach($concessions as $concession)
            <option value="{{$concession->id}}">{{$concession->name}}</option>
          @endforeach
          </select>
      </div>
      <div class="form-group">
        <button class="btn btn-block btn-success">Add</button>
      </div>
    </div>
  </div>
</section>
</form>

<section class="hilite-content">
  <h2>Applicable concession types</h2>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Concession</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @foreach($vehicle_type->ticketConcessions as $concession)
      <tr>
        <td>{{$concession->name}}</td>
        <td>
          <form action="{{route('concession.vehicle.remove')}}" method="post">
            @csrf
            <input type="hidden" value="{{$concession->pivot->id}}" name="pivot">
            <button class="btn btn-xs btn-danger">Remove</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</section>

<div class="clearfix"></div>

@endsection