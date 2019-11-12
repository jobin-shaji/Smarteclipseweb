@extends('layouts.eclipse')
@section('title')
Halt Report
@endsection
@section('content')
<div class="page-wrapper_new">
  <div class="page-breadcrumb">
    <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
        <h4 class="page-title">  Halt Report</h4>
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
                              <option value="" selected="selected" disabled="disabled">select</option>
                              @foreach ($vehicles as $vehicles)
                              <option value="{{$vehicles->id}}">{{$vehicles->register_number}}</option>
                              @endforeach  
                            </select>
                          </div>
                          </div>
                          <div class="col-md-3"> 
                          <div class="form-group">                    
                            <label> From Date</label>
                            <input type="text" class="datetimepicker form-control" id="fromDate" name="fromDate" required>
                          </div>
                          </div>
                          <div class="col-md-3">
                          <div class="form-group">                     
                            <label> To Date</label>
                            <input type="text" class="datetimepicker form-control" id="toDate" name="toDate" required>
                          </div>
                          </div>

                             <div class="col-lg-3 col-md-3 pt-4">
                           <div class="form-group">          
                            <button class="btn btn-sm btn-info btn2 srch" onclick="trackMode()"> <i class="fa fa-search"></i> </button>
                            <!-- <button class="btn btn-sm btn1 btn-primary form-control" onclick="downloadIdleReport()">
                              <i class="fa fa-file"></i>Download Excel</button>   -->                      
                            </div>
                          </div>                         
                        </div>
                      </div>
                      </div>                  
                      <table class="table table-hover table-bordered  table-striped datatable" style="width:100%">
                        <thead>
                            <tr>
                              <th>Sl.No</th>
                              <th>Vehicle</th>
                              <th>Register Number</th>                         
                              <th>Halt</th>                                                               
                            </tr>
                        </thead>
                         <tbody>
                            <tr>
                              <td id="sl"></td>
                              <td id="vehicle_name"></td>                              
                              <td id="register_number"></td>     
                              <td id="halt"></td>     
                            </tr>
                        </tbody>
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
    <script src="{{asset('js/gps/idle-report-list.js')}}"></script>
@endsection
@endsection
