@extends('layouts.eclipse')

@section('content')

<section class="hilite-content">
      <!-- title row -->     
  <div class="row">
    <div class="panel-body" style="width: 100%;min-height: 10%">
      <div class="panel-heading">
        <div class="cover_div_search">
         
            <div class="row">

             <div class="col-lg-3 col-md-3"> 
        <div class="form-group" style="margin-left: 20%;margin-top: 2%;">
                <label>ACK PACKET</label>  
<textarea rows="4"  id="packetvalue"  cols="50">

                  </textarea>
                      <button class="btn btn-sm btn-info btn2 srch" id="searchclick"> SUBMIT </button>                     
                 </div>
            </div></div>
    </div>      
  </div>
  </section>
<div class="clearfix"></div>
<section class="content" >
<!-- <div class=col-md-8>           -->
  <div class="col-md-6" style="overflow: scroll">
  <!DOCTYPE html>

<style>
thead {color:black;}
tbody {color:black;}
tfoot {color:red;}

table, th, td {
  border: 1px solid black;
}
</style>
</head>

<body>

<table style="width:50%;font-size: 13.5px!important">
 
  <tbody>
   <th>Packet Params</th>
      <th>Packet Values</th>

    <tr>
      <td>Header</td>
      <td ><INPUT TYPE="TEXT"  id="header" NAME="header" SIZE="110"></td>
    </tr>

    <tr>
      <td>IMEI</td>
      <td ><INPUT TYPE="TEXT"  id="imei" NAME="imei" SIZE="110"></td>
    </tr>
     <tr>
      <td>Alert ID</td>
      <td ><INPUT TYPE="TEXT"  id="alert_id" NAME="alert_id" SIZE="110"></td>
    </tr>
     <tr>
      <td>Gps Fix</td>
      <td ><INPUT TYPE="TEXT"  id="gps_fix" NAME="gps_fix" SIZE="110"></td>
    </tr>
    <tr>
      <td>Date</td>
      <td ><INPUT TYPE="TEXT"  id="date" NAME="date" SIZE="110"></td>
    </tr>
   
      <tr>
      <td>Time</td>
      <td><INPUT TYPE="TEXT"  id="time" NAME="time" SIZE="110"></td>
    </tr>
     <tr>
      <td>Device Time</td>
      <td ><INPUT TYPE="TEXT"  id="device_time" NAME="device_time" SIZE="110"></td>
    </tr>
    <tr>
      <td>Packet Status</td>
      <td><INPUT TYPE="TEXT"  id="packet_status" NAME="packet_status" SIZE="110"></td>
    </tr>
    <tr>
      <td>Latitude</td>
      <td ><INPUT TYPE="TEXT"  id="latitude" NAME="latitude" SIZE="110"></td>
    </tr>
    <tr>
      <td>Latitude Dir</td>
      <td ><INPUT TYPE="TEXT"  id="latitude_dir" NAME="latitude_dir" SIZE="110"></td>
    </tr>
    <tr>
      <td>Longitude</td>
      <td><INPUT TYPE="TEXT"  id="long" NAME="long" SIZE="110"></td>
    </tr>
    <tr>
      <td>Longitude  Dir</td>
      <td ><INPUT TYPE="TEXT"  id="long_dir" NAME="long_dir" SIZE="110"></td>
    </tr>
    <tr>
      <td>MCC</td>
      <td ><INPUT TYPE="TEXT"  id="MCC" NAME="MCC" SIZE="110"></td>
    </tr>
    <tr>
      <td>MNC</td>
      <td ><INPUT TYPE="TEXT"  id="MNC" NAME="MNC" SIZE="110"></td>
    </tr>
    <tr>
      <td>LAC</td>
      <td><INPUT TYPE="TEXT"  id="LAC" NAME="LAC" SIZE="110"></td>
    </tr>
    <tr>
      <td>Cell ID</td>
      <td ><INPUT TYPE="TEXT"  id="cell_id" NAME="cell_id" SIZE="110"></td>
    </tr>
      <tr>
      <td>Speed</td>
      <td><INPUT TYPE="TEXT"  id="SPEED" NAME="SPEED" SIZE="110"></td>
    </tr>
      <tr>
      <td>Heading</td>
      <td><INPUT TYPE="TEXT"  id="heading" NAME="heading" SIZE="110"></td>
    </tr>
     <tr>
      <td>No Of Satelites</td>
      <td ><INPUT TYPE="TEXT"  id="no_of_satelites" NAME="no_of_satelites" SIZE="110"></td>
    </tr>
     <tr>
      <td>HDOP</td>
      <td><INPUT TYPE="TEXT"  id="hdop" NAME="hdop" SIZE="110"></td>
    </tr>
     <tr>
      <td>GSM Signal Strength</td>
      <td ><INPUT TYPE="TEXT"  id="gsm_signal_strength" NAME="gsm_signal_strength" SIZE="110"></td>
    </tr>
 
       <tr>
      <td>Ignition</td>
      <td ><INPUT TYPE="TEXT"  id="ignition" NAME="ignition" SIZE="110"></td>
    </tr>
     
      <tr>
      <td>Main Power Status</td>
      <td ><INPUT TYPE="TEXT"  id="main_power_status" NAME="main_power_status" SIZE="110"></td>
    </tr>
     
      <tr>
      <td>Vehicle Mode</td>
      <td ><INPUT TYPE="TEXT"  id="vehicle_mode" NAME="vehicle_mode" SIZE="110"></td>
    </tr>
     <tr>
      <td>key and values</td>
      <td ><INPUT TYPE="TEXT"  id="key" NAME="key" SIZE="110"></td>
    </tr>
    <INPUT TYPE="hidden"  id="comma_seperated" NAME="comma_seperated" SIZE="110">
  </tbody>
  
</table>

<div data-container="button">
   <button   class="button" id="generate" style="float: right;background-color:black;color:white;text-align:center;
height:40px;"> Generate </button>   
</div>        
<br>
<br>
 <textarea   id = "mergedvalue" style="float: right;display:none" rows="5" cols="50">
</textarea> 


</body>
</html>


   
  </div>
</section>


@section('script')
    <script src="{{asset('js/gps/ack-data-list.js')}}"></script>
@endsection
@endsection