@extends('layouts.eclipse')
@section('title')
Parking Report
@endsection
@section('content')
<div class="page-wrapper_new">
  <div class="page-breadcrumb">
    <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
        <h4 class="page-title">  Parking Report</h4>
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
                              <option value="{{$vehicles->id}}">{{$vehicles->name}} || {{$vehicles->register_number}}</option>
                              @endforeach  
                            </select>
                          </div>
                          </div>
                          <div class="col-lg-3 col-md-3">
                          <div class="form-group">                     
                            <label> From Date</label>
                            <input type="text" class="datetimepicker form-control" id="fromDate" name="fromDate" required>
                          </div>
                          </div>
                          <div class="col-lg-3 col-md-3">
                          <div class="form-group">                     
                            <label> To Date</label>
                            <input type="text" class="datetimepicker form-control" id="toDate" name="toDate" required>
                          </div>
                          </div>
                            <div class="col-lg-3 col-md-3 pt-4">
                           <div class="form-group">          
                            <button class="btn btn-sm btn-info btn2 srch" onclick="trackMode()"> <i class="fa fa-search"></i> </button>
                            </div>
                          </div>
                          
                        </div>
                      </div>
                      </div>  
                
                    <table class="table table-hover table-bordered  table-striped datatable" style="width:100%;text-align: center" >
                        <thead>
                            <tr>
                              <th><b>SL.No</b></th>
                              <th><b>Vehicle</b></th>
                              <th><b>Register Number</b></th>                              
                              <th><b>Parking</b></th>                              
                            </tr>
                        </thead>
                        <tbody>
                          <tr style="text-align: center;">
                            <td id="sl"></td>
                            <td id="vehicle_name"></td>
                            <td id="register_number"></td>
                            <td id="sleep"></td>
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
    <script src="{{asset('js/gps/parking-report-list.js')}}"></script>
@endsection
@endsection
