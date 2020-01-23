@if(in_array(1, $report_type))
<table>
<tbody>
	<?php
	if( $monitoringReportExport->theft_mode==0){
		$theft_mode='Disabled';
	}
	else{
		$theft_mode='Enabled';
	}
	if( $monitoringReportExport->towing==0){
		$towing='Not Towing';
	}
	else{
		$towing='Towing';
	}
	if( $monitoringReportExport->emergency_status==0){
		$emergency_status='Off';
	}
	else{
		$emergency_status='On';
	}
	?>
	<tr>
		<th colspan="2" style="text-align: center;">Vehicle Details</th>
	</tr>
	<tr>
		<th>Vehicle Name</th>
		<td>{{ $monitoringReportExport->name }}</td>
	</tr>
	<tr>
		<th>Registration Number</th>
		<td>{{ $monitoringReportExport->register_number}}</td>
	</tr>
	<tr>
		<th>Vehicle Type</th>
		<td>{{ $monitoringReportExport->vehicleType->name}}</td>
	</tr>
	<tr>
		<th>Vehicle Model </th>
		<td>{{ $monitoringReportExport->vehicleModels->name}}</td>
	</tr>
	<tr>
		<th>Vehicle Make</th>
		<td>{{ $monitoringReportExport->vehicleModels->vehicleMake->name}}</td>
	</tr>
	<tr> 
		<th>Engine Number</th>
		<td>{{ $monitoringReportExport->engine_number}}</td>
	</tr>
	<tr>  
		<th>Chassis Number</th>
		<td>{{ $monitoringReportExport->chassis_number}}</td>
	</tr>
	<tr> 
		<th>Theft Mode </th>
		<td>{{ $theft_mode}}</td> 
	</tr>
	<tr> 
		<th>Towing </th>
		<td>{{ $towing}}</td> 
	</tr>
	<tr>
		<th>Emergency Status  </th>
		<td>{{ $emergency_status}}</td> 
	</tr>
	<tr> 
		<th>Created At </th>
		<td>{{ $monitoringReportExport->created_at}}</td> 
	</tr>
</tbody>
</table>
@endif
@if(in_array(2, $report_type))
<table>
<tbody>
	<?php
$role=$monitoringReportExport->client->user->role;
if($role==0||$role==4)
 { 
 	$user_role="Freebies";
 }else if($role==6){
 	$user_role="Fundamental";
 }else if($role==7){
 	$user_role="Superior";
 }else if($role==8){
 	$user_role="Pro";
 }
 else{
 	$user_role="No data Available";
 }
 if($monitoringReportExport->client->subdealer){
 	$dealer_trader=$monitoringReportExport->client->subdealer->name;
 }
 else if($monitoringReportExport->client->trader){
 	$dealer_trader=$monitoringReportExport->client->trader->name;
 }
 else{
 	$dealer_trader="Not Assigned";
 }                
?>
	<tr>
		<th colspan="2" style="text-align: center;">Owner Details</th>
	</tr>
	<tr>
		<th>Owner Name </th>
		<td>{{ $monitoringReportExport->client->name }}</td> 
	</tr>
	<tr>
		<th>Owner Username</th>
		<td>{{ $monitoringReportExport->client->user->username}}</td> 
	</tr>
	<tr>
		<th>Owner Address</th>
		<td>{{ $monitoringReportExport->client->address}}</td>
	</tr>
	<tr>
		<th>Owner Mobile</th>
		<td>{{ $monitoringReportExport->client->user->mobile}}</td> 
	</tr>
	<tr>
		<th>Owner Email</th>
		<td>{{ $monitoringReportExport->client->user->email}}</td>                  
 	</tr>
	<tr>
		<th>Owner Latitude </th> 
		<td>{{ $monitoringReportExport->client->latitude}}</td>                  
	</tr> 
	<tr>
		<th>Owner Longitude</th>
		<td>{{ $monitoringReportExport->client->longitude}}</td>
	</tr>
	<tr> 
		<th>Owner Country</th>
		<td>{{ $monitoringReportExport->client->country->name}}</td>
	</tr>
	<tr> 
		<th>Owner State</th>
		<td>{{ $monitoringReportExport->client->state->name}}</td>
	</tr> 
	<tr>
		<th>Owner City </th> 
		<td>{{ $monitoringReportExport->client->city->name}}</td>
	</tr>
	<tr>
		<th>Dealer </th>
		<td>{{ $dealer_trader}}</td> 
	</tr> 
	<tr>
		<th>Owner Package </th>
		<td>{{ $user_role}}</td>  
	</tr>

	
</tbody>
</table>
@endif
@if(in_array(3, $report_type))
@if($monitoringReportExport->driver)
<table>
<tbody>
	<?php
		if($monitoringReportExport->driver->points<=0){
			$points=0;
		}
		else{
			$points=$monitoringReportExport->driver->points;
		}
	?>
	<tr>
		<th colspan="2" style="text-align: center;">Driver Details</th>
	</tr>
	<tr>
		<th>Driver Name </th>
		<td>{{ $monitoringReportExport->driver->name }}</td>
	</tr>
	<tr>
		<th>Driver Address</th>
		<td>{{ $monitoringReportExport->driver->address}}</td>
	</tr>
	<tr>
		<th>Driver Mobile</th>
		<td>{{ $monitoringReportExport->driver->mobile}}</td>
	</tr>
	<tr>
		<th>Driver Points</th>
		<td>{{ $points}}</td>
	</tr>
</tbody>
</table>
@endif
@endif
@if(in_array(4, $report_type))
<table>
<tbody>
	<?php
		if($monitoringReportExport->gps->emergency_status ==0){
			$emergency_status="Off";
		}
		else{
			$emergency_status="On";
		}
		if($monitoringReportExport->gps->gps_fix_on ==0){
			$gps_fix="Not Received";
		}
		else{
			$gps_fix="Received";
		}
		if($monitoringReportExport->gps->calibrated_on){
			$calibrated_on=$monitoringReportExport->gps->calibrated_on;
		}
		else{
			$calibrated_on="No Data available";
		}
		if($monitoringReportExport->gps->login_on){
			$login_on=$monitoringReportExport->gps->login_on;
		}
		else{
			$login_on="No Data available";
		}
		if($monitoringReportExport->gps->no_of_satellites){
			$no_of_satellites=$monitoringReportExport->gps->no_of_satellites;
		}
		else{
			$no_of_satellites="No Data available";
		}
		if($monitoringReportExport->gps->e_sim_number){
			$e_sim_number=$monitoringReportExport->gps->e_sim_number;
		}
		else{
			$e_sim_number="No Data available";
		}
		?>
	<tr >
		<th colspan="2" style="text-align: center;">Device Details</th>
	</tr>
	<tr>
		<th>IMEI </th>
		<td>{{ $monitoringReportExport->gps->imei }}</td>
	</tr>
	<tr>
		<th>Serial Number</th>
		<td>{{ $monitoringReportExport->gps->serial_no}}</td>
	</tr>
	<tr>
		<th>Manufacturing date</th>
		<td>{{ $monitoringReportExport->gps->manufacturing_date}}</td>
	</tr>
	<tr>
		<th>ICC Id</th>
		<td>{{ $monitoringReportExport->gps->icc_id}}</td>
	</tr>
	<tr>
		<th>IMSI </th>
		<td>{{ $monitoringReportExport->gps->imsi}}</td>
	</tr>
	<tr> 
		<th>E Sim Number</th>
		<td>{{ $e_sim_number}}</td>
	</tr>
	<tr>  
		<th>Batch Number</th>
		<td>{{ $monitoringReportExport->gps->batch_number}}</td>
	</tr>
	<tr> 
		<th>Model Name</th>
		<td>{{ $monitoringReportExport->gps->model_name}}</td>                  	
	</tr>
	<tr> 
		<th>Version </th>
		<td>{{ $monitoringReportExport->gps->version}}</td>  
	</tr>
	<tr>
		<th>Employee Code</th>
		<td>{{ $monitoringReportExport->gps->employee_code}}</td>
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
		<td>@if($monitoringReportExport->gps->login_on){{ $monitoringReportExport->gps->login_on }}@else {{'NO Data Available'}}@endif</td>
	</tr>
	<tr> 
		<th>Created At </th>
		<td>{{ $monitoringReportExport->gps->created_at}}</td>
	</tr>
</tbody>
</table>
@endif
@if(in_array(5, $report_type))
<table>
	<tbody>	
		<tr>
			<th colspan="2" style="text-align: center;">Device Current Status</th>				
		</tr>	
		<tr>
			<th>Mode</th>
			<td>@if($monitoringReportExport->gps->mode){{ $monitoringReportExport->gps->mode }}@else {{'NO Data Available'}}@endif</td> 
		</tr>	
		<tr>
			<th>Latitude</th>
			<td>@if($monitoringReportExport->gps->lat){{ $monitoringReportExport->gps->lat }}@else {{'NO Data Available'}}@endif</td>
		</tr>	
		<tr>
			<th>Longitude</th>
			<td>@if($monitoringReportExport->gps->lon){{ $monitoringReportExport->gps->lon }}@else {{'NO Data Available'}}@endif</td>
		</tr>	
		<tr>
			<th>Fuel Status</th>
			<td>@if($monitoringReportExport->gps->fuel_status){{ $monitoringReportExport->gps->fuel_status }}@else {{'NO Data Available'}}@endif</td>
		</tr>	
		<tr>
			<th>Speed</th>
			<td>@if($monitoringReportExport->gps->speed){{ $monitoringReportExport->gps->speed }}@else {{'NO Data Available'}}@endif</td> 
		</tr>	
		<tr>
			<th>Odometer</th>
			<td>@if($monitoringReportExport->gps->odometer){{ $monitoringReportExport->gps->odometer }}@else {{'NO Data Available'}}@endif</td> 
		</tr>	
		<tr>
			<th>Battery Status</th>	
			<td>@if($monitoringReportExport->gps->battery_status){{ $monitoringReportExport->gps->battery_status }}@else {{'NO Data Available'}}@endif</td> 
		</tr>
		<tr>
			<th>Main Power Status</th>	
			<td>
				@if($monitoringReportExport->gps->main_power_status==0)
				{{'Disconnected'}}@else {{'Connected'}}@endif</td> 
		</tr>
		<tr>
			<th>Device Date and Time</th>	
			<td>@if($monitoringReportExport->gps->device_time){{ $monitoringReportExport->gps->device_time }}@else {{'NO Data Available'}}@endif</td> 
		</tr>
		<tr>
			<th>Ignition</th>	
			<td>@if($monitoringReportExport->gps->ignition){{ $monitoringReportExport->gps->ignition }}@else {{'NO Data Available'}}@endif</td> 
		</tr>
		<tr>
			<th>Ignition</th>	
			<td>@if($monitoringReportExport->gps->ignition==1){{'On'}}@else {{'Off'}}@endif</td> 
		</tr>
		<tr>
			<th>GSM Signal Strength</th>	
			<td>@if($monitoringReportExport->gps->gsm_signal_strength){{ $monitoringReportExport->gps->gsm_signal_strength }}@else {{'No data Available'}}@endif</td> 
		</tr>
		<tr>
			<th>AC Status</th>	
			<td>@if($monitoringReportExport->gps->ac_status==0){{'Off'  }}@else {{'On'}}@endif</td> 
		</tr>		
	</tbody>
</table>
@endif
@if(in_array(6, $report_type))
<table>
	<thead>	
		<tr>
			<th colspan="3" style="text-align: center;">Device Configuration</th>				
		</tr>	
		<tr>
			<th>Header</th>
			<th>Value</th>
			<th>Updated at</th> 

		</tr>	
	</thead>
	<tbody>
		 @foreach($monitoringReportExport->gps->ota as $ota)
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
	    <tr>
			<td>{{$header}}</td>
			<td>{{$ota->value}}</td>
			<td>{{$ota->updated_at}}</td>
		</tr>
		@endforeach
	</tbody>
</table>
@endif

@if(in_array(7, $report_type))
<table>
	<thead>	
		<tr>
			<th colspan="2" style="text-align: center;">Installation</th>				
		</tr>		
	</thead>
	<tbody>
		 @foreach($monitoringReportExport->jobs as $jobs)
		 @if($jobs->job_type==1)
	    <tr>
	    	<th>Servicer</th>
			<td>{{$jobs->servicer->name}}</td>
		</tr>
		<tr>
			<th>Job Date</th>
			<td>{{$jobs->job_date}}</td>
		</tr>
		<tr>
			<th>Job Completed Date</th>
			<td>{{$jobs->job_complete_date}}</td>
		</tr>
		<tr>
			<th>Location</th>
			<td>{{$jobs->location}}</td>
		</tr>
		<tr>
			<th>Description</th>
			<td>{{$jobs->description}}</td>
		</tr>
		<tr>
			<th>Comments</th>
			<td>{{$jobs->comment}}</td>
		</tr>
		@endif
		@endforeach
	</tbody>
</table>
@endif

@if(in_array(8, $report_type))
<table>
	<thead>	
		<tr>
			<th colspan="2" style="text-align: center;">Service</th>				
		</tr>		
	</thead>
	<tbody>
		 @foreach($monitoringReportExport->jobs as $jobs)
		 @if($jobs->job_type==2)
	    <tr>
	    	<th>Servicer</th>
			<td>{{$jobs->servicer->name}}</td>
		</tr>
		<tr>
			<th>Job Date</th>
			<td>{{$jobs->job_date}}</td>
		</tr>
		<tr>
			<th>Job Completed Date</th>
			<td>{{$jobs->job_complete_date}}</td>
		</tr>
		<tr>
			<th>Location</th>
			<td>{{$jobs->location}}</td>
		</tr>
		<tr>
			<th>Description</th>
			<td>{{$jobs->description}}</td>
		</tr>
		<tr>
			<th>Comments</th>
			<td>{{$jobs->comment}}</td>
		</tr>
		@endif
		@endforeach
	</tbody>
</table>
@endif
@if(in_array(9, $report_type))
<table>
	<thead>	
		<tr>
			<th colspan="2" style="text-align: center;">Alerts</th>				
		</tr>
		<tr>
			<th >Alert</th>
			<th >Date and Time of alert</th>							
		</tr>		
	</thead>
	<tbody>
		@foreach($monitoringReportExport->alerts as $alert)
		    <tr>
		    	<td>{{$alert->alertType->description}}</td>
		    	<td>{{$alert->device_time}}</td>
			</tr>
		@endforeach
	</tbody>
</table>
@endif
