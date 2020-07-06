@extends('layouts.eclipse')
@section('title')
    Plan Based Report
@endsection
@section('content')
<?php
$perPage    = 10;
$page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
?>
<div class="page-wrapper_new">

    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Vehicle Trip Report Configuration List</li>
        <b>Vehicle Trip Report Configuration List</b>
     </ol>
       @if(Session::has('message'))
          <div class="pad margin no-print">
            <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
                {{ Session::get('message') }}  
            </div>
          </div>
        @endif  
    </nav>
    <style>
     /* .select2-container .select2-selection--single .select2-selection__rendered {
        display: block;
        padding-left: 8px;
        padding-right: 20px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: normal; */
    }
    </style>
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
                                                        <div class="col-lg-3 col-md-3" id = "plan_section"> 
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
                                           <button class="btn btn-xs add_new" id="vehicleTripReportConfiguration" onclick="getVehicleTripReportConfiguration()"><i class='fa fa-plus'></i>
                                               Add Vehicle Configuration
                                            </button>
                                            <?php $plan_names = array_column(config('eclipse.PLANS'), 'NAME', 'ID'); ?>
                                            @if(!is_null($plan_type) && $client_id != 'all')
                                            <span class='selected_plan'> Current Plan Of End User : {{"$plan_names[$plan_type]"}}</span> 
                                            @endif
                                            @if(!is_null($plan_type) && $client_id == 'all')
                                            <span class='selected_plan'> Plan : {{"$plan_names[$plan_type]"}}</span> 
                                            @endif
                                            <table class="table table-bordered">
                                                <thead class="thead-color">
                                                    <tr>
                                                        <th>SL.NO</th>
                                                        <th>End User Name</th>
                                                        <th>Vehicle Name</th>
                                                        <th>Vehicle Registration Number</th>
                                                        <th>Plan</th>
                                                        <th class='count'>Remaining Reports Count</th>
                                                        <th>Start Date</th>
                                                        <th>End Date</th>
                                                        <th>Last Generated On</th>
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
                                                        <td><?php ( isset($each_data->client_name) ) ? $client_name = $each_data->client_name : $client_name='-NA-' ?>{{$client_name}}</td>
                                                        <td><?php ( isset($each_data->vehicle_name) ) ? $vehicle_name = $each_data->vehicle_name : $vehicle_name='-NA-' ?>{{$vehicle_name}}</td>
                                                        <td><?php ( isset($each_data->veh_reg_no) ) ? $veh_reg_no = $each_data->veh_reg_no : $veh_reg_no='-NA-' ?>{{$veh_reg_no}}</td>
                                                        <td><?php ( isset($each_data->role) ) ? $role = ucfirst(strtolower($plan_names[$each_data->role])) : $role='-NA-' ?>{{$role}}</td>
                                                        <?php if(isset($each_data->configuration)){extract(json_decode($each_data->configuration, true));} ?>
                                                        <td><?php ( isset($each_data->configuration) ) ? $configuration = $number_of_report_per_month : $configuration='-NA-' ?>{{$configuration}}</td>
                                                        <td><?php ( isset($each_data->start_date) ) ? $start_date = $each_data->start_date : $start_date='-NA-' ?>{{$start_date}}</td>
                                                        <td><?php ( isset($each_data->end_date) ) ? $end_date = $each_data->end_date : $end_date='-NA-' ?>{{$end_date}}</td>
                                                        <td><?php ( isset($each_data->last_generated_on) ) ? $last_generated_on = $each_data->last_generated_on : $last_generated_on='-NA-' ?>{{$last_generated_on}}</td>
                                                    </tr>
                                                    @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                            @if(count($vehicle_trip_config_details) != 0)
                                            {{ $vehicle_trip_config_details->appends(Request::all())->links() }}
                                            @endif
                                        </div>                                    
                                        <div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <!-- <form  method="POST" action="{{route('configuration.create.p')}}"> -->
                                            <form  method="POST" action="{{route('vehicle.trip.report.config.create.p')}}">
                                                {{csrf_field()}}    
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header text-center">
                                                            <h4 class="modal-title w-100 font-weight-bold">Configuration</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body mx-3">   
                                                            <div  class="row"> 
                                                                <div class="col-md-6">  
                                                                <label  data-success="right" >Client</label> 
                                                                </div>
                                                                <div class="col-md-6 select2-new">
                                                              
                                                                <select class="form-control select2"  name="client_id"  title="Select End User" id='client_id'>
                                                                    <option selected >Select End User</option>
                                                                    <option value='all'>ALL</option>
                                                                    @foreach($client_details as $each_data)
                                                                        <option value="{{encrypt($each_data->id)}}" @if($client_id != '' && $client_id==$each_data->id){{"selected"}} @endif >{{$each_data->name}} || Mobile No: {{$each_data->mobile}}</option>  
                                                                    @endforeach
                                                                </select>
                                                                @if ($errors->has('client_id'))
                                                                    <span class="help-block">
                                                                        <strong class="error-text">{{ $errors->first('client_id') }}</strong>
                                                                    </span>
                                                                @endif
                                                                </div>
                                                            </div>
                                                            <div class="row"> 
                                                                <div class="col-md-6">  
                                                                <label  data-success="right" >Vehicle</label> 
                                                                </div>
                                                                <div class="col-md-6 select2-new">
                                                                <select  class="form-control select2"  name="vehicle_id" data-live-search="true" title="Select End User Vehicle" id='vehicle_id' >
                                                                <option selected disabeled>Select End User first</option>
                                                                </select>
                                                                </div>
                                                            </div>
                                                            <div class="row"> 
                                                                <div class="col-md-6">  
                                                                    <label  data-success="right" >Start date</label> 
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <input type="text" class="datepicker form-control" id="startDate" name="startDate" onkeydown="return false" autocomplete="off">
                                                                </div>
                                                            </div>
                                                            <div class="row"> 
                                                                <div class="col-md-6">  
                                                                <label  data-success="right" >End Date</label> 
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <input type="text" class="datepicker form-control" id="toDate" name="toDate" onkeydown="return false" autocomplete="off">                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer d-flex justify-content-center">
                                                            <button class="btn btn-default">Submit</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
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
        margin-left:85%;
        margin-bottom: 10px;
    }
   .select2-new{
       width:100% !important;
   }
   .select2-new .select2-container{
    width:100% !important;  
   }
</style>

@section('script')
    <script src="{{asset('js/gps/vehicle-trip-report-config-list.js')}}"></script>
@endsection
@endsection

