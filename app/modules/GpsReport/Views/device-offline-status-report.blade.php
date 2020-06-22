@extends('layouts.eclipse')
@section('title')
    Device Offline Status Report
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
                <b> Device Offline Report</b>
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
                                            <form method="get" action="{{route('device-offline-report')}}">
                                            {{csrf_field()}}
                                                <div class="panel-heading">
                                                <div class="cover_div_search">
                                                    <div class="row">
                                                        <div class="col-lg-3 col-md-3"> 
                                                            <div class="form-group">                      
                                                                <label> Device Type</label>
                                                                <select class="form-control select2"  name="device_type" data-live-search="true" title="Select Device Type" id='device_type'  required>
                                                                    <option disabled>Select Device Type</option>
                                                                    <option value = '0'  @if($device_type=='0'){{"selected"}} @endif>All</option>
                                                                    <option value = '1' @if($device_type=='1'){{"selected"}} @endif>Tagged Devices</option>
                                                                    <option value = '2' @if($device_type=='2'){{"selected"}} @endif>Untagged Devices</option>
                                                                    <option value = '3' @if($device_type=='3'){{"selected"}} @endif>Not Yet Activated</option>
                                                                </select>
                                                                @if ($errors->has('device_type'))
                                                                    <span class="help-block">
                                                                        <strong class="error-text">{{ $errors->first('device_type') }}</strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-3"> 
                                                            <div class="form-group">                      
                                                                <label> Offline Duration (In hours)</label>
                                                                <input type = 'number' min='1' max='720' style='width: 255px;' value = "{{$offline_duration}}" name ='offline_duration' id = 'offline_duration'>
                                                                @if ($errors->has('offline_duration'))
                                                                    <span class="help-block">
                                                                        <strong class="error-text">{{ $errors->first('offline_duration') }}</strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-3 pt-4">  
                                                            <div class="form-group">                           
                                                                <button type="submit" class="btn btn-sm btn-info btn2 srch search-btn " > <i class="fa fa-search"></i> </button>
                                                                <a  href="device-offline-report" class="btn btn-primary">Clear</a>
                                                            </div>
                                                        </div>          
                                                    </div>
                                                </div>
                                                </div>
                                            </form> 
                                        </div> 
                                        @if(count($offline_devices) != 0)
                                            <button class="btn btn-xs" style='margin-left: 1000px;margin-bottom: 20px;'><i class='fa fa-download'></i>
                                                <a href="device-offline-report-downloads?type=pdf&device_type={{$device_type}}&offline_duration={{$offline_duration}}" style="color:white">Download Report</a>
                                            </button>
                                        @endif
                                        <div class="row col-md-6 col-md-offset-2">
                                            <table class="table table-bordered">
                                                <thead class="thead-color">
                                                    <tr>
                                                        <th>SL.NO</th>
                                                        <th>IMEI</th>
                                                        <th>Serial Number</th>
                                                        <th>End User Name</th>
                                                        <th>Vehicle Name</th>
                                                        <th>Registration Number</th>
                                                        <th>Last Packet Received On</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(count($offline_devices) == 0)
                                                        <tr>
                                                            <td colspan='8' style='text-align: center;'><b>No Data Available</b></td>
                                                        </tr>
                                                    @endif
                                                    @foreach($offline_devices as $each_data)
                                                    <tr>
                                                        <td>{{ (($perPage * ($page - 1)) + $loop->iteration) }}</td>
                                                        <td><?php ( isset($each_data->imei) ) ? $imei = $each_data->imei : $imei='-NA-' ?>{{$imei}}</td>
                                                        <td><?php ( isset($each_data->serial_no) ) ? $serial_no = $each_data->serial_no : $serial_no='-NA-' ?>{{$serial_no}}</td>
                                                        <td><?php ( isset($each_data->vehicleGps->vehicle->client->name) ) ? $client_name = $each_data->vehicleGps->vehicle->client->name : $client_name='-NA-' ?>{{$client_name}}</td>
                                                        <td><?php ( isset($each_data->vehicleGps->vehicle->name) ) ? $vehicle_name = $each_data->vehicleGps->vehicle->name : $vehicle_name='-NA-' ?>{{$vehicle_name}}</td>
                                                        <td><?php ( isset($each_data->vehicleGps->vehicle->register_number) ) ? $register_number = $each_data->vehicleGps->vehicle->register_number : $register_number='-NA-' ?>{{$register_number}}</td>
                                                        <td><?php ( isset($each_data->device_time) ) ? $device_time = $each_data->device_time : $device_time='-Not Yet Activated-' ?>{{$device_time}}</td>
                                                        <td><a href="{{route('device-offline-report-view', Crypt::encrypt($each_data->id))}}" class='btn btn-xs btn-success' data-toggle='tooltip' title='View More Details'><i class='fa fa-eye'></i> View</a></td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            {{ $offline_devices->appends(Request::all())->links() }}
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
</style>

@section('script')
    <script src="{{asset('js/gps/mdb.js')}}"></script>
    <script src="{{asset('js/gps/plan-based-report-chart.js')}}"></script>
@endsection
@endsection

