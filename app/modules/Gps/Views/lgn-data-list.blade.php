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
                <label> LGN PACKET</label>  
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
          <!-- <button type="button" class="btn btn-primary btn-lg btn-block">
            SET OTA
          </button> -->
        </span>
      </div>
    </div>
  </div>
</div>
</div>
<div class="modal fade" id="gpsHLMDataModal" tabindex="-1" role="dialog" aria-labelledby="favoritesModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="padding: 25px">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>        
      </div>
      <div class="modal-body">       
      <div class="row">
       <table border=1 id="allHLMDataTable" class="table table-bordered" >
        
      
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
      <td>Activation Key</td>
      <td><INPUT TYPE="TEXT"  id="activationKey" NAME="activationKey" SIZE="110"></td>
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
      <td><INPUT TYPE="TEXT"  id="device_time" NAME="device_time" SIZE="110"></td>
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
      <td><INPUT TYPE="TEXT"  id="long_dir" NAME="long" SIZE="110"></td>
    </tr>
   
      <tr>
      <td>Speed</td>
      <td><INPUT TYPE="TEXT"  id="SPEED" NAME="SPEED" SIZE="110"></td>
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
</html>
</div>
</section>


@section('script')
    <script src="{{asset('js/gps/lgn-data-list.js')}}"></script>
@endsection
@endsection