@extends('layouts.eclipse')
@section('title')
Stock Report
@endsection
@section('content')
<div class="page-wrapper_new">
  <div class="page-breadcrumb">
    <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
        <b> Stock Report</b>
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
                            <label> From Date</label>
                            <input type="text" class="datepicker form-control" id="fromDate" name="fromDate" onkeydown="return false">
                          </div>
                          </div>
                          <div class="col-lg-3 col-md-3"> 
                          <div class="form-group">                    
                            <label> To Date</label>
                            <input type="text" class="datepicker form-control" id="toDate" name="toDate" onkeydown="return false">
                          </div>
                          </div>
                          <div class="col-lg-3 col-md-3 pt-4">
                           <div class="form-group">          
                            <button type="button" class="btn btn-sm btn-info btn2 srch" onclick="checkDate()" > <i class="fa fa-search"></i> </button>
                            </div>
                          </div>
                          
                        </div>
                      </div>
                      </div>                 
                    <table class="table table-hover table-bordered  table-striped datatable" style="width:100%;text-align: center;" id="dataTable">
                        <thead>
                            <tr>
                             <th>SL.No</th>
                              <th>IMEI</th>
                              <th>Serial No</th>
                              <th>E-sim Number</th>
                              <th>ICCID</th>
                              <th>IMSI</th>
                              <th>Manufacturing Date</th>
                              <th> Created by</th>
                              <!-- <th>Created on</th>        -->
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
    <script src="{{asset('js/gps/stock-report.js')}}"></script>
@endsection
@endsection

