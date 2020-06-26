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
                                                                    <option value = '{{config("eclipse.DEVICE_STATUS.ALL")}}'  @if($device_type==config("eclipse.DEVICE_STATUS.ALL")){{"selected"}} @endif>All</option>
                                                                    <option value = '{{config("eclipse.DEVICE_STATUS.TAGGED")}}' @if($device_type==config("eclipse.DEVICE_STATUS.TAGGED")){{"selected"}} @endif>Tagged Devices</option>
                                                                    <option value = '{{config("eclipse.DEVICE_STATUS.UNTAGGED")}}' @if($device_type==config("eclipse.DEVICE_STATUS.UNTAGGED")){{"selected"}} @endif>Untagged Devices</option>
                                                                    <option value = '{{config("eclipse.DEVICE_STATUS.NOT_YET_ACTIVATED")}}' @if($device_type==config("eclipse.DEVICE_STATUS.NOT_YET_ACTIVATED")){{"selected"}} @endif>Not Yet Activated</option>
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
                                           
                                            <form method="GET" action="{{route('device-offline-report')}}" class="search-top">
                                                {{csrf_field()}}
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-md-6 device_search" style="">
                                                            <input type="hidden" name="device_type" id="device_type" value="{{$device_type}}">
                                                            <input type="hidden" name="offline_duration" id="offline_duration" value="{{$offline_duration}}">
                                                                <input type="text" class="form-control" placeholder="Search Here.." name="search_key" id="search_key" autocomplete='off' value="{{$search_key}}">
                                                            </div>

                                                            <div>
                                                                <button type="submit"  class="btn btn-primary search_data_list" id='search_submit' title='Enter IMEI, Serial Number, Manufacturer Name, Distributor Name, Dealer Name, Sub Dealer Name, End User Name, Service Engineer Name, Returned On'>Search</button>
                                                                <button type="button" class="btn btn-primary search_data_list" onclick="clearSearch()">Clear</button>
                                                                <button class="btn btn-xs" style='margin-bottom: 20px;'><i class='fa fa-download'></i>
                                                                    <a href="device-offline-report-downloads?type=pdf&device_type={{$device_type}}&offline_duration={{$offline_duration}}&search_key={{$search_key}}" style="color:white">Download Report</a>
                                                                </button>
                                                            </div>
                                                             
                                                        </div>
                                                    </div>  
                                                </div>
                                            </form>
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
                                                        <td><a href="{{route('device-detailed-report-view', Crypt::encrypt($each_data->imei))}}" class='btn btn-xs btn-success' data-toggle='tooltip' title='View More Details'><i class='fa fa-eye'></i> View</a></td>
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
    .device_search {
        width: 174px;
        margin-left: 710px;
        margin-bottom: 15px;
    }
</style>

@section('script')
    <script type="text/javascript">
        function clearSearch()
        {
            document.getElementById('search_key').value = '';
            $("#search_submit").click();
        }
    </script>
@endsection
@endsection

