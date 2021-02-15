@extends('layouts.eclipse')
@section('title')
  Generate Trip Report
@endsection
@section('content')

<div class="page-wrapper page-wrapper-root page-wrapper_new">
<div class="page-wrapper-root1">
  <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/General Trip report List</li>
        <b>General Trip Report List</b>
     </ol>  
     <!-- message after sucessfull submit --> 
    <div id="message" style="display: none;">
    <div class="callout callout-success">
    <strong>Success!</strong> Request added Successfully!
    </div>
    </div>
     <!-- message after sucessfull submit-->
    </nav>  
   
  <div class="container-fluid">
    <div class="card-body">
      <div >
        <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 scrollmenu">
          <div class="row">
            <div class="col-sm-12">
              <div class="col-md-12 col-md-offset-1">
                <div class="panel panel-default">
                  <div>
                    <div class="panel-body">
                      <div class="panel-heading">
                        <div class="cover_div_search">
                        <div class="row"> 
                        <div class="col-lg-3 col-md-3"> 
                              <div class="form-group">
                                <label>Vehicle</label>                     
                                <select class="form-control selectpicker" data-live-search="true" title="Select Vehicle" id="vehicle" name="vehicle" onkeydown="return false">
                                  <option value="0">All</option>
                                  @foreach ($vehicles as $vehicles)
                                  <option value="{{$vehicles->id}}">{{$vehicles->name}} || {{$vehicles->register_number}}</option>
                                  @endforeach  
                                </select>
                              </div>
                            </div>                        
                          <div class="col-lg-3 col-md-3"> 
                          <div class="form-group">                    
                              <label> Report From</label>
                            <input type="text" class="datepicker form-control" id="fromDate" name="fromDate" autocomplete="off"  onkeydown="return false">  
                            <span class="input-group-addon" style="z-index: auto;">
                                <span class="calender1"  style=""><i class="fa fa-calendar"></i></span>
                              </span>
                          </div>
                        </div>
                      
                          <div class="col-lg-3 col-md-3"> 
                          <div class="form-group">                    
                            <label> Report Till</label>
                            <input type="text" class="datepicker form-control" id="toDate" name="toDate" autocomplete="off"  onkeydown="return false">
                            <span class="input-group-addon" style="z-index: auto;">
                                <span class="calender1"  style=""><i class="fa fa-calendar"></i></span>
                              </span>
                          </div>
                          </div>
                           <div class="col-lg-3 col-md-3 pt-4">
                           <div class="form-group">          
                            <button class="btn btn-sm btn-info btn2 srch" onclick="check()"> <i class="fa fa-search"></i> </button>
                          <!--   <button class="btn btn-sm btn1 btn-primary form-control" onclick="downloadAlertReport()">
                              <i class="fa fa-file"></i>Download Excel</button> -->
                            </div>
                          </div>                         
                        </div>
                      </div>
                      </div>
                      <button class="btn btn-sm btn-info btn2 add_new" id="vehicleTripReportConfiguration" onclick="addGeneralRequest()"><i class='fa fa-plus'></i>
                       Generate New Trip Report</button>
                       <br>
                    <table class="table table-hover table-bordered  table-striped datatable" style="width:100%;text-align: center" id="dataTable">
                        <thead>
                            <tr>
                            <th>SL.No</th>
                            <th>Date</th>
                            <th>Vehicle Number </th>   
                            <th>Report Type</th>
                            <th>Request Submitted On</th>                      
                            <th>Status</th>
                            <th>Actions</th>
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
</div>
</div>
</div>
</div>
</div>
  <!-- modal for create trip -->
      <div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
         <form  method="POST" class="generalReportForm" id="general-report-request" action="{{route('savereportrequest.client.p')}}">
              {{csrf_field()}}    
              <div class="modal-dialog" role="document">
               <div class="modal-content ">
                <div class="modal-header text-center">
                                             <!-- <h4 class="modal-title w-100 font-weight-bold ">Trip Report Subscription </h4> -->
                 <label  class="modal-title w-100 font-weight-bold ">Add New Trip Report</label> 
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
                 </button>
                 </div>
                  <div class="modal-body mx-3">
                    <div class="form_section">
                       <div  class="row">
                          <div class="col-md-6">  
                           <label  data-success="right" >Select Vehicle</label> 
                           </div>
                          <div class="col-md-6 select2-new div_margin_top">
                            <select class="form-control select2 vehiclelist"  name="vehicle_id" data-live-search="true" title="Select Vehicle" required>
                              <option value="" selected disabled>Select Vehicle</option>
                                @foreach($devices as $vehicle)
                                 <option value="{{$vehicle->id}}">{{$vehicle->register_number}}</option>
                                @endforeach
                                </select>
                                @if ($errors->has('gps_id'))
                                <span class="help-block">
                                  <strong class="error-text">{{ $errors->first('gps_id') }}</strong>
                                </span>
                                @endif
                           </div>
                       </div>
                      <div class="row">
                      <div class="col-md-6">  
                         <label  data-success="right" >Trip Report Date</label> 
                      </div>
                       <div class="col-md-6 select2-new div_margin_top">
                          <input type="text" required class="datepickerFundamental form-control"style="width: 100%"  id="fromDate" name="trip_report_date" onkeydown="return false"   autocomplete="off"  required>
                            <span class="calendertrip"><i class="fa fa-calendar"></i></span>
                              <span class="input-group-addon" style="position: relative; z-index:100;">
                                </span>
                                  </div>
                                   </div>
                                      </div> 
                                        <div class="validation_section">
                                      </div>    
                                    </div>
                                  <div class="modal-footer d-flex justify-content-center">
                                 <button type="submit" id="save_subscription"  class="btn btn-default save_subscription" >Submit</button>
                              </div>
                            </div>
                          </div>        
                        </div>                                            
                <!--/ modal for create trip report -->
                              
   <style>
   .table .thead-color th {
   color: #FDFEFE;
   background-color: #59607b;
   border-color: #59607b;
   } 
   .table tr td
   {
   word-break: break-all;
   }
   .count
   {
   width:30px;ext
   }
   .selected_plan
   {
   font-weight: bold;
   padding: 12px;
   }
   .add_new
   {
   margin-left:83%;
   margin-bottom: 10px;
   }
   .select2-new{
   width:100% !important;
   }
   .select2-new .select2-container{
   width:100% !important;  
   }
   .div_margin_top
   {
   /* margin-left:83%; */
   margin-bottom: 10px;
   }
   .page-wrapper_new {
   min-height: 621px;
   background: #f8f9fa;
   }
   .dataTable a.disable {
    padding: 6px;
    margin: 1px;
    font-size:10px ;
}
   .callout.callout-success {
    color: #fff;
    background: #51A351;
    padding: 15px;
    /* width: 25%; */
    border-radius: 5px;
    margin-bottom: 5px;
}

.modal-content {
   max-width: 100% !important;
}
@media (min-width: 576px){
.modal-dialog.error_message_modal {
    max-width: 90% !important;
    margin: 1.75rem auto;
}
}
.calendertrip {
    position: absolute;
    right: 10px;
    top: 10px;
}
</style>
@section('script')
@role('client')
<script src="{{asset('js/gps/client-ondemand-report-list.js')}}"></script>
@endrole
@endsection
@endsection

