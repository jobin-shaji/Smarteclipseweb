@extends('layouts.eclipse')
@section('title')
   Alert Report
@endsection
@section('content')
<div class="page-wrapper_new">
  <div class="page-breadcrumb">
    <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
        <h4 class="page-title">  Alert Report</h4>
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
                        <div class="cover_div_search">
                        <div class="row">
                          <div class="col-lg-3 col-md-3">
                            <div class="form-group">    
                            <label>Vehicle</label>                        
                            <select class="form-control selectpicker" data-live-search="true" title="Select Vehicle" id="vehicle" name="vehicle">
                              <option value="0">All</option>
                              @foreach ($vehicles as $vehicles)
                              <option value="{{$vehicles->id}}">{{$vehicles->register_number}}</option>
                              @endforeach  
                            </select>
                          </div>
                        </div>
                          <div class="col-lg-3 col-md-3"> 
                          <div class="form-group">                    
                            <label> from Date</label>
                            <input type="text" class="datepicker form-control" data-fromdate="{{$from_date}}" id="alert_fromDate" name="fromDate">
                          </div>
                        </div>
                          <div class="col-lg-3 col-md-3"> 
                          <div class="form-group">                    
                            <label> to date</label>
                            <input type="text" class="datepicker form-control" id="alert_toDate" name="toDate">
                          </div>
                          </div>


                           <div class="col-lg-3 col-md-3 pt-4">

                           <div class="form-group">          
                            <button class="btn btn-sm btn-info btn2 form-control" onclick="check()"> <i class="fa fa-search"></i> </button>
                            <button class="btn btn-sm btn1 btn-primary form-control" onclick="downloadAlertReport()">
                              <i class="fa fa-file"></i>Download Excel</button>                        </div>
                          </div>                         
                        </div>
                      </div>
                      </div>

                  <div class="row" style="margin-bottom: 13px;">
                    <div class="col-md-3">
                      <label>Select Alert Type:</label>
                      <select class="form-control selectpicker" data-live-search="true" title="Select Alert Type" id="alert" name="alert">
                      <option value="0">All</option>
                        @foreach ($Alerts as $Alerts)
                        <option value="{{$Alerts->id}}">{{$Alerts->description}}</option>
                      @endforeach
                    </select>
                    </div>
                  </div>
                  
                    <table class="table table-hover table-bordered  table-striped datatable" style="width:100%" id="dataTable">
                        <thead>
                            <tr>
                              <th>Sl.No</th>
                              <th>Vehicle</th>
                              <th>Alert Type</th>
                             
                              <th>DateTime</th>
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
          <div class="row">           
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@section('script')
    <script src="{{asset('js/gps/alert-report-list.js')}}"></script>
@endsection
@endsection

