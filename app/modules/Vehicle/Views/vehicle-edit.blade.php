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

<section class="hilite-content">
  <div class="row">
    <div class="col-xs-8">
      <div class="row">
        <div class="col-md-6">
        <h2 class="page-header">
          <i class="fa fa-car"> Vehicle Routes</i> 
        </h2>
        </div>
        <div class="col-md-6">
        <div class="clearfix"></div>
           <a href="#" class='btn btn-xs btn-success pull-right' data-toggle="modal" data-target="#myModal"><i class='glyphicon glyphicon-plus'></i> Add vehicle Route </a>

        </div>
      </div>
         <div class="panel-body">
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

                            <a href="/vehicle-route/{{Crypt::encrypt($vehicle_route->id)}}/view" class='btn btn-xs btn-info'><i class='glyphicon glyphicon-eye-open'></i> View </a>

                            <a href="/vehicle-route/{{Crypt::encrypt($vehicle_route->id)}}/delete" class='btn btn-xs btn-danger'><i class='glyphicon glyphicon-trash'></i> Delete</a>

                          </td>
                      </tr>

                    @endforeach
                  </tbody>
              </table>
           </div> 
    </div>
  </div>
</section>


<!-- add depot user -->
 <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Vehicle Routes</h4>
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

                      <div class="form-group has-feedback">
                        <label class="srequired">From Date</label>
                        <input type="date" class="form-control {{ $errors->has('date_from') ? ' has-error' : '' }}" placeholder="From Date" name="date_from"> 
                      </div>
                      @if ($errors->has('date_from'))
                        <span class="help-block">
                            <strong class="error-text">{{ $errors->first('date_from') }}</strong>
                        </span>
                      @endif

                      <div class="form-group has-feedback">
                        <label class="srequired">To Date</label>
                        <input type="date" class="form-control {{ $errors->has('date_to') ? ' has-error' : '' }}" placeholder="From Date" name="date_to"> 
                      </div>
                      @if ($errors->has('date_to'))
                        <span class="help-block">
                            <strong class="error-text">{{ $errors->first('date_to') }}</strong>
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

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
   </div>
 </div>
   
@section('script')
    <script>
      $('#datetimepicker').datetimepicker({
        format: 'yyyy-mm-dd hh:ii'
      });
    </script>
@endsection
@endsection