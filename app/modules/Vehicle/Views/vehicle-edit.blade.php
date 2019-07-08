@extends('layouts.eclipse') 
@section('title')
   Update vehicle details
@endsection
@section('content')
 <div class="page-wrapper_new">
    <div class="page-breadcrumb">
      <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
        <h4 class="page-title">Edit Vehicle</h4>
        @if(Session::has('message'))
        <div class="pad margin no-print">
            <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
            {{ Session::get('message') }}  
          </div>
        </div>
        @endif  
        </div>
      </div>
    </div>


  <div class="container-fluid">
    <div class="card-body">
      <section class="hilite-content">      
        <div class="row">
          <div class="col-xs-8">
            <h2 class="page-header">
              <i class="fa fa-user-plus"></i> 
            </h2> 
          </div>
        </div>
        <form  method="POST" action="{{route('vehicles.update.p',$vehicle->id)}}">
        {{csrf_field()}}
          <div class="row">
            <div class="col-lg-3 col-md-4">
              <div class="form-group has-feedback">
                <input type="hidden" class="form-control {{ $errors->has('register_number') ? ' has-error' : '' }}" placeholder="E-SIM Number" name="e_sim_number" value="{{$vehicle->e_sim_number}}" required> 
                <span class="glyphicon glyphicon-car form-control-feedback"></span>
              </div>
              @if ($errors->has('e_sim_number'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('e_sim_number') }}</strong>
                </span>
              @endif
            </div>
            <div class="col-lg-3 col-md-4">
              <div class="form-group has-feedback">
                <label class="srequired">Driver</label>
                <select class="form-control {{ $errors->has('driver_id') ? ' has-error' : '' }}"  name="driver_id" value="{{ old('driver_id') }}" required>
                  <option>Select Driver</option>
                  @foreach($drivers as $driver)
                  <option value="{{$driver->id}}" @if($driver->id==$vehicle->driver_id){{"selected"}} @endif>{{$driver->name}}</option>
                  @endforeach
                </select>
              </div>
              @if ($errors->has('driver_id'))
                <span class="help-block">
                    <strong class="error-text">{{ $errors->first('driver_id') }}</strong>
                </span>
              @endif
            </div>
            <div class="col-lg-3 col-md-4">            
              <div class="form-group has-feedback">
                 <button type="submit" class="btn btn-primary btn-md form-btn">Save</button>
              </div>           
            </div>
          </div>
        </form>
      </section> 
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-md-6">
          <i class="fa fa-car"> Vehicle Routes</i> 
        </div>   
        <div class="col-md-6">
          <div class="clearfix"></div> 
          <?php 
            $encript=Crypt::encrypt($vehicle->gps->id)
          ?>
          <a href="{{route('vehicle.ota',$encript)}}">
            <button class="btn btn-xs btn-success pull-right">Edit OTA</button>
          </a>
          <a href="#" class='btn btn-xs btn-success pull-right' data-toggle="modal" data-target="#myModal"><i class='glyphicon glyphicon-plus'></i> Add vehicle Route </a>
          </div>
        </div>
        <div class="table-responsive">
          <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
            <div class="row">
              <div class="col-sm-12">
                <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                  <thead>
                    <tr>
                      <th>Sl.No</th>
                      <th>Route</th>
                      <th>From Date</th>
                      <th>To Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($vehicle->vehicleRoute as $vehicle_route)
                    <tr>
                      <td>{{$loop->iteration}}</td>
                      <td>{{$vehicle_route->route_id}}</td>
                      <td>{{$vehicle_route->date_from}}</td>
                      <td>{{$vehicle_route->date_to}}</td>
                      <td>
                        <a href="/vehicle-route/{{Crypt::encrypt($vehicle_route->id)}}/edit" class='btn btn-xs btn-primary'><i class='glyphicon glyphicon-edit'></i> Edit </a>
                        <a href="/vehicle-route/{{Crypt::encrypt($vehicle_route->route_id)}}/view" class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>
                        <a href="/vehicle-route/{{Crypt::encrypt($vehicle_route->id)}}/delete" class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-trash'></i> Delete</a>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
              </table>
            </div>
          </div>
          <div class="row"></div>
        </div>
      </div>
    </div>
  </div>
  <footer class="footer text-center">
    All Rights Reserved by VST Mobility Solutions. Designed and Developed by <a href="https://wrappixel.com">VST</a>.
  </footer>
</div>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">    
        <div class="row">
          <div class="col-md-12">
            <h4 class="modal-title">Vehicle Routes</h4>
          </div>
        </div>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form  method="POST" action="{{route('vehicle-route.create.p')}}">
          {{csrf_field()}}
          <input type="hidden" name="vehicle_id" value="{{$vehicle->id}}"> 
          <div class="row">
            <div class="col-md-12">
              <div class="form-group has-feedback">
                <label class="srequired">Routes</label>
                <select class="form-control {{ $errors->has('route_id') ? ' has-error' : '' }}" placeholder="Routes" name="route_id" value="{{ old('route_id') }}" required>
                  <option value="" selected disabled>Select Route</option>
                  @foreach($routes as $route)
                  <option value="{{$route->id}}">{{$route->name}}</option>
                   @endforeach
                </select>
              </div>
              @if ($errors->has('route_id'))
              <span class="help-block">
                <strong class="error-text">{{ $errors->first('route_id') }}</strong>
              </span>
              @endif
            </div>
          </div>
        <div class="row">
      <div class="col-md-12">
        <div class="form-group has-feedback">
          <label class="srequired">From Date</label>
          <input type="text" class="form-control datetimepicker {{ $errors->has('date_from') ? ' has-error' : '' }}" placeholder="From Date"  name="date_from"> 
        </div>
        @if ($errors->has('date_from'))
        <span class="help-block">
          <strong class="error-text">{{ $errors->first('date_from') }}</strong>
        </span>
        @endif
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="form-group has-feedback">
          <label class="srequired">To Date</label>
          <input type="text" class="form-control datetimepicker {{ $errors->has('date_to') ? ' has-error' : '' }}" placeholder="TO Date"  name="date_to"> 
        </div>
        @if ($errors->has('date_to'))
        <span class="help-block">
          <strong class="error-text">{{ $errors->first('date_to') }}</strong>
        </span>
        @endif
      </div>
    </div>
    <div class="row">
      <div class="col-md-3 ">
        <button type="submit" class="btn btn-primary btn-md form-btn ">Save</button>
      </div>
    </div>
  </form>
</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
   </div>
 </div>
   
@endsection