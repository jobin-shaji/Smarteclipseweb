@extends('layouts.eclipse')
@section('title')
    Assign Servicer
@endsection
@section('content')
<div class="page-wrapper page-wrapper-root page-wrapper_new">
<div class="page-wrapper-root1">
          
      <div class="container-fluid">                    
        <div class="card-body">
          <div class="table-responsive">
              <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4" style=" background-color: white">

                <div style="width:800px; height:600px; padding:20px; text-align:center; border: 10px solid #787878">
              
                  <div style="width:750px; height:550px; padding:20px;  border: 5px solid #787878">
                     <span style="font-size:10px; font-weight:bold; text-align:right;">SUB DEALER/OEM ICON</span>
                         <span style="font-size:30px; font-weight:bold;text-align:center;">INSTALLATION CERTIFICATE</span>
                         <br><br>
                         <span style="font-size:25px"><i>This is to certify that</i></span>
                         <br><br>
                         <!-- <span style="font-size:30px"><b>$student.getFullName()</b></span><br/><br/> -->
                         <span style="font-size:15px"><i>Dear Sir,<br/><br/><br/>
                          Sub: Installation of Smart Eclipse Manufactured by VST Mobility solutions, Kochi<br/><br/><br/>
                          Ref:ARAI certification number<br/><br/><br/>
                          We VST Mobility Solution/SUB Dealer name , manufacturers/Dealers of AIS 140 ARAI certified GPS solutions hereby confirm that we have completed the installation of GPS device for the following vehicle as mentioned below,
                          </i></span> <br/><br/>
                         <span style="font-size:30px">$course.getName()</span> <br/><br/>
                         <span style="font-size:20px">with score of <b>$grade.getPoints()%</b></span> <br/><br/><br/><br/>
                         <span style="font-size:25px"><i>dated</i></span><br>
                        #set ($dt = $DateFormatter.getFormattedDate($grade.getAwardDate(), "MMMM dd, yyyy"))
                        <span style="font-size:30px">$dt</span>
                  </div>
                  </div>

               
        </div>
        
      </div>
    </div>            
  </div>
</div>

<div class="clearfix"></div>

@endsection
 