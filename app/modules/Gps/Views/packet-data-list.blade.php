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
  

<div class="modal fade" id="gpsDataModal" tabindex="-1" role="dialog" aria-labelledby="favoritesModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="padding: 25px">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>        
      </div>
      <div class="modal-body">       
      <div class="row">
       <table border=1 id="allDataTable" class="table table-bordered" >
        
      
       </table> 
     
      </div>
      <div class="modal-footer">
        <span class="pull-center">
          
        </span>
      </div>
    </div>
  </div>
</div>
</div>
<form method="POST">
<table class="greyGridTable" ><!-- style="width:50%;font-size: 13.5px!important" -->
 
  <tbody>
   <th>Packet Params</th>
      <th>Packet Values</th>

    <tr>
      <td>  <INPUT TYPE="TEXT"  id="headernew" NAME="name" SIZE="40"></td>
    </tr>

    <tr>
      <td>IMEI</td>
      <td id="imei"><INPUT TYPE="TEXT"  id="headernew" NAME="name" SIZE="40"></td>
    </tr>
    <tr>
      <td>Date</td>
      <td id="date"><INPUT TYPE="TEXT"  id="headernew" NAME="name" SIZE="40"></td>
    </tr>
    <tr>
      <td>Alert ID</td>
      <td id="code"><INPUT TYPE="TEXT"  id="headernew" NAME="name" SIZE="40"></td>
    </tr>
      <tr>
      <td>Time</td>
      <td id="time"><INPUT TYPE="TEXT"  id="headernew" NAME="name" SIZE="40"></td>
    </tr>
     <tr>
      <td>Device Time</td>
      <td id="device_time"><INPUT TYPE="TEXT"  id="headernew" NAME="name" SIZE="40"></td>
    </tr>
     <tr>
      <td>GPS  Fix</td>
      <td id="gps_fix"><INPUT TYPE="TEXT"  id="headernew" NAME="name" SIZE="40"></td>
    </tr>
    <tr>
      <td>Packet Status</td>
      <td id="packet_status"><INPUT TYPE="TEXT"  id="headernew" NAME="name" SIZE="40"></td>
    </tr>
    <tr>
      <td>Latitude</td>
      <td id="latitude"><INPUT TYPE="TEXT"  id="headernew" NAME="name" SIZE="40"></td>
    </tr>
    <tr>
      <td>Latitude Dir</td>
      <td id="latitude_dir"><INPUT TYPE="TEXT"  id="headernew" NAME="name" SIZE="40"></td>
    </tr>
    <tr>
      <td>Longitude</td>
      <td id="long"><INPUT TYPE="TEXT"  id="headernew" NAME="name" SIZE="40"></td>
    </tr>
    <tr>
      <td>Longitude  Dir</td>
      <td id="long_dir"><INPUT TYPE="TEXT"  id="headernew" NAME="name" SIZE="40"></td>
    </tr>
    <tr>
      <td>MCC</td>
      <td id="MCC"><INPUT TYPE="TEXT"  id="headernew" NAME="name" SIZE="40"></td>
    </tr>
    <tr>
      <td>MNC</td>
      <td id="MNC"><INPUT TYPE="TEXT"  id="headernew" NAME="name" SIZE="40"></td>
    </tr>
    <tr>
      <td>LAC</td>
      <td id="LAC"><INPUT TYPE="TEXT"  id="headernew" NAME="name" SIZE="40"></td>
    </tr>
    <tr>
      <td>CELL ID</td>
      <td id="cell_id"><INPUT TYPE="TEXT"  id="headernew" NAME="name" SIZE="40"></td>
    </tr>
      <tr>
      <td>SPEED</td>
      <td id="SPEED"><INPUT TYPE="TEXT"  id="headernew" NAME="name" SIZE="40"></td>
    </tr>
      <tr>
      <td>HEADING</td>
      <td id="heading"><INPUT TYPE="TEXT"  id="headernew" NAME="name" SIZE="40"></td>
    </tr>
     <tr>
      <td>No Of Satelites</td>
      <td id="no_of_satelites"><INPUT TYPE="TEXT"  id="headernew" NAME="name" SIZE="40"></td>
    </tr>
     <tr>
      <td>HDOP</td>
      <td id="hdop"><INPUT TYPE="TEXT"  id="headernew" NAME="name" SIZE="40"></td>
    </tr>
     <tr>
      <td>GSM Signal Strength</td>
      <td id="gsm_signal_strength"></td>
    </tr>
 
       <tr>
      <td>Ignition</td>
      <td id="ignition"></td>
    </tr>
     
      <tr>
      <td>Main Power Status</td>
      <td id="main_power_status"></td>
    </tr>
     
      <tr>
      <td>Vehicle Mode</td>
      <td id="vehicle_mode"></td>
    </tr>
    
  </tbody>
  
</table>
</form>

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



</style>
</head>

<body>





</body>
</html>


   
  </div>
</section>


@section('script')
    <script src="{{asset('js/gps/packet-data-list.js')}}"></script>
@endsection
@endsection