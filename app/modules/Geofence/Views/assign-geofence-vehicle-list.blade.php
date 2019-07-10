@extends('layouts.eclipse')
@section('title')
  All Geofence
@endsection
@section('content')

<div class="page-wrapper_new">
  <div class="page-breadcrumb">
      <div class="row">
          <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">Assign Geofence  List </h4>
            
          </div>
      </div>
  </div>
 <div class="container-fluid">
    <div class="card-body">
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
                            <select class="form-control selectpicker" data-live-search="true" title="Select Vehicle" id="vehicle" name="vehicle">
                              <option value="">select</option>
                              @foreach ($vehicles as $vehicles)
                              <option value="{{$vehicles->id}}">{{$vehicles->register_number}}</option>
                              @endforeach  
                            </select>
                          </div>
                          </div>
                          <div class="col-lg-2 col-md-3"> 
                           <div class="form-group">                      
                            <label>Geofence</label>                          
                            <select class="form-control selectpicker" data-live-search="true" title="Select Geofence" id="vehicle_geofence" name="vehicle_geofence">
                              <option value="">Select</option>
                              @foreach ($geofences as $geofence)
                              <option value="{{$geofence->id}}">{{$geofence->name}}</option>
                              @endforeach  
                            </select>
                          </div>
                          </div>
                           <div class="col-lg-2 col-md-3"> 
                          <div class="form-group">                    
                            <label> from Date</label>
                            <input type="text" class="datepicker form-control" id="fromDate" name="fromDate">
                          </div>
                        </div>
                          <div class="col-lg-2 col-md-3"> 
                          <div class="form-group">                    
                            <label> to date</label>
                            <input type="text" class="datepicker form-control" id="toDate" name="toDate">
                          </div>
                          </div>
                           <div class="col-lg-3 col-md-3 pt-4">
                           <div class="form-group">          
                            <button style="margin-top: 19px;" class="btn btn-sm btn-info btn4 form-control" onclick="check()">Geofence Schedule </button>
                            </div>
                          </div>
                        </div>
                      </div>
                      </div>
              <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                <thead>
                  <tr>
                      <th>#</th>
                      <th>Geofence Name</th>
                      <th >Vehicle</th>
                       <th >Register Number</th>
                      <th >From Date</th>
                      <th >To date</th>
                      <th >Action</th>


                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>               
  </div>
   <footer class="footer text-center">
    All Rights Reserved by VST Mobility Solutions. Designed and Developed by <a href="http://vstmobility.com">VST</a>.
  </footer>
 </div>


@endsection

  @section('script')
    <script src="{{asset('js/gps/assign-geofence-vehicle-list.js')}}"></script>
  @endsection