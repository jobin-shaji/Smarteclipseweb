@extends('layouts.eclipse')
<style>
  body {font-family:Arial;}
#chatBox {width:550px;height:500px;border: 1px solid;overflow:scroll}
#loader {display:none;}
.messages {min-height:40px;border-bottom:1px solid #1f1f1f;}
.date {font-size:9px;color:#1f1f1f;}

  </style>
@section('title')
All Alerts
@endsection
@section('content')       
<div class="page-wrapper_new"> 
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Alerts </li>
    </ol>
    @if(Session::has('message'))
      <div class="pad margin no-print">
        <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
          {{ Session::get('message') }}  
        </div>
      </div>
    @endif 
  </nav>
  <div class="container-fluid">
    <div class="card-body">
      <div class="table-responsive">
        <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">          
          <div class="row">
            <div class="col-sm-6">
              <div class="panel-heading">
               
              </div>

              <div id="chatBox">
            <!--Loading ANIMATION-->
            <img id="loader" src='http://opengraphicdesign.com/wp-content/uploads/2009/01/loader64.gif'>
            <!--END LOADING ANIMATION-->
                
                <!-- <div class='inner'> -->
                    <!-- WHERE YOU WILL LOAD CONTENT-->
                <!-- </div> -->
           
              <table   class="table table-hover table-bordered  table-striped datatable" style="width:50%" >
                <thead>
                  <tr>
                    <th>Sl.No</th>
                    <th>Alert</th>
                    <th>Vehicle Name</th>
                    <th>Register Number</th>
                    <!-- <th>Location</th> -->
                    <th>DateTime</th> 
                    <!-- <th>Action</th>                  -->
                  </tr>
                </thead>

                <tbody >
                  <tr class="inner">
                  </tr>
                </tbody>
              </table>
               </div>
             <!-- {{ $alerts->appends(['sort' => 'votes'])->links() }} -->
                         <!-- ============================================================== -->   
            </div>
            <div class="col-sm-6">
            <input type="text" id="lat" name="lat" value="{{$client->latitude}}">
            <input type="text" id="lng" name="lng" value="{{$client->longitude}}">             
              <div id="map" style=" width:100%;"></div>  
            </div>
            
          </div>
        </div>
      </div>
    </div>               
  </div>            
</div>

@section('script')
<script src="{{asset('js/gps/gps-alert.js')}}"></script>
<script async defer
   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAyB1CKiPIUXABe5DhoKPrVRYoY60aeigo&libraries=places&callback=initMap"></script>
 @endsection
 @endsection