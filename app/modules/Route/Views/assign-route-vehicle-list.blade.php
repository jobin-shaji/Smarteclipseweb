@extends('layouts.eclipse')
@section('title')
  All Routes
@endsection
@section('content')

<div class="page-wrapper_new">
  <div class="page-breadcrumb">
      <div class="row">
          <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">Route List </h4>
            
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
                            <label>Route</label>                          
                            <select class="form-control selectpicker" data-live-search="true" title="Select Route" id="vehicle_route" name="vehicle_route">
                              <option value="">Select</option>
                              @foreach ($routes as $route)
                              <option value="{{$route->id}}">{{$route->name}}</option>
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
                            <button style="margin-top: 19px;" class="btn btn-sm btn-info btn4 form-control" onclick="check()">Route Schedule </button>
                            </div>
                          </div>
                        </div>
                      </div>
                      </div>
              <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                <thead>
                  <tr>
                      <th>#</th>
                      <th>Route Name</th>
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
 </div>


@endsection

  @section('script')
    <script src="{{asset('js/gps/assign-route-vehicle-list.js')}}"></script>
  @endsection