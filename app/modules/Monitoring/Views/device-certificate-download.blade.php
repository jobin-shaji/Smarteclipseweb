<html>
<head><meta http-equiv=Content-Type content="text/html; charset=UTF-8">

<style type="text/css">
span.cls_002{font-family:Times,serif;font-size:15px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
div.cls_002{font-family:Times,serif;font-size:15px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
span.cls_003{font-family:Times,serif;font-size:21.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
div.cls_003{font-family:Times,serif;font-size:21.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
span.cls_004{font-family:Times,serif;font-size:30.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
div.cls_004{font-family:Times,serif;font-size:30.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
span.cls_005{font-family:Times,serif;font-size:15px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
div.cls_005{font-family:Times,serif;font-size:11.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
span.cls_006{font-family:Times,serif;font-size:15px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
div.cls_006{font-family:Times,serif;font-size:12px!important;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
span.cls_007{font-family:Times,serif;font-size:10px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
div.cls_007{font-family:Times,serif;font-size:7.0px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
.lineheight {
line-height: 20px;
margin-top: 1%!important;
}
body{
margin: :0px;
padding: :0px;
}
-->
.border{
width: 570px;
float: left;
display: block;
border: 1px solid #000;
padding:30px 0 50px;
}
.clear{clear:both;
}
.same-width{width:100%;
float:left;
padding-bottom:10px;
}
.top-bg-left{
width:70%;
float:left;
}
.top-bg-right{
width:30%;
float:left;
}

.logo{
width:100%;float:left;display:block;
}.logo img{
width:150px;
float:right;}
.marg-auto{
width:540px;margin:30px auto;
}
.top-text{
width:100%;float:left;display:block; margin-top:10px;
font-size:16px;
}
.top-text-left{
width:50%;float:left;
}.top-text-right{
width:50%;float:left;
margin-left: -1px;
}

.top-text span.cls_006 {
font-size: 12px;
}
.mrg-left-5{margin-left:5px;
}

.mrg-top-70{margin-top:60px;
}.mrg-top-50{margin-top:50px;
}
.officeal-txt{
width: 200px;
float: right;
margin-top: 50px;}
.top-text-left-1 {
width: 100%;
float: left;
}
.mrg-30{
margin-top:30px;
}

.inner-bg-left{
width:510px;
margin:0px auto;
}
.inner-border{
margin: 0;
border: 1px solid #000;
border-bottom: 0px solid #000;
}.boderder-bottom{
border-bottom:1px solid #000;
}
.inner-left{
width: 42%;
float: left;
border-right: 1px solid #000;
padding: 10px 0;
padding-left: 5px;
min-height: 30px;

}
.inner-right{
width:53%;
float:left;
min-height: 30px;
border-right: 1px solid #000;
padding:10px 0;
padding-left: 5px;
}
.yellow{
background:#f5bb14;
}
.border-0{
border:0px;
}
.gray{
background:#bebdbc;
}
.br-bt{
border-bottom:1px solid #000;}
.mrg-40
{margin-top:40px;
}
.yellow{background: #f5bb14;}
.grey{background: #bebdbc;}
.cls_002{font-family:Times,serif;font-size:15px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
td{
vertical-align: text-top;
}
</style>

<script type="text/javascript" src="wz_jsgraphics.js"></script>
<script>
    round = function(val, precision) {
        if (precision == null)
        {
            precision = 0;
        }
        if (!precision) 
        {
            return Math.round(val);
        }
        val *= Math.pow(10, precision);
        val += 0.5;
        val = Math.floor(val);
        return val /= Math.pow(10, precision);
    };
</script>

</head>
<body>
<div>
    <div style="position:absolute;left:520px;top:40px" class="cls_003">
        <img src="assets/images/smart_eclipse_logo.png" alt="Logo" height="30px" width="150px">
    </div>
     <div style="position:absolute;left:53px;top:90px;" >
        <span class="cls_002">Date:{{date('d-m-Y')}}</span>
    </div>
<p style="text-align: center;font-size: 20px;font-weight: 900px;color: black;margin-bottom: 50px!important;margin-top:50px">
<b> Report</b>
</p></div>
@if(in_array(1, $report_type))
<p style="margin-left: 53px"><b>Vehicle Details</b></p>
<?php
if($monitoringReport)
{
?>
<table border="1" cellspacing="0" cellpadding="2px" style="margin-left: 53px;width: 100%">
    <?php
    if( $monitoringReport->theft_mode==0){
        $theft_mode='Disabled';
    }
    else{
        $theft_mode='Enabled';
    }
    if( $monitoringReport->towing==0){
        $towing='Not Towing';
    }
    else{
        $towing='Towing';
    }
    if( $monitoringReport->emergency_status==0){
        $emergency_status='Off';
    }
    else{
        $emergency_status='On';
    }
    ?>

    <tr>
        <th style="width: 30%">Vehicle Name</th>
        <td>{{ $monitoringReport->name }}</td>
    </tr>
    <tr>
        <th style="width: 30%">Registration Number</th>
        <td>{{ $monitoringReport->register_number}}</td>
    </tr>
    <tr>
        <th style="width: 30%">Vehicle Type</th>
        <td>{{ $monitoringReport->vehicleType->name}}</td>
    </tr>
    <tr>
        <th style="width: 30%">Vehicle Model </th>
        <td>{{ $monitoringReport->vehicleModels->name}}</td>
    </tr>
    <tr>
        <th style="width: 30%">Vehicle Make</th>
        <td>{{ $monitoringReport->vehicleModels->vehicleMake->name}}</td>
    </tr>
    <tr> 
        <th style="width: 30%">Engine Number</th>
        <td>{{ $monitoringReport->engine_number}}</td>
    </tr>
    <tr>  
        <th style="width: 30%">Chassis Number</th>
        <td>{{ $monitoringReport->chassis_number}}</td>
    </tr>
    <tr> 
        <th style="width: 30%">Theft Mode </th>
        <td>{{ $theft_mode}}</td> 
    </tr>
    <tr> 
        <th style="width: 30%">Towing </th>
        <td>{{ $towing}}</td> 
    </tr>
    <tr>
        <th style="width: 30%">Emergency Status  </th>
        <td>{{ $emergency_status}}</td> 
    </tr>
    <tr> 
        <th style="width: 30%">Created At </th>
        <td>{{ $monitoringReport->created_at}}</td> 
    </tr>
</table>
<?php 
}
else
{
?>
    <div style="text-align:center">No Vehicle details found.</div>
<?php } ?>
@endif
@if(in_array(2, $report_type))
<p style="margin-left: 53px"><b>Owner Details</b></p>
<?php
if($monitoringReport->client)
{
?>
    <table border="1" cellspacing="0" cellpadding="2px" style="margin-left: 53px;width: 100%">
        <?php
    $role=$monitoringReport->client->user->role;
    if($role==0)
    { 
        $user_role="Freebies";
    }else if($role==1){
        $user_role="Fundamental";
    }else if($role==2){
        $user_role="Superior";
    }else if($role==3){
        $user_role="Pro";
    }
    else{
        $user_role="No data Available";
    }
    if($monitoringReport->client->subdealer){
        $dealer_trader=$monitoringReport->client->subdealer->name;
    }
    else if($monitoringReport->client->trader){
        $dealer_trader=$monitoringReport->client->trader->name;
    }
    else{
        $dealer_trader="Not Assigned";
    }                
    ?>
    <tr>
            <th style="width: 30%">Owner Name </th>
            <td>@if($monitoringReport->client->name){{ $monitoringReport->client->name }}@else{{'No data available'}} @endif</td> 
        </tr>
        <tr>
            <th>Owner Address</th>
            <td>@if($monitoringReport->client->address){{ $monitoringReport->client->address}}@else{{'No data available'}} @endif</td>
        </tr>
        <tr>
            <th>Owner Mobile</th>
            <td>@if($monitoringReport->client->user->mobile){{ $monitoringReport->client->user->mobile}}@else{{'No data available'}} @endif</td> 
        </tr>
        <tr>
            <th>Owner Email</th>
            <td>@if($monitoringReport->client->user->email){{ $monitoringReport->client->user->email}}@else{{'No data available'}} @endif</td>                  
        </tr>
        <tr>
            <th>Owner Latitude </th> 
            <td>@if($monitoringReport->client->latitude){{ $monitoringReport->client->latitude}}@else{{'No data available'}} @endif</td>                  
        </tr> 
        <tr>
            <th>Owner Longitude</th>
            <td>@if($monitoringReport->client->longitude){{ $monitoringReport->client->longitude}}@else{{'No data available'}} @endif</td>
        </tr>
        <tr> 
            <th>Owner Country</th>
            <td>@if($monitoringReport->client->country){{ $monitoringReport->client->country->name}}@else{{'No data available'}} @endif</td>
        </tr>
        <tr> 
            <th>Owner State</th>
            <td>@if($monitoringReport->client->state){{ $monitoringReport->client->state->name}}@else{{'No data available'}} @endif</td>
        </tr> 
        <tr>
            <th>Owner City </th> 
            <td>@if($monitoringReport->client->city){{ $monitoringReport->client->city->name}}@else{{'No data available'}} @endif</td>
        </tr>
        <tr>
            <th>Dealer </th>
            <td>@if($dealer_trader){{ $dealer_trader}}@else{{'No data available'}} @endif</td> 
        </tr> 
        <tr>
            <th>Owner Package </th>
            <td>@if($user_role){{ $user_role}}@else{{'No data available'}} @endif</td>  
        </tr>
    </table>
<?php 
}
else
{
?>
    <div style="text-align:center">No Owner details found.</div>
<?php } ?>
@endif
@if(in_array(3, $report_type))
<p style="margin-left: 53px"><b>Driver Details</b></p>
<?php
if($monitoringReport->driver)
{
?>
    <table border="1" cellspacing="0" cellpadding="2px" style="margin-left: 53px;width: 100%">
        <?php
            if($monitoringReport->driver->points<=0){
                $points=0;
            }
            else{
                $points=$monitoringReport->driver->points;
            }
        ?>
        <tr>
            <th style="width: 30%">Driver Name </th>
            <td>@if($monitoringReport->driver->name){{ $monitoringReport->driver->name }}@else{{'No data available'}} @endif</td>
        </tr>
        <tr>
            <th>Driver Address</th>
            <td>@if($monitoringReport->driver->address){{ $monitoringReport->driver->address}}@else{{'No data available'}} @endif</td>
        </tr>
        <tr>
            <th>Driver Mobile</th>
            <td>@if($monitoringReport->driver->mobile){{ $monitoringReport->driver->mobile}}@else{{'No data available'}} @endif</td>
        </tr>
        <tr>
            <th>Driver Points</th>
            <td>@if($points){{ $points}} @else {{'No data available'}} @endif</td>
        </tr>
    </table>
<?php 
}
else
{
?>
    <div style="text-align:center">No Driver details found.</div>
<?php } ?>
@endif
@if(in_array(4, $report_type))
<p style="margin-left: 53px"><b>Device Details</b></p>
<?php
if($monitoringReport->gps)
{
?>
<table border="1" cellspacing="0" cellpadding="2px" style="margin-left: 53px;width: 100%">
    <?php
        if($monitoringReport->gps->emergency_status ==0){
            $emergency_status="Off";
        }
        else{
            $emergency_status="On";
        }
        if($monitoringReport->gps->gps_fix_on ==0){
            $gps_fix="Not Received";
        }
        else{
            $gps_fix="Received";
        }
        if($monitoringReport->gps->calibrated_on){
            $calibrated_on=$monitoringReport->gps->calibrated_on;
        }
        else{
            $calibrated_on="No Data available";
        }
        if($monitoringReport->gps->login_on){
            $login_on=$monitoringReport->gps->login_on;
        }
        else{
            $login_on="No Data available";
        }
        if($monitoringReport->gps->no_of_satellites){
            $no_of_satellites=$monitoringReport->gps->no_of_satellites;
        }
        else{
            $no_of_satellites="No Data available";
        }
        if($monitoringReport->gps->e_sim_number){
            $e_sim_number=$monitoringReport->gps->e_sim_number;
        }
        else{
            $e_sim_number="No Data available";
        }
        ?>
<tr>
        <th style="width: 30%">IMEI </th>
        <td>{{ $monitoringReport->gps->imei }}</td>
    </tr>
    <tr>
        <th>Serial Number</th>
        <td>{{ $monitoringReport->gps->serial_no}}</td>
    </tr>
    <tr>
        <th>Manufacturing date</th>
        <td>{{ $monitoringReport->gps->manufacturing_date}}</td>
    </tr>
    <tr>
        <th>ICC Id</th>
        <td>{{ $monitoringReport->gps->icc_id}}</td>
    </tr>
    <tr>
        <th>IMSI </th>
        <td>{{ $monitoringReport->gps->imsi}}</td>
    </tr>
    <tr> 
        <th>E Sim Number</th>
        <td>{{ $e_sim_number}}</td>
    </tr>
    <tr>  
        <th>Batch Number</th>
        <td>{{ $monitoringReport->gps->batch_number}}</td>
    </tr>
    <tr> 
        <th>Model Name</th>
        <td>{{ $monitoringReport->gps->model_name}}</td>                      
    </tr>
    <tr> 
        <th>Version </th>
        <td>{{ $monitoringReport->gps->version}}</td>  
    </tr>
    <tr>
        <th>Employee Code</th>
        <td>{{ $monitoringReport->gps->employee_code}}</td>
    </tr>
    <tr> 
        <th>Number of satellites </th>
        <td>{{ $no_of_satellites}}</td> 
    </tr>
    <tr> 
        <th>Emergency Status</th>
        <td>{{ $emergency_status}}</td>
    </tr>
    <tr> 
        <th>GPS Fix</th>
        <td>{{ $gps_fix}}</td>
    </tr>
    <tr>
        <th>Calibrated on</th>
        <td>{{ $calibrated_on}}</td>
    </tr>
    <tr> 
        <th>Login on </th>
        <td>@if($monitoringReport->gps->login_on){{ $monitoringReport->gps->login_on }}@else {{'NO Data Available'}}@endif</td>
    </tr>
    <tr> 
        <th>Created At </th>
        <td>{{ $monitoringReport->gps->created_at}}</td>
    </tr>
</table>
<?php 
}
else
{
?>
    <div style="text-align:center">No Device details found.</div>
<?php } ?>
@endif
@if(in_array(5, $report_type))
<p style="margin-left: 53px"><b>Device Current Status</b></p>
<?php
if($monitoringReport->gps)
{
?>
<table border="1" cellspacing="0" cellpadding="2px" style="margin-left: 53px;width: 100%">
<?php
    $fuel_status    =   round( ( ($monitoringReport->vehicleModels->fuel_min - $monitoringReport->gps->fuel_status) / ($monitoringReport->vehicleModels->fuel_min - $monitoringReport->vehicleModels->fuel_max) ) * 100 ).'%';
    $speed_status   =   round($monitoringReport->gps->speed).' km/h';
    $odometer       =   round($monitoringReport->gps->odometer);
    $battery_status =   round($monitoringReport->gps->battery_status).'%';
    $mode           =   $monitoringReport->gps->mode;
    if($mode = 'S')
     { 
        $device_mode="Sleep";
     }else if($mode='M'){
        $device_mode="Moving";
     }else if($mode='H'){
        $device_mode="Halt";
     }else{
        $device_mode="No data Available";
     }
?>
<tr>
            <th style="width: 30%">Mode</th>
            <td>@if($device_mode){{$device_mode}}@else {{'NO Data Available'}}@endif</td> 
        </tr>   
        <tr>
            <th>Latitude</th>
            <td>@if($monitoringReport->gps->lat){{ $monitoringReport->gps->lat }}@else {{'NO Data Available'}}@endif</td>
        </tr>   
        <tr>
            <th>Longitude</th>
            <td>@if($monitoringReport->gps->lon){{ $monitoringReport->gps->lon }}@else {{'NO Data Available'}}@endif</td>
        </tr>   
        <tr>
            <th>Fuel Status</th>
            <td>@if($fuel_status){{ $fuel_status }}@else {{'NO Data Available'}}@endif</td>
        </tr>   
        <tr>
            <th>Speed</th>
            <td>@if($speed_status){{ $speed_status }}@else {{'NO Data Available'}}@endif</td> 
        </tr>   
        <tr>
            <th>Odometer</th>
            <td>@if($odometer){{ $odometer }}@else {{'NO Data Available'}}@endif</td> 
        </tr>   
        <tr>
            <th>Battery Status</th> 
            <td>@if($battery_status){{ $battery_status }}@else {{'NO Data Available'}}@endif</td> 
        </tr>
        <tr>
            <th>Main Power Status</th>  
            <td>
                @if($monitoringReport->gps->main_power_status==0)
                {{'Disconnected'}}@else {{'Connected'}}@endif</td> 
        </tr>
        <tr>
            <th>Device Date and Time</th>   
            <td>@if($monitoringReport->gps->device_time){{ $monitoringReport->gps->device_time }}@else {{'NO Data Available'}}@endif</td> 
        </tr>
        <tr>
            <th>Ignition</th>   
            <td>@if($monitoringReport->gps->ignition==1){{'On'}}@else {{'Off'}}@endif</td> 
        </tr>
        <tr>
            <th>GSM Signal Strength</th>    
            <td>@if($monitoringReport->gps->gsm_signal_strength){{ $monitoringReport->gps->gsm_signal_strength }}@else {{'No Data Available'}}@endif</td> 
        </tr>
        <tr>
            <th>AC Status</th>  
            <td>@if($monitoringReport->gps->ac_status==0){{'Off'  }}@else {{'On'}}@endif</td> 
        </tr>       
</table>
<?php 
}
else
{
?>
    <div style="text-align:center">No Device current status found.</div>
<?php } ?>
@endif
@if(in_array(6, $report_type))
<p style="margin-left: 53px"><b>Device Configuration</b></p>
<?php
if(count($monitoringReport->gps->ota)>0)
{
?>
<table border="1" cellspacing="0" cellpadding="2px" style="margin-left: 53px;width: 100%">
    <thead>
    <tr>
        <th>Header</th>
        <th>Value</th>
        <th>Update At</th>
        </tr>
    </thead>
     @foreach($monitoringReport->gps->ota as $ota)
          <?php
           $header = 'Null'; 
            if($ota->header == 'PU'){
                $header = 'Primary/Reguvaluelatory Purpose URL';
            }
            else if($ota->header == 'EU')
            {
                $header = 'Emergency Response System URl';
            }
            else if($ota->header == 'EM')
            {
                $header = 'Emergency response SMS Number';
            }
            else if($ota->header == 'EO')
            {
                $header = 'Emergency State OFF';
            }
            else if($ota->header == 'ED')
            {
                $header = 'Emergency State Time Duration';
            }
            else if($ota->header == 'APN')
            {
                $header = 'Access Point Name';
            }
            else if($ota->header == 'TA')
            {
                $header = 'Tilt Angle';
            }
            else if($ota->header == 'ST')
            {
                $header = 'Sleep Time';
            }
            else if($ota->header == 'SL')
            {
                $header = 'Speed Limit';
            }
            else if($ota->header == 'HBT')
            {
                $header = 'Harsh Breaking Threshold';
            }
            else if($ota->header == 'HAT')
            {
                $header = 'Harsh Acceleration Threshold';
            }
            else if($ota->header == 'RTT')
            {
                $header = 'Rash Turning Threshold';
            }
            else if($ota->header == 'LBT')
            {
                $header = 'Low Battery Threshold';
            }
            else if($ota->header == 'VN')
            {
                $header = 'Vehicle Registration Number';
            }
            else if($ota->header == 'UR')
            {
                $header = 'Data Update Rate in IGN ON Mode';
            }
            else if($ota->header == 'URT')
            {
                $header = 'Data Update Rate in Halt Mode';
            }
            else if($ota->header == 'URS')
            {
                $header = 'Data Update Rate in IGN OFF/Sleep Mode';
            }
            else if($ota->header == 'URE')
            {
                $header = 'Data Updation Rate in Emergency Mode';
            }
            else if($ota->header == 'URF')
            {
                $header = 'Data Update Rate of Full Packet';
            }
            else if($ota->header == 'URH')
            {
                $header = 'Data Update Rate of Health Packets';
            }
            else if($ota->header == 'VID')
            {
                $header = 'Vendor ID';
            }
            else if($ota->header == 'FV')
            {
                $header = 'Firmware Version';
            }
            else if($ota->header == 'DSL')
            {
                $header = 'Default Speed Limit';
            }
            else if($ota->header == 'HT')
            {
                $header = 'Halt Time';
            }
            else if($ota->header == 'M1')
            {
                $header = 'Contact Mobile Number';
            }
            else if($ota->header == 'M2')
            {
                $header = 'Contact Mobile Number 2';
            }
            else if($ota->header == 'M3')
            {
                $header = 'Contact Mobile Number 3';
            }
            else if($ota->header == 'GF')
            {
                $header = 'Geofence';
            }
            else if($ota->header == 'OM')
            {
                $header = 'OTA Updated Mobile';
            }
            else if($ota->header == 'OU')
            {
                $header = 'OTA Updated URL';
            }
            else
            {
                $header = $ota->header;
            }
            
          ?>
 }
 }
    <tr>
        <td>{{$header}}</td>
        <td>{{$ota->value}}</td>
        <td>{{$ota->updated_at}}</td>
    </tr>  
    @endforeach 
</table>
<?php 
}
else
{
?>
    <div style="text-align:center">No OTA Responses.</div>
<?php } ?>
@endif
@if(in_array(7, $report_type))
<?php 

$installation_jobs  = [];
$service_jobs       = [];
// seggregate installation and monitoring jobs
foreach($monitoringReport->jobs as $job)
{
    switch($job->job_type)
    {
        case '1':
            array_push($installation_jobs, $job);
            break;
        case '2':
            array_push($service_jobs, $job);
            break;
        default;
            break;
    }
}
?>
<p style="margin-left: 53px"><b>Installation</b></p>

    <?php
    if( count($installation_jobs) > 0 )
    {
    ?>
    <table border="1" cellspacing="0" cellpadding="2px" style="margin-left: 53px;width: 100%">
        <tr>
            <th>Servicer Name</th>
            <th>Job Date</th>
            <th>Job Completed Date</th>
            <th>Location</th>
            <th>Description</th>
            <th>Comments</th>
        </tr>
        @foreach($installation_jobs as $each_installation_job)
            <tr>
                <td>{{$each_installation_job->servicer->name}}</td>
                <td>{{$each_installation_job->job_date}}</td>
                <td>{{$each_installation_job->job_complete_date}}</td>
                <td>{{$each_installation_job->location}}</td>
                <td>{{$each_installation_job->description}}</td>
                <td>{{$each_installation_job->comment}}</td>
            </tr>
        @endforeach
    </table>
    <?php 
    }
    else
    {
    ?>
    <div style="text-align:center">No installation found.</div>
    <?php } ?>
@endif
@if(in_array(8, $report_type))
<p style="margin-left: 53px"><b>Service(S)</b></p>
<?php
    if( count($service_jobs) > 0 )
    {
    ?>
        <table border="1" cellspacing="0" cellpadding="2px" style="margin-left: 53px;width: 100%">
            <tr>
                <th>Servicer Name</th>
                <th>Job Date</th>
                <th>Job Completed Date</th>
                <th>Location</th>
                <th>Description</th>
                <th>Comments</th>
            </tr>
            @foreach($monitoringReport->jobs as $service_jobs)
                <tr>
                    <td>{{$service_jobs->servicer->name}}</td>
                    <td>{{$service_jobs->job_date}}</td>
                    <td>{{$service_jobs->job_complete_date}}</td>
                    <td>{{$service_jobs->location}}</td>
                    <td>{{$service_jobs->description}}</td>
                    <td>{{$service_jobs->comment}}</td>
                </tr>
            @endforeach
        </table>
    <?php 
    }
    else
    {
    ?>
        <div style="text-align:center">No service(s) found.</div>
    <?php } ?>
@endif
@if(in_array(9, $report_type))
<p style="margin-left: 53px"><b>Alerts</b></p>
<?php
    if(count($monitoringReport->alerts)>0)
    {
    ?>
<table border="1" cellspacing="0" cellpadding="2px" style="margin-left: 53px;width: 100%">
    <tr>
        <th >Alert</th>
        <th >Date and Time of alert</th>                            
    </tr>
    @foreach($monitoringReport->alerts as $alert)
        <tr>
            <td>{{$alert->alertType->description}}</td>
            <td>{{$alert->device_time}}</td>
        </tr>
    @endforeach
</table>
<?php 
    }
    else
    {
    ?>
        <div style="text-align:center">No Alert(s) found.</div>
    <?php } ?>
@endif
</body>
</html>