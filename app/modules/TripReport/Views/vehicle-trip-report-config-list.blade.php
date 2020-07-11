@extends('layouts.eclipse')
@section('title')
Trip report subscription list
@endsection
@section('content')
<?php
   $perPage    = 10;
   $page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
   ?>
<div class="page-wrapper_new">
   <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
         <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Trip report subscription list</li>
         <b>Trip report subscription list</b>
      </ol>
      @if(Session::has('message'))
      <div class="pad margin no-print">
         <div style="    padding-left: 22px;padding-right: 9px;">
            <div class="callout {{ Session::get('alert-class') }}" style="margin-bottom: 0!important;">
               {{ Session::get('message') }}  
            </div>
         </div>
      </div>
      @endif  
   </nav>
 
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
                                 <form method="get" action="{{route('vehicle-trip-report-config')}}">
                                    {{csrf_field()}}
                                    <div class="panel-heading">
                                       <div class="cover_div_search">
                                          <div class="row">
                                             <div class="col-lg-3 col-md-3" id = "client_section">
                                                <div class="form-group">
                                                   <label> End User</label>
                                                   <select class="form-control select2"  name="client" data-live-search="true" title="Select End User" id='client'>
                                                      <option selected disabeled>Select End User</option>
                                                      <option value='all'>ALL</option>
                                                      @foreach($client_details as $each_data)
                                                      <option value="{{encrypt($each_data->id)}}" @if($client_id != '' && $client_id==$each_data->id){{"selected"}} @endif >{{$each_data->name}} || Mobile No: {{$each_data->mobile}}</option>  
                                                      @endforeach
                                                   </select>
                                                   @if ($errors->has('client'))
                                                   <span class="help-block">
                                                   <strong class="error-text">{{ $errors->first('client') }}</strong>
                                                   </span>
                                                   @endif
                                                </div>
                                             </div>
                                             <div class="col-lg-3 col-md-3 select2-new" id = "plan_section">
                                                <div class="form-group">
                                                   <label> Plan</label>
                                                   <select class="form-control select2"  name="plan" data-live-search="true" title="Select Plan" id='plan'>
                                                      <option selected disabled>Select EndUser First</option>
                                                   </select>
                                                   @if ($errors->has('plan'))
                                                   <span class="help-block">
                                                   <strong class="error-text">{{ $errors->first('plan') }}</strong>
                                                   </span>
                                                   @endif
                                                </div>
                                             </div>
                                             <div class="col-lg-3 col-md-3 pt-4">
                                                <label> &nbsp;</label>
                                                <div class="form-group">                           
                                                   <button type="submit" class="btn btn-sm btn-info btn2 srch search-btn " > <i class="fa fa-search"></i> </button>
                                                   <a  href="vehicle-trip-report-config" class="btn btn-primary">Clear</a>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </form>
                              </div>
                              <div class="row col-md-6 col-md-offset-2">
                                 <button class="btn btn-sm btn-info btn2 add_new" id="vehicleTripReportConfiguration" onclick="getVehicleTripReportConfiguration()"><i class='fa fa-plus'></i>
                                 Add Subscription
                                 </button>
                                 <?php $plan_names = array_column(config('eclipse.PLANS'), 'NAME', 'ID'); ?>
                                 @if(!is_null($plan_type) && $client_id != 'all')
                                 <span class='selected_plan'> Current Plan Of End User : {{"$plan_names[$plan_type]"}}</span> 
                                 @endif
                                 @if(!is_null($plan_type) && $client_id == 'all')
                                 <span class='selected_plan'> Plan : {{"$plan_names[$plan_type]"}}</span> 
                                 @endif
                                 <!-- <form  method="POST" action="{{route('alert.type.create.p')}}" enctype="multipart/form-data"> -->
                                 <!-- <form  method="POST"> -->
                                 <!-- {{csrf_field()}} -->
                                 <table class="table table-bordered">
                                    <thead class="thead-color">
                                       <tr>
                                          <th>SL.NO</th>
                                          <th>Subscription-Id</th>
                                          <th>Client</th>
                                          <th>Plan</th>
                                          <th>Number of vehicles</th>
                                          <th >Remaining Reports</th>
                                          <th>Start Date</th>
                                          <th>End Date</th>
                                          <th>Action</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       @if(count($vehicle_trip_config_details) == 0)
                                       <tr>
                                          <td colspan='9' style='text-align: center;'><b>No Data Available</b></td>
                                       </tr>
                                       @else                                                    
                                       @foreach($vehicle_trip_config_details as $each_data)
                                       <tr>
                                          <td>{{ (($perPage * ($page - 1)) + $loop->iteration) }}</td>
                                          <td><?php ( isset($each_data->subscription_id) ) ? $subscription_id = $each_data->subscription_id : $subscription_id='-NA-' ?>{{$subscription_id}}</td>
                                          <td><?php ( isset($each_data->client_name) ) ? $client_name = $each_data->client_name : $client_name='-NA-' ?>{{$client_name}}</td>
                                          <td><?php ( isset($each_data->role) ) ? $role = ucfirst(strtolower($plan_names[$each_data->role])) : $role='-NA-' ?>{{$role}}</td>
                                          <?php if(isset($each_data->configuration)){extract(json_decode($each_data->configuration, true));} ?>
                                          <td><?php ( isset($each_data->number_of_vehicles) ) ? $number_of_vehicles = $each_data->number_of_vehicles : $number_of_vehicles='-NA-' ?>{{$number_of_vehicles}}</td>
                                          <td><?php ( isset($each_data->number_of_reports_generated) ) ? $number_of_reports_generated = $each_data->number_of_reports_generated : $number_of_reports_generated='-NA-' ?>{{$number_of_reports_generated}}</td>
                                          <td><?php ( isset($each_data->start_date) ) ? $start_date = $each_data->start_date : $start_date='-NA-' ?>{{$start_date}}</td>
                                          <td><?php ( isset($each_data->end_date) ) ? $end_date = $each_data->end_date : $end_date='-NA-' ?>{{$end_date}}</td>
                                          <td>
                                          <a href="{{url('/trip-report-subscription-vehicles',Crypt::encrypt($each_data->id))}}"><button class="btn btn-sm btn-info btn2" ><i class="fa fa-cog" aria-hidden="true"></i>   Vehicle config</button></a>
                                          <a href="{{url('/trip-report-configuration-delete',Crypt::encrypt($each_data->id))}}"><button class="btn btn-sm btn-info btn2" ><i class="fa fa-trash" aria-hidden="true"></i>   Delete</button></a></td>
                                       </tr>
                                       @endforeach
                                       @endif
                                    </tbody>
                                 </table>
                                 </form>
                                 @if(count($vehicle_trip_config_details) != 0)
                                 {{ $vehicle_trip_config_details->appends(Request::all())->links() }}
                                 @endif
                              </div>
                              <!-- modal for create configuration -->
                              <div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                 <form  method="POST"  action="{{route('trip.report.subscriptions.create.p')}}">
                                    {{csrf_field()}}    
                                    <div class="modal-dialog" role="document">
                                       <div class="modal-content ">
                                          <div class="modal-header text-center">
                                             <h4 class="modal-title w-100 font-weight-bold">Trip Report Subscription </h4>
                                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                             <span aria-hidden="true">&times;</span>
                                             </button>
                                          </div>
                                          <div class="modal-body mx-3">
                                             <div  class="row">
                                                <div class="col-md-6">  
                                                   <label  data-success="right" >Client</label> 
                                                </div>
                                                <div class="col-md-6 select2-new div_margin_top">
                                                   <select required class="form-control select2"  name="client_id"  title="Select End User" id='client_id'>
                                                      <option value="" selected >Select End User</option>
                                                      @foreach($client_details as $each_data)
                                                      <option value="{{encrypt($each_data->id)}}" @if($client_id != '' && $client_id==$each_data->id){{"selected"}} @endif >{{$each_data->name}} || Mobile No: {{$each_data->mobile}}</option>  
                                                      @endforeach
                                                   </select>
                                                  
                                                </div>
                                             </div>
                                             <div class="row">
                                                <div class="col-md-6">  
                                                   <label  data-success="right" >Start date</label> 
                                                </div>
                                                <div class="col-md-6 div_margin_top">
                                                   <input required type="text" class="config_date form-control" id="start_date" Placeholder="Subscription start date" name="start_date" onkeydown="return false" autocomplete="off">
                                                </div>
                                             </div>
                                             <div class="row">
                                                <div class="col-md-6">  
                                                   <label  data-success="right" >End Date</label> 
                                                </div>
                                                <div class="col-md-6 div_margin_top">
                                                   <input required type="text" class=" config_end_date form-control" id="end_date" Placeholder="Subscription end date" name="end_date" onkeydown="return false" autocomplete="off">                                                                    
                                                </div>
                                             </div>
                                             <div class="row">
                                                <div class="col-md-6">  
                                                   <label  data-success="right" >Number of subscription vehicles</label> 
                                                </div>
                                                <div class="col-md-6 select2-new div_margin_top">
                                                   <input required type="number" class="form-control" id="number_of_vehicle" name="number_of_vehicle" Placeholder="Subscription vehicle">                                                                    
                                                  
                                                </div>
                                             </div>
                                          </div>
                                          <div class="modal-footer d-flex justify-content-center">
                                             <button type="submit"  class="btn btn-default" >Submit</button>
                                          </div>
                                       </div>
                                    </div>
                                 </form>
                              </div>
                              <!--/ modal for create configuration -->
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
   margin-left:88%;
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
</style>
@section('script')
<script src="{{asset('js/gps/vehicle-trip-report-config-list.js')}}"></script>
@endsection
@endsection
