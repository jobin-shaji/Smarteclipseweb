@extends('layouts.gps') 
@section('title')
   Update vehicle details
@endsection
@section('content')

    <section class="content-header">
     <h1>Edit Vehicle</h1>
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
            <i class="fa fa-user-plus"></i> 
          </h2>
        </div>
        <!-- /.col -->
      </div>
   <form  method="POST" action="{{route('vehicles.update.p',$vehicle->id)}}">
        {{csrf_field()}}
      <div class="row">
          <div class="col-md-6">

              <div class="form-group has-feedback">
                <label class="srequired">E-SIM Number</label>
                <input type="text" class="form-control {{ $errors->has('register_number') ? ' has-error' : '' }}" placeholder="E-SIM Number" name="e_sim_number" value="{{$vehicle->e_sim_number}}" required> 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              @if ($errors->has('e_sim_number'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('e_sim_number') }}</strong>
                </span>
              @endif
            
         
            </div>
        </div>
          <div class="row">
            <!-- /.col -->
            <div class="col-md-3 ">
              <button type="submit" class="btn btn-primary btn-md form-btn ">Save</button>
            </div>
            <!-- /.col -->
          </div>
    </form>
</section>
 
<div class="clearfix"></div>


   @endsection