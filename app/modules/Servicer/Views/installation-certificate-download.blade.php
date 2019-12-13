<html>
<head><meta http-equiv=Content-Type content="text/html; charset=UTF-8">
<style type="text/css">
<!--
span.cls_002{font-family:Times,serif;font-size:11.1px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
div.cls_002{font-family:Times,serif;font-size:11.1px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
span.cls_003{font-family:Times,serif;font-size:21.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
div.cls_003{font-family:Times,serif;font-size:21.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
span.cls_004{font-family:Times,serif;font-size:30.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
div.cls_004{font-family:Times,serif;font-size:30.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
span.cls_005{font-family:Times,serif;font-size:11.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
div.cls_005{font-family:Times,serif;font-size:11.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
span.cls_006{font-family:Times,serif;font-size:9.1px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
div.cls_006{font-family:Times,serif;font-size:9.1px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
span.cls_007{font-family:Times,serif;font-size:7.0px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
div.cls_007{font-family:Times,serif;font-size:7.0px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
-->
</style>
<script type="text/javascript" src="wz_jsgraphics.js"></script>
</head>
<body>
	<?php
	$job_complete_date = $servicer_job->job_complete_date;
	$date = new DateTime($job_complete_date);

	$date = $date->format('d/m/Y');
?>
<div style="position:absolute;left:50%;margin-left:-297px;top:0px;width:595px;height:841px;border-style:outset;overflow:hidden">
<div style="position:absolute;left:44.88px;top:41.80px" class="cls_002"><span class="cls_002">Dealer :{{$servicer_job->user->mobile}},{{$servicer_job->user->email}}</span></div>
<div style="position:absolute;left:43.68px;top:56.44px" class="cls_002"><span class="cls_002">Address</span></div>
<div style="position:absolute;left:409.44px;top:36.72px" class="cls_003"><span class="cls_003">Smart</span><span class="cls_004"></span></div>
<div style="position:absolute;left:44.16px;top:185.32px" class="cls_002"><span class="cls_002">This is to certify that , this vehicle is equiped with the AIS 140 compliant device,</span></div>
<div style="position:absolute;left:44.64px;top:201.16px" class="cls_002"><span class="cls_002">approved by </span><span class="cls_005">CDAC </span><span class="cls_002">and </span><span class="cls_005">ARAI.</span></div>
<div style="position:absolute;left:50.40px;top:251.88px" class="cls_006"><span class="cls_006">Issue Date::{{$date}}</span></div>
<div style="position:absolute;left:304.08px;top:251.88px" class="cls_006"><span class="cls_006">VLT Model No.</span></div>
<div style="position:absolute;left:50.40px;top:278.52px" class="cls_006"><span class="cls_006">Regn No:{{$vehicle->register_number}}</span></div>
<div style="position:absolute;left:304.08px;top:278.52px" class="cls_006"><span class="cls_006">VLT Sim No.</span></div>
<div style="position:absolute;left:49.68px;top:304.20px" class="cls_006"><span class="cls_006">Vehicle Chassis No: {{$vehicle->chassis_number}}</span></div>
<div style="position:absolute;left:305.04px;top:304.92px" class="cls_006"><span class="cls_006">IMEI No: {{$vehicle->gps->imei}}</span></div>
<div style="position:absolute;left:50.16px;top:330.60px" class="cls_006"><span class="cls_006">Owner Mobile No:{{$client->user->mobile}}</span></div>
<div style="position:absolute;left:305.04px;top:331.56px" class="cls_006"><span class="cls_006">RTO Office</span></div>
<div style="position:absolute;left:49.44px;top:356.28px" class="cls_006"><span class="cls_006">Franchisee Details</span></div>
<div style="position:absolute;left:303.84px;top:356.04px" class="cls_006"><span class="cls_006">Warranty Upto</span></div>
<div style="position:absolute;left:49.68px;top:383.40px" class="cls_006"><span class="cls_006">Vehicle Type:{{$vehicle->vehicleType->name}}</span></div>
<div style="position:absolute;left:305.04px;top:383.16px" class="cls_006"><span class="cls_006">Token No.</span></div>
<div style="position:absolute;left:44.16px;top:456.36px" class="cls_006"><span class="cls_006">Issued By:{{$servicer_job->user->username}}</span></div>
<div style="position:absolute;left:303.84px;top:455.88px" class="cls_006"><span class="cls_006">Inspected and Approved By:</span></div>
<div style="position:absolute;left:44.16px;top:507.24px" class="cls_006"><span class="cls_006">Franchisee Name :</span></div>
<div style="position:absolute;left:303.60px;top:507.24px" class="cls_006"><span class="cls_006">Name & Signature</span></div>
<div style="position:absolute;left:303.60px;top:558.12px" class="cls_006"><span class="cls_006">Official Seal.</span></div>
<div style="position:absolute;left:462.96px;top:794.60px" class="cls_007"><span class="cls_007">Mobility Solutions</span></div>
</div>

</body>
</html>
