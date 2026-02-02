@extends('layouts.eclipse')

@section('content')

<section class="hilite-content">
      <!-- title row -->     
  <div class="row">
    <div class="panel-body" style="width: 100%;min-height: 10%">
      <div class="panel-heading">
        <div>
         <div class="row">
         <div class="col-lg-3 col-md-3"> 
         <div class="form-group" style="margin-left: 20%;margin-top: 2%;">
          <label> NRM PACKET</label>  <br>
           <p style="margin-top: 16%;margin-bottom: -3rem">Packet :-</p><textarea rows="4"  id="packetvalue"  cols="50" style="width: 70%!important;margin-left: 23%;margin-bottom: 3.5rem">
             </textarea>
               <button class="btn btn-info btn2 srch" id="searchclick" style="float:right;padding: 0!important;margin-right: -30%;margin-top: 10%"> SUBMIT </button>                     
               </div>
            </div>
         </div>
    </div>      
  </div>
  
<table class="greyGridTable" ><!-- style="width:50%;font-size: 13.5px!important" -->
 <tbody>
   <th>Packet Params</th>
      <th>Packet Values</th>

    <tr>
      <td> Header</td>
      <td> <INPUT TYPE="TEXT"  id="headernew" NAME="name" SIZE="40"></td>
    </tr>

    <tr>
      <td>IMEI</td>
      <td ><INPUT TYPE="TEXT"  id="imei" NAME="imei" SIZE="40"></td>
    </tr>
    <tr>
      <td>Date</td>
      <td><INPUT TYPE="TEXT"  id="date" NAME="date" SIZE="40"></td>
    </tr>
    <tr>
      <td>Alert ID</td>
      <td><INPUT TYPE="TEXT"  id="code" NAME="name" SIZE="40"></td>
    </tr>
      <tr>
      <td>Time</td>
      <td><INPUT TYPE="TEXT"  id="time" NAME="name" SIZE="40"></td>
    </tr>
     <tr>
      <td>Device Time</td>
      <td><INPUT TYPE="TEXT"  id="device_time" NAME="name" SIZE="40"></td>
    </tr>
     <tr>
      <td>GPS  Fix</td>
      <td><INPUT TYPE="TEXT"  id="gps_fix" NAME="name" SIZE="40"></td>
    </tr>
    <tr>
      <td>Packet Status</td>
      <td ><INPUT TYPE="TEXT"  id="packet_status" NAME="name" SIZE="40"></td>
    </tr>
    <tr>
      <td>Latitude</td>
      <td><INPUT TYPE="TEXT"  id="latitude" NAME="name" SIZE="40"></td>
    </tr>
    <tr>
      <td>Latitude Dir</td>
      <td><INPUT TYPE="TEXT"  id="latitude_dir" NAME="name" SIZE="40"></td>
    </tr>
    <tr>
      <td>Longitude</td>
      <td><INPUT TYPE="TEXT"  id="long" NAME="name" SIZE="40"></td>
    </tr>
    <tr>
      <td>Longitude  Dir</td>
      <td><INPUT TYPE="TEXT"  id="long_dir" NAME="name" SIZE="40"></td>
    </tr>
    <tr>
      <td>MCC</td>
      <td><INPUT TYPE="TEXT"  id="MCC" NAME="MCC" SIZE="40"></td>
    </tr>
    <tr>
      <td>MNC</td>
      <td><INPUT TYPE="TEXT"  id="MNC" NAME="MNC" SIZE="40"></td>
    </tr>
    <tr>
      <td>LAC</td>
      <td><INPUT TYPE="TEXT"  id="LAC" NAME="LAC" SIZE="40"></td>
    </tr>
    <tr>
      <td>CELL ID</td>
      <td><INPUT TYPE="TEXT"  id="cell_id" NAME="cell_id" SIZE="40"></td>
    </tr>
      <tr>
      <td>SPEED</td>
      <td><INPUT TYPE="TEXT"  id="SPEED" NAME="SPEED" SIZE="40"></td>
    </tr>
      <tr>
      <td>HEADING</td>
      <td><INPUT TYPE="TEXT"  id="heading" NAME="heading" SIZE="40"></td>
    </tr>
     <tr>
      <td>No Of Satelites</td>
      <td><INPUT TYPE="TEXT"  id="no_of_satelites" NAME="no_of_satelites" SIZE="40"></td>
    </tr>
     <tr>
      <td>HDOP</td>
      <td ><INPUT TYPE="TEXT"  id="hdop" NAME="hdop" SIZE="40"></td>
    </tr>
     <tr>
      <td>GSM Signal Strength</td>
      <td ><INPUT TYPE="TEXT"  id="gsm_signal_strength" NAME="gsm_signal_strength" SIZE="40"></td>
    </tr>
 
       <tr>
      <td>Ignition</td>
      <td ><INPUT TYPE="TEXT"  id="ignition" NAME="ignition" SIZE="40"></td>
    </tr>
     
      <tr>
      <td>Main Power Status</td>
      <td ><INPUT TYPE="TEXT"  id="main_power_status" NAME="main_power_status" SIZE="40"></td>
    </tr>
     
      <tr>
      <td>Vehicle Modexx</td>
      <td ><INPUT TYPE="TEXT"  id="vehicle_mode" NAME="vehicle_mode" SIZE="40"></td>
       
    </tr>
    
  </tbody>
  
</table>
</div>
</div>

  <div class="row">
       <div class="panel-body" style="width: 100%;min-height: 10%">
         <div class="panel-heading">
            <div>
             <div class="row">
             <div class="col-lg-3 col-md-3"> 
             <div class="form-group" style="margin-left: 180%;margin-top: 2%;">
              <button   class="button" id="generate" style="float: right;background-color:black;color:white;text-align:center;height:40px;"> Generate </button>
             </div>
              <textarea   id = "mergedvalue" style="margin-left: 180%;margin-top: 2%;display:none" rows="4" cols="50"></textarea> 
              </div>
           </div>
         </div>      
       </div>
    </div>
  </div>
</section>

<div class="clearfix"></div>
<section class="content" >
<!-- <div class=col-md-8>           -->
  <div class="col-md-6" style="overflow: scroll">
  <!DOCTYPE html>

<style>
table.greyGridTable {
  border: 2px solid #cccccc;
  width: 20%;
  border-collapse: collapse;
  margin-left: 40%;
  margin-top:-12%;
}
table.greyGridTable td, table.greyGridTable th {
  border: 1px solid #FFFFFF;
  padding: 3px 4px;
}
table.greyGridTable tbody td {
  font-size: 13px;
}
table.greyGridTable td:nth-child(even) {
  background: #EBEBEB;
}
table.greyGridTable thead {
  background: #FFFFFF;
  border-bottom: 4px solid #333333;
}
table.greyGridTable thead th {
  font-size: 15px;
  font-weight: bold;
  color: black;
  text-align: center;
  border-left: 2px solid #333333;
}
table.greyGridTable thead th:first-child {
  border-left: none;
}
[data-container="button"] {
  position: absolute;
  top: 160%;
  text-align: left;
  width: 100%;
}


</style>
</head>
</html>
 </div>
</section>


@section('script')
    <script src="{{asset('js/gps/packet-data-list.js')}}"></script>
@endsection
@endsection