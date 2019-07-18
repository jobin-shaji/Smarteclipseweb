@extends('layouts.eclipse') 
@section('title')
   Device Details
@endsection
@section('content')

<div class="page-wrapper page-wrapper_new">

  <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Device Details</li>
         @if(Session::has('message'))
        <div class="pad margin no-print">
          <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
              {{ Session::get('message') }}  
          </div>
        </div>
        @endif 
      </ol>
    </nav>
    
    <div class="container-fluid">
    <div class="card-body">
        <div class="table-responsive">
            <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
              <div class="row">
                <div class="col-sm-12">
                <section class="hilite-content">
                <!-- title row -->
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
                <label>Name</label>
                <input type="text" class="form-control" value="{{ $gps->name}}" disabled>
              </div>

              <div class="form-group has-feedback">
                <label>IMEI</label>
                <input type="text" class="form-control" value="{{ $gps->imei}}" disabled> 
              </div>

              <div class="form-group has-feedback">
                <label>Manufacturing Date</label>
                <input type="text" class="form-control" value="{{ $gps->manufacturing_date}}" disabled> 
              </div>
              <div class="form-group has-feedback">
                <label class="srequired">E-SIM Number</label>
                <input type="text" class="form-control" name="e_sim_number" value="{{$gps->e_sim_number}}" disabled> 
              </div>
            </div>
          </div>
         
          <div class="row">
            <div class="col-md-6">
                <div class="form-group has-feedback">
                <label>Brand</label>
                <input type="text" class="form-control" value="{{ $gps->brand}}" disabled> 
              </div>

              <div class="form-group has-feedback">
                <label>Model Name</label>
                <input type="text" class="form-control" value="{{ $gps->model_name}}" disabled> 
              </div>

              <div class="form-group has-feedback">
                <label>Version</label>
                <input type="text" class="form-control" value="{{ $gps->version}}" disabled>
              </div>

            </div>
          </div>
        
    
                  </section>
                </div>                
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<div class="clearfix"></div>


   @endsection