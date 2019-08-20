@extends('layouts.eclipse')
@section('title')
  All Alerts
@endsection
@section('content')       
        <div class="page-wrapper_new"> 
         <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Data Usage </li>
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
                            <label> GPS</label>
                            <select class="form-control selectpicker" name="gps_id" data-live-search="true" id ="gps_id" title="Select GPS" required>
                           <option selected disabled>Select GPS</option>
                           @foreach($devices as $gps)
                           <option value="{{$gps->id}}">{{$gps->name}}||{{$gps->imei}}</option>
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
                               
                                <th>IMEI</th>
                                <th>Manufacturing Date</th>
                                <th>Date</th>
                                <th>Data Usage</th>
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
    <script src="{{asset('js/gps/data-usage-list.js')}}"></script>
@endsection
