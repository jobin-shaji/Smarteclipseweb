<html>
<head><meta http-equiv=Content-Type content="text/html; charset=UTF-8">
<style type="text/css">
<!--
span.cls_002{font-family:Times,serif;font-size:15px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
div.cls_002{font-family:Times,serif;font-size:11.1px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
span.cls_003{font-family:Times,serif;font-size:21.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
div.cls_003{font-family:Times,serif;font-size:21.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
span.cls_004{font-family:Times,serif;font-size:30.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
div.cls_004{font-family:Times,serif;font-size:30.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
span.cls_005{font-family:Times,serif;font-size:15px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
div.cls_005{font-family:Times,serif;font-size:11.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
span.cls_006{font-family:Times,serif;font-size:9.1px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
div.cls_006{font-family:Times,serif;font-size:12px!important;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
span.cls_007{font-family:Times,serif;font-size:10px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
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
<div style="position:fixed;left: 7%;top: 7%;width:595px;height:841px;border-style:outset;overflow:hidden">
<div style="position:absolute;left:44.88px;top:41.80px" class="cls_002"><span class="cls_002"> <b>{{$servicer_job->sub_dealer->name}}</b></span></div>
<div style="position:absolute;left:43.68px;top:56.44px" class="cls_002"><span class="cls_002"><b>{{$servicer_job->sub_dealer->address}}</b><br><b>
{{$servicer_job->user->email}}</b><br><b>
{{$servicer_job->user->mobile}}</b></span></div>
<div style="position:absolute;left:409.44px;top:36.72px" class="cls_003">
	<img src="assets/images/smart_eclipse_logo.png" alt="Logo" height="30px" width="150px"></div>
<div style="position:absolute;left:44.16px;top:185.32px;padding: 0 0 0 3%" class="cls_002"><span class="cls_002">This is to certify that , this vehicle is equiped with the AIS 140 compliant device,</span></div>
<div style="position:absolute;left:44.64px;top:201.16px" class="cls_002"><span class="cls_002" style="letter-spacing: 1px;padding: 0 0 0 4.5%">approved by </span><span class="cls_005" >CDAC </span><span class="cls_002">and </span><span class="cls_005">ARAI.</span></div>
<div style="position:absolute;left:90px;top:251.88px" class="cls_006"><span class="cls_006">Issue Date<b style="margin-left: 9.7%">:</b> {{$date}}</span></div>
<div style="position:absolute;left:350px;top:251.88px" class="cls_006"><span class="cls_006">VLT Model No<b style="margin-left: 1.8%">:</b> </span></div>
<div style="position:absolute;left:90px;top:278.52px" class="cls_006"><span class="cls_006">Registration No<b style="margin-left: 4.6%">:</b> {{$vehicle->register_number}}</span></div>
<div style="position:absolute;left:350px;top:278.52px" class="cls_006"><span class="cls_006">VLT Sim No<b style="margin-left: 6.7%">:</b> </span></div>
<div style="position:absolute;left:90px;top:304.20px" class="cls_006"><span class="cls_006">Vehicle Chassis No<b style="margin-left: 1%">:</b> {{$vehicle->chassis_number}}</span></div>
<div style="position:absolute;left:350px;top:304.92px" class="cls_006"><span class="cls_006">IMEI No<b style="margin-left: 14.9%">:</b> {{$vehicle->gps->imei}}</span></div>
<div style="position:absolute;left:90px;top:330.60px" class="cls_006"><span class="cls_006">Owner Mobile No<b style="margin-left: 2.3%">:</b> {{$client->user->mobile}}</span></div>
<div style="position:absolute;left:350px;top:331.56px" class="cls_006"><span class="cls_006">RTO Office<b style="margin-left: 8.8%">:</b> </span></div>
<div style="position:absolute;left:90px;top:356.28px" class="cls_006"><span class="cls_006">Franchisee Details<b style="margin-left: 2.1%">:</b> </span></div>
<div style="position:absolute;left:350px;top:356.04px" class="cls_006"><span class="cls_006">Warranty Upto<b style="margin-left: 3%">:</b> </span></div>
<div style="position:absolute;left:90px;top:383.40px" class="cls_006"><span class="cls_006">Vehicle Type<b style="margin-left: 6.9%">:</b> {{$vehicle->vehicleType->name}}</span></div>
<div style="position:absolute;left:350px;top:383.16px" class="cls_006"><span class="cls_006">Token No<b style="margin-left: 13%">:</b> </span></div>
<div style="position:absolute;left:90px;top:570px" class="cls_006"><span class="cls_006">Issued By<b style="margin-left: 9.9%">:</b> {{$servicer_job->sub_dealer->name}}</span></div>
<div style="position:absolute;left:350px;top:570px" class="cls_006"><span class="cls_006">Inspected and Approved By:</span></div>
<div style="position:absolute;left:90px;top:650px" class="cls_006"><span class="cls_006">Franchisee Name <b style="margin-left: 2%">:</b> </span></div>
<div style="position:absolute;left:350px;top:650px" class="cls_006"><span class="cls_006">Name & Signature</span></div>
<div style="position:absolute;left:400px;top:740px" class="cls_006"><span class="cls_006">Official Seal</span></div>
<div style="position:absolute;left:462.96px;top:794.60px" class="cls_007"><span class="cls_007">VST Mobility Solutions</span></div>
</div>

</body>
</html>
