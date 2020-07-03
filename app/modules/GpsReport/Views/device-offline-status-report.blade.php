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

                                                 <!-- filter section -->
                                                 <div class="row ">
                                                    <!-- search -->
                                                    <div class="col-lg-5 ">
                                                        <input type="hidden" name="device_type" id="device_type" value="{{$device_type}}">
                                                        <input type="hidden" name="offline_duration" id="offline_duration" value="{{$offline_duration}}">
                                                        <input type="text" class="form-controller" id="search" name="search"value="{{$search_key}}"  placeholder="IMEI or Serial number"></input>
                                                    </div>
                                                    <!-- /search -->
                                                    <!-- download button -->
                                                    <div class="col-lg-7  download_btn download-button-visibility">
                                                        <button class="btn btn download_button_view"><i class='fa fa-download'></i>
                                                            <a href="device-offline-report-downloads?type=pdf&device_type={{$device_type}}&offline_duration={{$offline_duration}}&search=" class="offline_device_download" style="color:white">Download Report</a>
                                                        </button>
                                                    </div>
                                                    <!-- /download button -->
                                                </div>
                                                <!-- /filter section -->
                                               
                                                        
                                            </form>
                                        @endif
                                        <div class="row col-md-6 col-md-offset-2">
                                            <table class="table table-bordered">
                                                <thead class="thead-color">
                                                    <tr>
                                                        <th>SL.NO</th>
                                                        <th class='imei_column'>IMEI</th>
                                                        <th class='serial_no_column'>Serial Number</th>
                                                        <th>End User Name</th>
                                                        <th class='vehicle_name_column'>Vehicle Name</th>
                                                        <th>Registration Number</th>
                                                        <th class='device_time_column'>Last Packet Received On</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="data_tbody" class = 'table_alignment'>
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
                                                        <td><?php ( isset($each_data->gpsStock->client->name) ) ? $client_name = $each_data->gpsStock->client->name : $client_name='-NA-' ?>{{$client_name}}</td>
                                                        <td><?php ( isset($each_data->vehicleGps->vehicle->name) ) ? $vehicle_name = $each_data->vehicleGps->vehicle->name : $vehicle_name='-NA-' ?>{{$vehicle_name}}</td>
                                                        <td><?php ( isset($each_data->vehicleGps->vehicle->register_number) ) ? $register_number = $each_data->vehicleGps->vehicle->register_number : $register_number='-NA-' ?>{{$register_number}}</td>
                                                        <td><?php ( isset($each_data->device_time) ) ? $device_time = $each_data->device_time : $device_time='-Not Yet Activated-' ?>{{$device_time}}</td>
                                                        <td><a href="{{route('device-detailed-report-view', Crypt::encrypt($each_data->imei))}}" class='btn btn-xs btn-success' data-toggle='tooltip' title='View More Details'><i class='fa fa-eye'></i> View</a></td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <span id="pagination_links">
                                            {{ $offline_devices->appends(Request::all())->links() }}
                                        </span>
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
    .download_btn{
        padding: 0px 0px 0px 514px;
    }
    .table_alignment
    {
        word-break: break-all;
    }
    .imei_column
    {
        width:170px;
    }
    .serial_no_column
    {
        width:210px;
    }
    .vehicle_name_column
    {
        width:150px;
    }
    .device_time_column
    {
        width:166px;
    }
    .download_button_view
    {
        padding: .25rem .5rem;
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

    <script type="text/javascript">
        $('#search').on('keyup',function(){
            $value=$(this).val();
            $device_type=$('#device_type').val();
            $offline_duration=$('#offline_duration').val();
            if($offline_duration==null)
            {
                $offline_duration="";
            }
            $.ajax({
                type : 'get',
                url : '{{URL::to('device-offline-search')}}',
                data:{
                    'search':$value,
                    'device_type':$device_type,
                    'offline_duration':$offline_duration
                },
                success:function(data){
                    console.log(data);
                    $("#data_tbody").empty();
                    $("#pagination_links").empty();               
                    var device_details; 
                    if(data.links.data.length>0)  
                    {                                 
                        for(var i=0;i < data.links.data.length;i++){
                        var client_name;
                        var vehicle_name;
                        var register_number;
                        var device_time;
                        var imei;  
                        var serial_no; 
                        var encryptedimei; 
                        (data.links.data[i].eimei) ? encryptedimei = data.links.data[i].eimei : encryptedimei = "-NA-";                              
                        (data.links.data[i].imei) ? imei = data.links.data[i].imei : imei = "-NA-";          
                        (data.links.data[i].serial_no) ? serial_no = data.links.data[i].serial_no : serial_no = "-NA-";
                        (data.links.data[i].gps_stock) ? client_name = data.links.data[i].gps_stock.client.name : client_name = "-NA-";
                        (data.links.data[i].vehicle_gps) ? vehicle_name = data.links.data[i].vehicle_gps.vehicle.name : vehicle_name = "-NA-";
                        (data.links.data[i].vehicle_gps) ? register_number = data.links.data[i].vehicle_gps.vehicle.register_number : register_number = "-NA-";
                        (data.links.data[i].device_time) ? device_time = data.links.data[i].device_time : device_time = "-NA-";               
                        var j=i+1;
                            device_details += '<tr><td>'+j+'</td>'+
                            '<td>'+imei+'</td>'+
                            '<td>'+serial_no+'</td>'+
                            '<td>'+client_name+'</td>'+
                            '<td>'+vehicle_name+'</td>'+
                            '<td>'+register_number+'</td>'+
                            '<td>'+device_time+'</td>'+
                            // '<td><a href="device-detailed-report/<?php //echo Crypt::encrypt()?>/view" class="btn btn-xs btn-success" data-toggle="tooltip" title="View More Details"><i class="fa fa-eye"></i> View</a></td>'+
                            '<td><button onclick="imeiEncryption('+imei+')" class="btn btn-xs btn-success" data-toggle="tooltip" title="View More Details">view</button></td>'+
                            
                            '</tr>';
                            $('.download-button-visibility').show();

                        }
                    }
                    else{
                        device_details = '<tr>'+
                            '<td colspan="8" style="text-align: center;"><b>No Data Available</b></td>'+
                                                        '</tr>';
                    $('.download-button-visibility').hide();

                                                        
                    }
                    $("tbody").append(device_details);
                    $("a.offline_device_download").attr('href', function(i,a){
                        $('a.offline_device_download').attr("href", "device-offline-report-downloads?type=pdf&device_type="+$device_type+"&offline_duration="+$offline_duration+"&search=" + $value);
                    });
                }
            });
        })
        
    </script>
    <script type="text/javascript">
        $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
    </script>
    <script>
     function imeiEncryption(value){
       $.ajax({
            type:'post',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data:{
                imei : value
            },           
            url: 'device-detail-encription',
            success: function (res) 
            {  
                window.location.href = "/device-detailed-report/"+res+"/view";
            }
          });
    }
    </script>
@endsection
@endsection

