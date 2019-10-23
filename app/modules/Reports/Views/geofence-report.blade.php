@extends('layouts.eclipse')
@section('title')
Geofence Report
@endsection
@section('content')
<div class="page-wrapper_new">
  <div class="page-breadcrumb">
    <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
        <h4 class="page-title">  Geofence Report</h4>
      </div>
    </div>
  </div>
  <div class="container-fluid">
    <div class="card-body">
      <div >
        <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 ">

          <div class="row">
            <div class="col-sm-12">
              <div class="col-md-12 col-md-offset-1">
                <div class="panel panel-default">
                  <div >
                    <div class="panel-body">
                      <div class="panel-heading">
                        <div class="cover_div_search">
                        <div class="row">
                          <div class="col-lg-3 col-md-3">
                             <div class="form-group">    
                            <label>Vehicle</label>                      
                            <select class="form-control selectpicker" data-live-search="true" title="Select Vehicle" id="vehicle" name="vehicle">
                              <option value="">Select</option>
                              <option value="0">All</option>
                              @foreach ($vehicles as $vehicles)
                              <option value="{{$vehicles->id}}">{{$vehicles->register_number}}</option>
                              @endforeach  
                            </select>
                          </div>
                           </div>
                          <div class="col-lg-3 col-md-3"> 
                            <div class="form-group">                      
                            <label> From Date</label>
                            <input type="text" class="@if(\Auth::user()->hasRole('fundamental'))datepickerFundamental @elseif(\Auth::user()->hasRole('superior')) datepickerSuperior @elseif(\Auth::user()->hasRole('pro')) datepickerPro @else datepickerFreebies @endif form-control" id="fromDate" name="fromDate" onkeydown="return false">
                          </div>
                        </div>
                          <div class="col-lg-3 col-md-3"> 
                           <div class="form-group">                     
                            <label> To Date</label>
                            <input type="text" class="@if(\Auth::user()->hasRole('fundamental'))datepickerFundamental @elseif(\Auth::user()->hasRole('superior')) datepickerSuperior @elseif(\Auth::user()->hasRole('pro')) datepickerPro @else datepickerFreebies @endif form-control" id="toDate" name="toDate" onkeydown="return false">
                          </div>
                          </div>

                            <div class="col-lg-3 col-md-3 pt-4">  
                           <div class="form-group">          
                            <button class="btn btn-sm btn-info btn2 form-control" onclick="check()"> <i class="fa fa-search"></i> </button>

                            <button class="btn btn-sm btn1 btn-primary form-control" onclick="downloadGeofenceReport()">
                              <i class="fa fa-file"></i>Download Excel</button>                   
                              
                          </div>
                          </div>
                        
                        </div>
                      </div>
                      </div>
                      <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                        <thead>
                          <tr>
                            <th>Sl.No</th>
                            <th>Vehicle Name</th>
                            <th>Register Number</th>
                            <th>Geofence Type</th>
                            <th>Time</th>      
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">           
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</section>
@section('script')
<script src="{{asset('js/gps/geofence-report-list.js')}}"></script>
@endsection
@endsection

