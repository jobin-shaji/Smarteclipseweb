@extends('layouts.eclipse')
@section('title')
  All Geofence
@endsection
@section('content')

<div class="page-wrapper_new">
   <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Assign Geofence  List</li>
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
    <div class="card-body"><h4>Assign Geofence List</h4>
      <div class="table-responsive">
        <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">                     
          <div class="row">
            <div class="col-sm-12">
              <div class="panel-heading">
                        <div class="cover_div_search">
                        <div class="row">
                          <div class="col-lg-2 col-md-3"> 
                           <div class="form-group">
                            <label>Vehicle</label>                          
                            <select class="form-control select2" data-live-search="true" title="Select Vehicle" id="vehicle" name="vehicle">
                              <option value="">Select Vehicle</option>
                              @foreach ($vehicles as $vehicles)
                              <option value="{{$vehicles->id}}">{{$vehicles->register_number}}</option>
                              @endforeach  
                            </select>
                          </div>
                          </div>
                          <div class="col-lg-2 col-md-3"> 
                           <div class="form-group">                      
                            <label>Geofence</label>                          
                            <select class="form-control select2" data-live-search="true" title="Select Geofence" id="vehicle_geofence" name="vehicle_geofence">
                              <option value="">Select Geofence</option>
                              @foreach ($geofences as $geofence)
                              <option value="{{$geofence->id}}">{{$geofence->name}}</option>
                              @endforeach  
                            </select>
                          </div>
                          </div>
                          <div class="col-lg-2 col-md-3"> 
                           <div class="form-group">                      
                            <label>Alert Type</label>                          
                            <select class="form-control select2" data-live-search="true" title="Select Alert Type" id="alert_type" name="alert_type">
                              <option value="">Select Alert Type</option>
                              <option value="1">Entry</option> 
                              <option value="2">Exit</option> 
                            </select>
                          </div>
                          </div>
                          <!-- <div class="col-lg-2 col-md-3"> 
                            <div class="form-group">                    
                              <label> from Date</label>
                              <input type="text" class="date_expiry form-control" id="assignfromDate" name="fromDate">
                            </div>
                          </div>
                          <div class="col-lg-2 col-md-3"> 
                            <div class="form-group">                    
                              <label> to date</label>
                              <input type="text" class="datepicker form-control" id="assignToDate" name="toDate">
                            </div>
                          </div> -->
                           <div class="col-lg-3 col-md-3 pt-4">
                           <div class="form-group">          
                            <button style="margin-top: 19px;" class="btn btn-sm btn-info btn4 form-control" onclick="selectGeofence()">Geofence Schedule </button>
                            </div>
                          </div>
                        </div>
                      </div>
                      </div>
              <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                <thead>
                  <tr>
                      <th>Sl.No</th>
                      <th>Geofence Name</th>
                      <th>Vehicle</th>
                      <th>Register Number</th>
                      <th>Alert Type</th>
                      <!-- <th>From Date</th>
                      <th>To date</th> -->
                      <th>Action</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>               
  </div>
 </div>


@endsection

  @section('script')
    <script src="{{asset('js/gps/assign-geofence-vehicle-list.js')}}"></script>
  @endsection