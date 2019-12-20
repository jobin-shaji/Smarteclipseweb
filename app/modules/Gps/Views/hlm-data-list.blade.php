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
                <label> HLM PACKET</label>  
                <textarea rows="4"  id="packetvalue"  cols="50">

                  </textarea>
                      <button class="btn btn-sm btn-info btn2 srch" id="searchclick"> SUBMIT </button>                     
               <!-- <input type="textarea" id="packetvalue" name="packetdata"><br> -->
              </div>
            </div>

        <!--  <div class="col-lg-3 col-md-3"> 
           <div  style ="margin-left: 77px"class="form-group has-feedback">        
          <button class="btn btn-sm btn-info btn2 srch" id="searchclick"> <i class="fa fa-search"></i> </button>
      </div>
        </div>  -->                       
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
thead {color:black;}
tbody {color:black;}
tfoot {color:red;}

table, th, td {
  border: 1px solid black;
}
</style>
</head>

<body>

<table style="width:60%;font-size: 13.5px!important">
 
  <tbody>
   <th>Packet Params</th>
  <th>Packet Values</th>

    <tr>
      <td>Header</td>
      <td><INPUT TYPE="TEXT"  id="header" NAME="header" SIZE="110"></td>
    </tr>

    <tr>
      <td>IMEI</td>
      <td><INPUT TYPE="TEXT"  id="imei" NAME="imei" SIZE="110"></td>
    </tr>
    
    <tr>
      <td>Date</td>
      <td><INPUT TYPE="TEXT"  id="date" NAME="date" SIZE="110"></td>
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
      <td>Vendor ID</td>
      <td><INPUT TYPE="TEXT"  id="vendor_id" NAME="vendor_id" SIZE="110"></td>
    </tr>
    <tr>
      <td>Firmware Version</td>
      <td ><INPUT TYPE="TEXT"  id="firmware_version" NAME="firmware_version" SIZE="110"></td>
    </tr>
    <tr>
      <td>update rate - Ignition ON</td>
      <td><INPUT TYPE="TEXT"  id="update_rate_ignition_on" NAME="update_rate_ignition_on" SIZE="110"></td>
    </tr>
   
      <tr>
      <td>update rate - Ignition OFF</td>
      <td ><INPUT TYPE="TEXT"  id="update_rate_ignition_off" NAME="update_rate_ignition_off" SIZE="110"></td>
    </tr>
   
  <tr>
      <td>Battery Percentage</td><td><INPUT TYPE="TEXT"  id="battery_percentage" NAME="battery_percentage" SIZE="110"></td>
    </tr>
   
    <tr>
      <td>Low Battery Threshold Value</td>
      <td><INPUT TYPE="TEXT"  id="low_battery_threshold_value" NAME="low_battery_threshold_value" SIZE="110"></td>
    </tr>
   
    <tr>
      <td>Memory percentage</td>
      <td><INPUT TYPE="TEXT"  id="memory_percentage" NAME="memory_percentage" SIZE="110"></td>
    </tr>
   
    <tr>
      <td>Digital I/O status</td>
      <td><INPUT TYPE="TEXT"  id="digital_io_status" NAME="digital_io_status" SIZE="110"></td>
    </tr>
    <tr>
      <td>Analog Input Status</td>
      <td><INPUT TYPE="TEXT"  id="analog_io_status" NAME="analog_io_status" SIZE="110"></td>
    </tr>
    
  </tbody>
  
</table>

 <div data-container="button">
   <button   class="button" id="generate" style="float: right;background-color:black;color:white;text-align:center;
height:40px;"> Generate </button>   
</div>        
<br>
<br>
 <textarea   id = "mergedvalue" style="float: right;display:none" rows="4" cols="50">
</textarea> 

</body>
</html></div>
</section>


@section('script')
    <script src="{{asset('js/gps/hlm-data-list.js')}}"></script>
@endsection
@endsection