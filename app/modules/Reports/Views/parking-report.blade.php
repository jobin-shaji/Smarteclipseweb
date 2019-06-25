@extends('layouts.eclipse')
@section('title')
Parking Report
@endsection
@section('content')
<div class="page-wrapper">
  <div class="page-breadcrumb">
    <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
        <h4 class="page-title">  parking Report</h4>
      </div>
    </div>
  </div>
  <div class="container-fluid">
    <div class="card-body">
      <div >
        <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
          <div class="row">
            <div class="col-sm-12">
              <div class="col-md-12 col-md-offset-1">
                <div class="panel panel-default">
                  <div >
                    <div class="panel-body">
                      <div class="panel-heading">
                        <div class="row">
                          <div class="col-md-3">                     
                            <select class="form-control selectpicker" data-live-search="true" title="Select Vehicle" id="vehicle" name="vehicle">
                              <option value="0">All</option>
                              @foreach ($vehicles as $vehicles)
                              <option value="{{$vehicles->id}}">{{$vehicles->register_number}}</option>
                              @endforeach  
                            </select>
                          </div>
                          <div class="col-md-3">                     
                            <label> from Date</label>
                            <input type="text" class="datepicker" id="fromDate" name="fromDate">
                          </div>
                          <div class="col-md-3">                     
                            <label> to date</label>
                            <input type="text" class="datepicker" id="toDate" name="toDate">
                          </div>
                          <div class="col-md-3">  
                            <button class="btn btn-xs btn-primary " onclick="downloadIdleReport()">
                              <i class="fa fa-file"></i> Download Excel</button>                   
                              <button class="btn btn-xs btn-info" onclick="check()"> <i class="fa fa-filter"></i> Filter </button>
                          </div>
                        </div>
                      </div>  
                
                    <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                        <thead>
                            <tr>
                              <th>Sl.No</th>
                              <th>Vehicle</th>
                              <th>Register Number</th>                              
                              <th>Parking</th>                              
                              <th>Date&Time</th>        
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
    <script src="{{asset('js/gps/parking-report-list.js')}}"></script>
@endsection
@endsection
