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
    <div class="device-heading">
 
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
                                                                    <option value='{{config("eclipse.DEVICE_STATUS.ALL")}}' @if($device_status==config("eclipse.DEVICE_STATUS.ALL")){{"selected"}} @endif>ALL</option>
                                                                    <option value='{{config("eclipse.DEVICE_STATUS.TAGGED")}}' @if($device_status==config("eclipse.DEVICE_STATUS.TAGGED")){{"selected"}} @endif>TAGGED</option>
                                                                    <option value='{{config("eclipse.DEVICE_STATUS.UNTAGGED")}}' @if($device_status==config("eclipse.DEVICE_STATUS.UNTAGGED")){{"selected"}} @endif>UNTAGGED</option>
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
                                                                    <option value='{{config("eclipse.VEHICLE_STATUS.MOVING")}}'  @if($vehicle_status==config("eclipse.VEHICLE_STATUS.MOVING")){{"selected"}} @endif>Moving</option>
                                                                    <option value='{{config("eclipse.VEHICLE_STATUS.HALT")}}'  @if($vehicle_status==config("eclipse.VEHICLE_STATUS.HALT")){{"selected"}} @endif>Halt</option>
                                                                    <option value='{{config("eclipse.VEHICLE_STATUS.SLEEP")}}'  @if($vehicle_status==config("eclipse.VEHICLE_STATUS.SLEEP")){{"selected"}} @endif>Sleep</option>
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
                                            <form method="GET" action="{{route('device-online-report')}}" class="search-top">
                                                {{csrf_field()}}
                                                <!-- filter section -->
                                                <div class="row ">
                                                    <!-- search -->
                                                    <div class="col-lg-5 ">
                                                        <input type="hidden" name="device_status" id="device_status" value="{{$device_status}}">
                                                        <input type="hidden" name="vehicle_status" id="vehicle_status" value="{{$vehicle_status}}">                                                           
                                                        <input type="text" class="form-controller" id="search" name="search"value="" placeholder="IMEI or Serial number"></input>
                                                    </div>
                                                    <!-- /search -->
                                                    <!-- download button -->
                                                    <div class="col-lg-7  download_btn">
                                                        <button class="btn btn "  ><i class='fa fa-download'></i>
                                                            <a href="device-online-report-downloads?type=pdf&device_status={{$device_status}}&vehicle_status={{$vehicle_status}}&search=" class="online_device_download" style="color:white">Download Report</a>
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
                                                        <th>IMEI</th>
                                                        <th>Serial Number</th>
                                                        <th>End User Name</th>
                                                        <th>Vehicle Name</th>
                                                        <th>Registration Number</th>
                                                        <th>Vehicle Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="data_tbody">
                                                @if(count($device_online_report) == 0)
                                                        <tr>
                                                            <td colspan='8' style='text-align: center;'><b>No Data Available</b></td>
                                                        </tr>
                                                   @else                                            
                                                @foreach($device_online_report as $each_data)                                               
                                                    <tr>
                                                        <td>{{ (($perPage * ($page - 1)) + $loop->iteration) }}</td>
                                                        <td><?php ( isset($each_data->imei) ) ? $imei = $each_data->imei : $imei='-NA-' ?>{{$imei}}</td>
                                                        <td><?php ( isset($each_data->serial_no) ) ? $serial_no = $each_data->serial_no : $serial_no='-NA-' ?>{{$serial_no}}</td>                                                       
                                                        <td><?php ( isset($each_data->vehicleGps->vehicle->client->name) ) ? $client_name = $each_data->vehicleGps->vehicle->client->name : $client_name='-NA-' ?>{{$client_name}}</td>
                                                        <td><?php ( isset($each_data->vehicleGps->vehicle->name) ) ? $vehicle_name = $each_data->vehicleGps->vehicle->name : $vehicle_name='-NA-' ?>{{$vehicle_name}}</td>
                                                        <td><?php ( isset($each_data->vehicleGps->vehicle->register_number) ) ? $register_number = $each_data->vehicleGps->vehicle->register_number : $register_number='-NA-' ?>{{$register_number}}</td>                                                       
                                                        <td><?php ( isset($each_data->mode) ) ? $mode = $each_data->mode : $mode='-NA-' ?>{{$mode}}</td>
                                                        <td><a href="{{route('device-detailed-report-view', Crypt::encrypt($each_data->imei))}}" class='btn btn-xs btn-success' data-toggle='tooltip' title='View More Details'><i class='fa fa-eye'></i> View</a></td>
                                                    </tr>
                                                   @endforeach
                                                   @endif
                                                </tbody>
                                               
                                            </table>
                                            @if(count($device_online_report) != 0)
                                            <span id="pagination_links">
                                            {{ $device_online_report->appends(Request::all())->links() }}
                                            </span>
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
    .device_search {
        width: 174px;
        /* margin-left: 710px; */
        margin-bottom: 15px;
    }
    .device-heading {
    padding: 21px 20px 0 23px;
   }
   .download_btn{
    padding: 0px 0px 0px 514px;
   }
    
</style>

@section('script')
    <script type="text/javascript">
        function clearSearch()
        {
            document.getElementById('search').value = '';
            $("#search_submit").click();
        }
    </script>
    <script type="text/javascript">
    $('#search').on('keyup',function(){
        $value=$(this).val();
        $device_status=$('#device_status').val();
        $vehicle_status=$('#vehicle_status').val();
        if($vehicle_status==null)
        {
            $vehicle_status="";
        }
        $.ajax({
            type : 'get',
            url : '{{URL::to('device-search')}}',
            data:{
                'search':$value,
                'device_status':$device_status,
                'vehicle_status':$vehicle_status
            },
            success:function(data){
               
                $("#data_tbody").empty();
                $("#pagination_links").empty();
                var client_name;
                var device_details;
                for(var i=0;i < data.links.data.length;i++){
                    var client_name;
                    var vehicle_name;
                    var register_number;
                    var mode;
                    var imei;  
                    var serial_no;  
                    // (data.links.data[i].imei) ? imei = data.links.data[i].imei : imei = "-NA-";
                   (data.links.data[i].imei) ? imei = data.links.data[i].imei : imei = "-NA-";          
                   (data.links.data[i].serial_no) ? serial_no = data.links.data[i].serial_no : serial_no = "-NA-";
                   (data.links.data[i].vehicle_gps) ? client_name = data.links.data[i].vehicle_gps.vehicle.client.name : client_name = "-NA-";
                   (data.links.data[i].vehicle_gps) ? vehicle_name = data.links.data[i].vehicle_gps.vehicle.name : vehicle_name = "-NA-";
                   (data.links.data[i].vehicle_gps) ? register_number = data.links.data[i].vehicle_gps.vehicle.register_number : register_number = "-NA-";
                   (data.links.data[i].mode) ? mode = data.links.data[i].mode : mode = "-NA-";
                   var j=i+1;
                    device_details += '<tr><td>'+j+'</td>'+
                    '<td>'+imei+'</td>'+
                    '<td>'+serial_no+'</td>'+
                    '<td>'+client_name+'</td>'+
                    '<td>'+vehicle_name+'</td>'+
                    '<td>'+register_number+'</td>'+
                    '<td>'+mode+'</td>'+
                    '<td><button onclick="imeiEncryption('+imei+')" class="btn btn-xs btn-success" data-toggle="tooltip" title="View More Details">view</button></td>'+
                        '</tr>';
                }
                $("tbody").append(device_details);
                $("a.online_device_download").attr('href', function(i,a){
                    $('a.online_device_download').attr("href", "device-online-report-downloads?type=pdf&device_status="+$device_status+"&vehicle_status="+$vehicle_status+"&search=" + $value);
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

