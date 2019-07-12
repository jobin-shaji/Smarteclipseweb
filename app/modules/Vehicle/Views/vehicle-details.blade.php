@extends('layouts.eclipse') 
@section('title')
   Vehicle details
@endsection
@section('content')

<div class="page-wrapper-new">
     <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Vehicle Details</li>
          </ol>
        </nav>
   
    <div class="container-fluid">
    <div class="card-body">
      <div class="card-body wizard-content">
        <div class="table-responsive">
            <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
              <div class="row">
                <div class="col-sm-12">
                <section class="hilite-content">
                <!-- title row -->
             
            <div class="card">
              <div class="card-body">
                   <div class="row">
                  <div class="col-xs-12">
                    <h2 class="page-header">
                      <i class="fa fa-bus"></i> 
                    </h2>
                  </div>
                  <!-- /.col -->
                </div>
        <div class="row">
          <div class="col-md-6">
              <div class="form-group has-feedback">
                <label class="srequired">Name</label>
                <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{$vehicle->name}}" disabled> 
                <span class="glyphicon glyphicon-text-size form-control-feedback"></span>
              </div>

              <div class="form-group has-feedback">
                <label class="srequired">Register Number</label>
                <input type="text" class="form-control {{ $errors->has('register_number') ? ' has-error' : '' }}" placeholder="Register Number" name="register_number" value="{{$vehicle->register_number}}" disabled> 
                <span class="glyphicon glyphicon-text-size form-control-feedback"></span>
              </div>

              <div class="form-group has-feedback">
                <label class="srequired">E-SIM Number</label>
                <input type="text" class="form-control {{ $errors->has('e_sim_number') ? ' has-error' : '' }}" placeholder="E-SIM Number" name="e_sim_number" value="{{$vehicle->e_sim_number}}" disabled> 
                <span class="glyphicon glyphicon-text-size form-control-feedback"></span>
              </div>
            </div>
          </div>
         
          <div class="row">
            <div class="col-md-6">
                <div class="form-group has-feedback">
                  <label class="srequired">Vehicle Type</label>
                  <input type="text" class="form-control" value="{{$vehicle->vehicleType->name}}" disabled> 
                  <span class="glyphicon glyphicon-plus form-control-feedback"></span>
                </div>

                <div class="form-group has-feedback">
                  <label class="srequired">GPS</label>
                  <input type="text" class="form-control" value="{{$vehicle->gps->name}} || {{$vehicle->gps->imei}}" disabled> 
                  <span class="glyphicon glyphicon-home form-control-feedback"></span>
                </div>

            </div>
          </div>
        </div></div>
    
                  </section>
                </div>                
              </div>
          </div>
        </div>
      </div>
      </div>
    </div>
  </div>
<div class="clearfix"></div>


   @endsection