@extends('layouts.eclipse')
@section('title')
Vehicle - Driver Assign
@endsection

@section('content')

<div class="page-wrapper_new">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Vehicle Details</li>
      <b>Vehicle Details</b>
    </ol>
    @if(Session::has('message'))
    <div class="pad margin no-print">
      <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
        {{ Session::get('message') }}
      </div>
    </div>
    @endif
  </nav>
<div class="container-fluid">
    <div class="card-body">
      <div class="table-responsive">
        <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
          <div class="row">
            <div class="col-sm-12">
              <div class="row">
                <div class="col-lg-6 col-md-12">
                  <section class="hilite-content">
                    <div class="row">
                      <div class="col-xs-8">
                        <div class="row">
                          <div class="col-md-6">
                            <h3 class="page-header">
                              <i class="fa fa-car"> Vehicle Details</i>
                            </h3>
                          </div>
                          <form method="POST" action="{{route('reg.update.p',$vehicle->id)}}">
                          {{csrf_field()}}
                            <div class="panel-body">
                              <div class="form-group has-feedback">
                                <label class="srequired">Name</label>
                                <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Name" name="name" value="{{$vehicle->name}}" disabled>
                                <span class="glyphicon glyphicon-text-size form-control-feedback"></span>
                              </div>
                              <?php
                              $status=$vehicle->is_registernumber_updated;
                              if($status == 0)
                              {
                              ?>
                              <div class="form-group has-feedback">
                                <label class="srequired">Registration Number</label>
                                <input type="text" class="form-control {{ $errors->has('register_number') ? ' has-error' : '' }}" placeholder="Registration Number" name="register_number" value="{{$vehicle->register_number}}">
                                <span class="glyphicon glyphicon-text-size form-control-feedback"></span>
                              </div>
                              <?php
                              }
                              else
                              {
                              ?>
                              <div class="form-group has-feedback">
                                <label class="srequired">Registration Number</label>
                                <input type="text" class="form-control {{ $errors->has('register_number') ? ' has-error' : '' }}" placeholder="Registration Number" name="register_number" value="{{$vehicle->register_number}}" disabled>
                                <span class="glyphicon glyphicon-text-size form-control-feedback"></span>
                              </div>
                              <?php
                              }
                              ?>
                              <div class="form-group has-feedback">
                                <label class="srequired">Vehicle Type</label>
                                <input type="text" class="form-control" value="{{$vehicle->vehicleType->name}}" disabled>
                                <span class="glyphicon glyphicon-plus form-control-feedback"></span>
                              </div>

                              <div class="form-group has-feedback">
                                <label class="srequired">GPS Serial Number</label>
                                <input type="text" class="form-control" value="{{$vehicle->gps->serial_no}}" disabled>
                                <span class="glyphicon glyphicon-home form-control-feedback"></span>
                              </div>

                              <?php
                              $status=$vehicle->is_registernumber_updated;
                              if($status == 0)
                              {
                              ?>
                              <div class="form-group has-feedback">
                                <button type="submit" class="btn btn-primary btn-md form-btn ">Save</button>
                              </div>
                              <?php
                              }
                              else
                              {
                              ?>

                              <?php
                              }
                              ?>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </section>
                </div>
                <div class="col-lg-6 col-md-12">
                  <section class="hilite-content">
                    <!-- title row -->
                    <div class="row">
                      <div class="col-lg-9 col-md-9 col-xs-12">
                        <h3 class="page-header">
                          <i class="fa fa-user"> Change Driver</i>
                        </h3>
                        <?php
                        $encript = Crypt::encrypt($vehicle->gps->id)
                        ?>
                      </div>
                      <div class="col-lg-3 col-md-3 col-xs-12">
                        <a href="/driver/create" class='btn btn-xs btn' data-toggle='tooltip'><i class='fa fa-plus'></i> <b>Create Driver</b></i></a>
                      </div>
                    </div>

                    <form method="POST" action="{{route('vehicles.assignDrivers.p',$vehicle->id)}}">
                      {{csrf_field()}}
                      <div class="row">
                        <div class="col-lg-12 col-md-12">
                          <div class="form-group has-feedback">
                            <label class="srequired">Driver</label>
                            <select class="form-control {{ $errors->has('driver_id') ? ' has-error' : '' }}" name="driver_id" value="{{ old('driver_id') }}" required>
                              <option value="" disabled="disabled" selected="selected">Select Driver</option>
                              @foreach($drivers as $driver)
                             
                              <option value="{{$driver->id}}" @if($driver->id==$vehicle->driver_id){{"selected"}} @endif >{{$driver->name}}</option>
                              @endforeach
                            </select>
                          </div>
                          @if ($errors->has('driver_id'))
                          <span class="help-block">
                            <strong class="error-text">{{ $errors->first('driver_id') }}</strong>
                          </span>
                          @endif
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-10 col-md-12">
                          <button type="submit" class="btn btn-primary btn-md form-btn ">Update</button>
                        </div>
                      </div>
                    </form>
                  </section>
                 

                 
                    
                  
              </div>
            </div>
          </div>
          <hr>
          <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
            <div class="row">
              <div class="col-sm-12">
                <div class="row">
                  <div class="col-lg-6 col-md-12">
                    
                  </div>
                  </div>
              </div>
            </div>
          </div>
         </div>
      </div>
    </div>
</div>
</div>

<link rel="stylesheet" href="{{asset('css/loader-1.css')}}">
<style>
  .loader-wrapper-4 {
    width: 100%;
    float: left;
  }

  .load-style {
    left: 20%;
    position: absolute;
    top: 100px !important;
    width: 60px !important;
    height: 60px !important;
  }
</style>
@section('script')
<script src="{{asset('js/gps/vehicle-doc-dependent-dropdown.js')}}"></script>
@endsection


<div class="clearfix"></div>


@endsection