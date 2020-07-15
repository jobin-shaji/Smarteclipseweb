@extends('layouts.eclipse')
@section('title')
Trip report subscription vehicle list
@endsection
@section('content')
<div class="page-wrapper_new">
   <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
         <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Trip report subscription vehicles list</li>
         <b><i class="fa fa-car" aria-hidden="true"></i> Trip report subscription vehicles list</b>
      </ol>
      @if(Session::has('message'))
      <div class="pad margin no-print alert_hide " id="successMessage">
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
               <div class="panel panel-default">
                  <div class="subscription_cover">
                     <div class="row">
                        <div class="col-lg-4">
                           <span class="icon"><i class="fa fa fa-paperclip"></i></span>
                           <span class="item">Subscription Id</span>
                           <span class="item_value">: {{$subscription->subscription_id}}</span>
                        </div>
                        <div class="col-lg-4">
                           <span class="icon"><i class="fa fa fa-car"></i></span>
                           <span class="item">Subscription vehicles</span>
                           <span class="item_value">: {{$subscription->number_of_vehicles}}</span>
                        </div>
                        <div class="col-lg-4">
                           <span class="icon"><i class="fa fa-book"></i></span>
                           <span class="item">Maximum available reports</span>
                           <span class="item_value">: {{$subscription->number_of_reports_generated ? $subscription->number_of_reports_generated : 0 }}</span>
                        </div>
                     </div>
                     <div class="row" style="margin-top: 16px;">
                        <div class="col-lg-4">
                           <span class="icon"><i class="fa fa-th"></i></span>
                           <span class="item">Free Vehicles</span>
                           <span class="item_value">: 
                       
                             {{$free_vehicle}}
                        
                           </span>
                        </div>
                        <div class="col-lg-4">
                           <span class="icon"><i class="fa fa fa-calendar"></i></span>
                           <span class="item"> Start Date</span>
                           <span class="item_value">: {{$subscription->start_date}}</span>
                        </div>
                        <div class="col-lg-4">
                           <span class="icon"><i class="fa fa fa-calendar"></i></span>
                           <span class="item"> End Date</span>
                           <span class="item_value">: {{$subscription->end_date}}</span>
                        </div>
                     </div>

                     <div class="row" style="margin-top: 16px;">
                        
                        <div class="col-lg-4">
                           <span class="icon"><i class="fa fa fa-car"></i></span>
                           <span class="item">Subscribed vehicles</span>
                           <span class="item_value">: {{$vehicle_count}}</span>
                        </div>
                        <div class="col-lg-4">
                           <span class="icon"><i class="fa fa fa-calendar"></i></span>
                           <span class="item"> Available vehicle subscriptions</span>
                           <span class="item_value">: {{ $subscription->number_of_vehicles + $free_vehicle - $vehicle_count}}</span>
                        </div>
                       
                     </div>

                  </div>
                  <div class="row" style=" margin-top:40px;padding: 0 10px;">
                     <div class="col-md-6">
                        <div class="panel panel-primary">
                           <div class="panel-heading">
                           @if($vehicle_count < $subscription->number_of_vehicles + $free_vehicle )
                              <span class="pull-right">
                              <button type="button" class="btn btn-primary" onclick="addVehicleSubscription()"><i class="fa fa-plus"></i>Attach a vehicle</button>
                              </span>
                              <div class="pull-right">
                                 <span class="clickable filter" data-toggle="tooltip" title="Toggle table filter" data-container="body">
                                 <i class="glyphicon glyphicon-filter"></i>
                                 </span>
                              </div>
                              @endif
                           </div>
                           <div class="panel-body">
                              <input type="text" class="form-control" id="dev-table-filter" data-action="filter" data-filters="#dev-table" placeholder="Filter Developers" />
                           </div>
                           <table class="table table-hover table-bordered" id="dev-table">
                              <thead>
                                 <tr>
                                    <th>#</th>
                                    <th>Vehicle Name</th>
                                    <th>Register Number</th>
                                    <th>Attached on</th>
                                    <th>Expire on</th>
                                    <th>Detached on</th>
                                    <th>Report last generated on</th>
                                    <th>Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                              @foreach ($subscription_list as $item)
                                 @if($item->vehicles)
                                 <tr @if($item->deleted_at != null) style="background: #ecd8da;" @endif>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$item->vehicles ? $item->vehicles->name : "NA"}}</td>
                                    <td>{{$item->vehicles ? $item->vehicles->register_number : "NA"}}</td>
                                    <td>{{$item->attached_on ? $item->attached_on : "NA"}}</td>
                                    <td>{{$item->expired_on ? $item->expired_on : "NA"}}</td>
                                    <td>{{$item->detached_on ? $item->detached_on : "NA"}}</td>
                                    <td>{{$item->report_last_generated_on ? $item->report_last_generated_on : "NA"}}</td>
                                    <td> 
                                    
                                     @if($item->deleted_at == null)
                                     <a href="{{url('/trip-report-vehicle-delete',Crypt::encrypt($item->id))}}" onclick="return confirm('Are you sure you want to detatch this vehicle?');"><button style="border-radius: 4px;height: 41px;padding: 9px;width: 100%;" class="btn btn-sm btn-info btn2" ><i class="fa fa-trash" aria-hidden="true"></i>   Detatch</button></a>                                       
                                     @else
                                       <span style="padding: 10px; border: solid 1px;border-radius: 5px;" >Detached</span>
                                     @endif
                                    
                                    </td>
                                 </tr>
                                 @endif
                              @endforeach  
                              </tbody>
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
<!-- modal for create configuration -->
<div class="modal fade" id="vehicle_registration" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <form  method="POST"  action="{{route('vehicle.subscriptions.create.p',$subscription->id)}}">
      {{csrf_field()}}    
      <div class="modal-dialog" role="document">
         <div class="modal-content ">
            <div class="modal-header text-center">
               <h4 class="modal-title w-100 font-weight-bold">Add Vehicle to subscription list</h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body mx-3">
  
   <div class="form-group">
        <div  class="row">
                <div class="col-md-6">  
                        <label  data-success="right" >Vehicle list</label> 
                </div>
                <div class="col-md-6 select2-new div_margin_top">
                            <select required class="form-control select2"  name="vehicle_id"  title="Select vehicle" id='client_id'>
                            <option value="" selected >Select vehicle</option>
                            @foreach ($vehicles as $vehicle)
                                <option value="{{$vehicle->id}}">{{$vehicle->name}}</option>
                            @endforeach
                            </select>
                </div>
        </div>
   </div>
   <button type="submit" class="btn btn-default">Add to subscription list</button>
 
   </div>
   <div class="modal-footer d-flex justify-content-center">
   </div>
   </div>
   </div>
   </form>
</div>
<!--/ modal for create configuration -->
<style>
   span.item {
   font-size: 17px;
   font-weight: 600;
   }
   .page-wrapper_new {
   min-height: 100%;
   background: #fff;
   }
   .breadcrumb {
   display: -webkit-box;
   display: -ms-flexbox;
   display: flex;
   -ms-flex-wrap: wrap;
   flex-wrap: wrap;
   padding: 0.75rem 1rem;
   margin-bottom: 1.5rem;
   width: 100.7%;
   list-style: none;
   background-color: #f8f9fa;
   border-radius: 2px;
   }
   .subscription_cover {
   width: 100%;
   border: 1px solid;
   padding: 25px;
   border-radius: 5px;
   }
   .clickable{
   cursor: pointer;   
   }
   .panel-heading div {
   margin-top: -18px;
   font-size: 15px;
   }
   .panel-heading div span{
   margin-left:5px;
   }
   .panel-body{
   display: none;
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
