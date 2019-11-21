@extends('layouts.eclipse')

@section('content')

<section class="hilite-content" style="min-height: 200px">

<div class="row">

<div class="col-md-4">

<div style ="margin-left: 77px"class="form-group has-feedback">

<label class="srequired">GPS</label>

<select class=" form-control select2" id="gps_id" name="gps_id" data-live-search="true" title="Select GPS" required onchange='singleGpsData(this.value)'>

<option value="">Select GPS</option>

@foreach($gps as $gps)

<option value="{{$gps->id}}">{{$gps->imei}} || {{$gps->serial_no}}</option>

@endforeach

</select>

</div>

</div>

<div class="col-md-4">

<div style ="width: 15%;margin-left: 12%;margin-top: 5%" >

<button class="btn btn-md btn-success btn2 form-control" id="set_ota_button" data-toggle="modal" data-target="#setOtaModal" style="display: none;">SET OTA</button>

</div>

</div>

</div>

</section>

<section class="content" style="width:100%">

<div class=col-md-9>

<div class="table-responsive">

<table style="background-color: black;color: white;float: left">
 <thead id ="last_update_time">

</thead>  

<tbody id ="gps_table">

<div class="loader" id="loader" style="margin:20% 50%"></div>

</tbody>

</table>

</div>

</div>

<!-- <div class="col-md-3">
 -->
<div class="table-responsive">

<table class="table" style="width: 0px!important">

<tbody id="datas" >

</tbody>

</table>

</div>

<!-- </div>
 -->
</section>

<div class="modal fade" id="setOtaModal" tabindex="-1" role="dialog" aria-labelledby="setOtaModalLabel" style="display: none;">

<div class="modal-dialog modal-lg" role="document">

<div class="modal-content" style="padding: 25px">

<div class="modal-header">

<button type="button" class="close" data-dismiss="modal" aria-label="Close">

<span aria-hidden="true">&times;</span></button>

</div>

<form method="POST" id="form1">

{{csrf_field()}}

<div class="modal-body">

<div class="row">

<div class="col-md-12">

<input type="hidden" name="set_ota_gps_id" id="set_ota_gps_id" value="">
<div class="form-group row" style="float:none!important">
<label for="fname" class="col-sm-3 text-right control-label col-form-label">Command:</label>
<div class="form-group has-feedback">
	<select id="ota" name="ota" class="form-control">
		<option Value="" selected="selected" disabled="disabled">Select</option>

		<option  Value="SET PU: ">Primary/Regulatory Purpose URL</option>
		<option  Value="SET M0:">Control Centre Number </option>
		<option Value="SET ED:">Emergency State Time Duration 
(This will be overridden if NERS value is published)</option>
		<option Value="SET ST:">Sleep Time </option>
		<option Value="SET HT:">Halt Time </option>
		<option Value="SET SL:">Speed Limit </option>
		<option  Value="SET HBT:">Harsh Breaking Threshold </option>
		<option Value="SET HAT:">Harsh Acceleration Threshold </option>
		<option Value="SET RTT:">Rash Turning Threshold </option>	
		<option Value="SET LBT:">Low Battery Threshold  </option>	
		<option Value="SET TA:"> Tilt Angle </option>	
		<option Value="SET VN:"> Vehicle Registration Number </option>	
		<option Value="SET UR:"> Data Update Rate in Motion Mode </option>	
		<option Value="SET URT:">Data Update Rate in Halt Mode  </option>	
		<option Value="SET URS:">Data Update Rate in Sleep Mode  </option>	
		<option Value="SET URE:">Data Update Rate in Emergency Mode  </option>	
		<option Value="SET URF:">Data Update Rate of Full Packet  </option>	
		<option Value="SET URH:">Data Update Rate of Health Packets  </option>	
		<option Value="SET DSL:">Default speed limit  </option>	
		<option Value="SET M1:">Contact Mobile Number  </option>	
		<option Value="SET M2:">Contact Mobile Number 2  </option>	
		<option Value="SET M3:"> Contact Mobile Number 3 </option>	
		<option Value="SET GF:">Geofence </option>	
		<option Value="SET PUV: ">Secondary URL </option>	
		<option Value="SET APN: "> APN</option>	
		<option Value="SET PWD: "> Password</option>		
		<option Value="SET EST:">Emergency Switch Timing </option>	
		<option Value="SET FTP:">Fota update </option>	
		<option Value="SET IP: ">Fota IP </option>	
		<option Value="SET TM:"> Time Zone</option>	
		<option Value="SET FLC:"> Fuel reference value, Fuel base value</option>
		<option Value="SET IMO:"> Immobilizer</option>	
		<option Value="SET NOD:"> No.of Days</option>	
		<option Value="SET GP1:"> GPIO output SET/CLR</option>	
		<option Value="SET GP2:"> GPIO output SET/CLR</option>	
		<option Value="SET DC1:">Directory 1 of primary IP </option>	
		<option Value="SET DC2:"> Directory 2 of secondary IP</option>	
		<option Value="SET GPS:"> To write PSTM commands to GPS </option>	
		<option Value="SET AOF:"> Acknowledgement OFF</option>	
		<option Value="SET FUS:"> Fota Username </option>	
		<option Value="SET FPD:"> Fota Password</option>	
		<option Value="SET CDC:"> Country Code </option>	
	</select>
</div>
</div>


<div class="form-group row" style="float:none!important">

<label for="fname" class="col-sm-3 text-right control-label col-form-label">Values:</label>

<div class="form-group has-feedback">

<textarea class="form-control" name="command" id="command" rows=7></textarea>

</div>

</div>

</div>

</div>

</div>

<div class="modal-footer">

<span class="pull-center">

<button type="button" class="btn btn-success btn-md btn-block" onclick="setOta(document.getElementById('set_ota_gps_id').value)">

POST

</button>

</span>

</div>

</form>

</div>

</div>

</div>

@section('script')

<script src="{{asset('js/gps/allgpsdata-list.js')}}"></script>

@endsection

@endsection