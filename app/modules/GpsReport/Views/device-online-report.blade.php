@extends('layouts.eclipse')
@section('title')
    Device Transfer Report
@endsection
@section('content')
<?php
$perPage    = 10;
$page       = isset($_GET['page']) ? (int) $_GET['page'] : 1;
?>
<div class="page-wrapper_new">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <b> Device Online Report</b>
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
                                            <form method="get" action="{{route('device-online-report')}}">
                                            {{csrf_field()}}
                                            <div class="panel-heading">
                                                <div class="cover_div_search">
                                                    <div class="row">
                                                    <div class="col-lg-4 col-md-4">
                                                            <div class="form-group">
                                                                <label> Device Status</label>
                                                                <select class="form-control select2"  name="device_status" data-live-search="true" title="Select Device Status" id='device_status'  required>
                                                                    <option value="0" @if($device_status==0) selected="selected" @endif>ALL</option>
                                                                    <option value="1"  @if($device_status==1) selected="selected" @endif>TAGGED</option>
                                                                    <option value="2"  @if($device_status==2) selected="selected" @endif>UNTAGGED</option>
                                                                </select>
                                                                @if ($errors->has('device_status'))
                                                                    <span class="help-block">
                                                                        <strong class="error-text">{{ $errors->first('device_status') }}</strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4">
                                                            <div class="form-group">
                                                                <label> Vehicle Status</label>
                                                                <select class="form-control select2"  name="vehicle_status" data-live-search="true" title="Select Vehicle Status" id='vehicle_status'  required>
                                                                    <option disabled selected="selected">Select Status</option>
                                                                    <option value="M"  @if($vehicle_status=='M') selected="selected" @endif>Moving</option>
                                                                    <option value="H"  @if($vehicle_status=='H') selected="selected" @endif>Halt</option>
                                                                    <option value="S"  @if($vehicle_status=='S') selected="selected" @endif>Sleep</option>
                                                                </select>
                                                                @if ($errors->has('vehicle_status'))
                                                                    <span class="help-block">
                                                                        <strong class="error-text">{{ $errors->first('vehicle_status') }}</strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-3 pt-4">
                                                            <label> &nbsp;</label>
                                                            <div class="form-group">
                                                                <button type="submit" class="btn btn-sm btn-info btn2 srch search-btn " > <i class="fa fa-search"></i> </button>
                                                                <a  href="device-online-report" class="btn btn-primary">Clear</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                            </form> 
                                        </div>                            
                                        @if(count($device_online_report) != 0)
                                        <button class="btn btn-xs" style='margin-left: 1000px;'><i class='fa fa-download'></i>
                                            <a href="device-online-report-downloads?type=pdf&device_status={{$device_status}}&vehicle_status={{$vehicle_status}}" style="color:white">Download Report</a>
                                            </button>
                                            <div class="row col-md-6 col-md-offset-2">
                                        <span class="report_summary_title"><b>Report Summary</b></span>
                                            <table class="table table-bordered">
                                                <thead class="thead-color">
                                                    <tr>
                                                        <th>SL.NO</th>
                                                        <th>IMEI</th>
                                                        <th>Serial Number</th>
                                                        <th>End User Name</th>
                                                        <th>Vehicle Name</th>
                                                        <th>Registration Number</th>
                                                        <th>Vehicle Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>                                              
                                                @foreach($device_online_report as $each_data)                                               
                                                    <tr>
                                                        <td>{{ (($perPage * ($page - 1)) + $loop->iteration) }}</td>
                                                        <td><?php ( isset($each_data->imei) ) ? $imei = $each_data->imei : $imei='-NA-' ?>{{$imei}}</td>
                                                        <td><?php ( isset($each_data->serial_no) ) ? $serial_no = $each_data->serial_no : $serial_no='-NA-' ?>{{$serial_no}}</td>                                                       
                                                        <td><?php ( isset($each_data->vehicleGps->vehicle->client->name) ) ? $client_name = $each_data->vehicleGps->vehicle->client->name : $client_name='-NA-' ?>{{$client_name}}</td>
                                                        <td><?php ( isset($each_data->vehicleGps->vehicle->name) ) ? $vehicle_name = $each_data->vehicleGps->vehicle->name : $vehicle_name='-NA-' ?>{{$vehicle_name}}</td>
                                                        <td><?php ( isset($each_data->vehicleGps->vehicle->register_number) ) ? $register_number = $each_data->vehicleGps->vehicle->register_number : $register_number='-NA-' ?>{{$register_number}}</td>                                                       
                                                        <td><?php ( isset($each_data->mode) ) ? $mode = $each_data->mode : $mode='-NA-' ?>{{$mode}}</td>
                                                        <td><button class="btn btn-sm btn-info " > View</button></td>
                                                    </tr>
                                                   @endforeach
                                                </tbody>
                                            </table>
                                            {{ $device_online_report->appends(Request::all())->links() }}
                                        </div>
                                        @endif
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
    .report_summary_title
    {
        font-size:18px;
        margin-bottom: 15px;
    }
    .search_dates
    {
        margin-left: 153px;
        padding: 15px;
    }
    
</style>

@endsection

