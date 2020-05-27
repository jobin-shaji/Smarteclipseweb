
<style type="text/css">
  table td, table th{
    border:1px solid black;
  }
</style>
<div>
  <div>
    <span style="float:left"><h2>Vehicle Daily Trip Report</h2></span>
    <span style="float:right;margin-top:30px"><img src="assets/images/smart_eclipse_logo.png" alt="Logo" height="30px" width="150px"></span>
  </div>    
</div>
<br/>
<div>
  <div style="margin-top:5%!important;floar:left">
    <p>{{$gps->vehicle->client->name}}</p>
    <span style="width:50%;float:left"><p>{{$gps->vehicle->client->address}}</p></span>
    <span style="float:right;width:35%"><p><b>Trip Date</b></p>{{$date}}</span>
  </div>
  <br/>
</div>
<div><br/>
  <div style="margin-top:5%!important;floar:left">
    <span style="width:50%;float:left"><p><b>Vehicle Name</b></p>{{$gps->vehicle->name}}</span>
    <span style="float:right;width:35%"><p><b>Device IMEI</b></p>{{maskPartsOfString($gps->imei,2,10)}} </span>
  </div>
  <br/>
</div>
<div>
  <div style="margin-top:10%!important;floar:left">
    <span style="margin-left:0%;float:left"><p><b>Vehicle Registration Number</b></p>{{$gps->vehicle->register_number}}</span>
    <span style="float:left;margin-left:37%"><p><b>Device Serial Number</b></p>{{maskPartsOfString($gps->serial_no,4,15)}}</span>
  </div>
</div>
<div>
  <div style="margin-top:18%!important;floar:left">
    <span style="float:left"><p><b>Driver Name</b></p>{{$gps->vehicle->driver?$gps->vehicle->driver->name:'Driver'}} </span>
    <?php $dt = (isset($gps->vehicleGps->gps_fitted_on))?date('Y-m-d',strtotime($gps->vehicleGps->gps_fitted_on)):''; ?>
    <span style="float:right;margin-right: 13%"><p><b>Device Installed Date</b></p>{{$dt}}2020-05-06</span>
  </div>
  <br/>
</div>
<!---Table starts-->
<div><br/>
  <p style="margin-top: 23%;text-align:center"><b>Report Summary</b></p>
  <table border="1" cellspacing="0" cellpadding="5px" style="width:100%;">
    <tr>
      <th>Start location</th>
      <th>End location</th>
      <th>Start Date</th>
      <th>End Date</th>
      <th>Trip Duration</th>
      <th>Distance</th>
    </tr>
    <tr>
      <td>{{$summary["on location"]}}</td>
      <td>{{$summary["off location"]}}</td>
      <td>{{$summary["on"]}}</td>
      <td>{{$summary["off"]}}</td>
      <td>{{$summary["duration"]}}</td>
      <td>{{$summary["km"]}}</td>  
    </tr>
  </table>

  <p style="text-align:center"><b>Report Details</b></p>
  <table border="1" cellspacing="0" cellpadding="5px" style="width: 100%">
    <tr>
      <th>SL.No</th>
      <th>Ignition On Time</th>
      <th>Location</th>
      <th>Ignition Off Time</th>
      <th>Location</th>
      <th>Running Duration</th>
      <th>Distance</th>
    </tr>
    @foreach($trips as $trip)
    <tr>
      <td>{{$loop->iteration}}</td>
      <td>{{$trip["start_time"]}}</td>
      <td>{{$trip["start_address"]}}</td>
      <td>{{$trip["stop_time"]}}</td>
      <td>{{$trip["stop_address"]}}</td>
      <td>{{$trip["duration"]}}</td>    
      <td>{{$trip["distance"]}}</td>    
    </tr>
    @endforeach
  </table>
  Note: Since running duration is calculated based on the vehicle movement, it can be less than or equal to trip duration.
  <br>
  <?php
    if($gps->refurbished_status == 1)
    {
        echo "...";  
    }
  ?>
</div>
<!---Table ends-->