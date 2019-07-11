@extends('layouts.eclipse')
@section('title')
  Performance Score History
@endsection
@section('content')       
        <div class="page-wrapper_new">           
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <h4 class="page-title"> Performance Score History</h4>
                      
                    </div>
                </div>
            </div>
           
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
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
                            <label>Driver</label>                          
                            <select class="form-control selectpicker" data-live-search="true" title="Select Driver" id="driver" name="driver">
                              <option value="">select</option>
                             @foreach ($drivers as $driver)
                              <option value="{{$driver->id}}">{{$driver->name}}</option>
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
                            <button style="margin-top: 19px;" class="btn btn-sm btn-info btn2 form-control" onclick="check()"><i class="fa fa-search"></i> </button>
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
                                 <th>Driver Name</th>
                                 <th>Gps</th>
                                 <th>Alert</th>
                                 <th>Points</th>                                
                                <th>DateTime</th>
                               <!--  <th>Action</th> -->
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
      <script src="{{asset('js/gps/driver-performance-score.js')}}"></script>
  @endsection
