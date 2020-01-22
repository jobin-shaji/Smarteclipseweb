<table>
<thead>
	<tr>
		<th colspan="5">Vehicle Details</th>
	</tr>
	<tr>
		<th>Vehicle Name</th>
		<th>Registration Number</th>
		<th>Vehicle Type</th>
		<th>Vehicle Model </th>
		<th>Vehicle Make</th> 
		<th>Engine Number</th>  
		<th>Chassis Number</th> 
		<th>Theft Mode </th> 
		<th>Towing </th> 
		<th>Emergency Status  </th> 
		<th>Created At </th> 
	</tr>
</thead>
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
<td>{{ $monitoringReportExport->name }}</td> 
<td>{{ $monitoringReportExport->register_number}}</td> 
<td>{{ $monitoringReportExport->vehicleType->name}}</td>
<td>{{ $monitoringReportExport->vehicleModels->name}}</td> 
<td>{{ $monitoringReportExport->vehicleModels->vehicleMake->name}}</td>                  
<td>{{ $monitoringReportExport->engine_number}}</td>                  
<td>{{ $monitoringReportExport->chassis_number}}</td>                  
<td>{{ $theft_mode}}</td>                  
<td>{{ $towing}}</td>                  
<td>{{ $emergency_status}}</td>                  
<td>{{ $monitoringReportExport->created_at}}</td>                  

</tr>
 </tbody>
</table>
<table>
<thead>
	<tr>
		<th colspan="5">Owner Details</th>
	</tr>
	<tr>
		<th>Owner Name </th>
		<th>Owner Username</th>
		<th>Owner Address</th>
		<th>Owner Mobile</th>
		<th>Owner Email</th> 
		<th>Owner Latitude </th>  
		<th>Owner Longitude</th> 
		<th>Owner Country</th> 
		<th>Owner State</th> 
		<th>Owner City </th> 
		<th>Dealer </th> 
		<th>Owner Package </th> 

	</tr>
</thead>
<tbody> <?php

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
<td>{{ $monitoringReportExport->client->name }}</td> 
<td>{{ $monitoringReportExport->client->user->username}}</td> 
<td>{{ $monitoringReportExport->client->address}}</td>
<td>{{ $monitoringReportExport->client->user->mobile}}</td> 
<td>{{ $monitoringReportExport->client->user->email}}</td>                  
<td>{{ $monitoringReportExport->client->latitude}}</td>                  
<td>{{ $monitoringReportExport->client->longitude}}</td>                  
<td>{{ $monitoringReportExport->client->country->name}}</td>                  
<td>{{ $monitoringReportExport->client->state->name}}</td>                  
<td>{{ $monitoringReportExport->client->city->name}}</td>                  
<td>{{ $dealer_trader}}</td> 
<td>{{ $user_role}}</td>                  


</tr>
 </tbody>
</table>
<table>
<thead>
	<tr>
		<th colspan="5">Driver Details</th>
	</tr>
	<tr>
		<th>Driver Name </th>
		<th>Driver Address</th>
		<th>Driver Mobile</th>
		<th>Driver Points</th>
	</tr>
</thead>
	<tbody> 
	 	<tr>           
			<td>{{ $monitoringReportExport->name }}</td> 
			<td>{{ $monitoringReportExport->register_number}}</td> 
			<td>{{ $monitoringReportExport->vehicleType->name}}</td>
			<td>{{ $monitoringReportExport->vehicleModels->name}}</td> 
		</tr>
	</tbody>
</table>
