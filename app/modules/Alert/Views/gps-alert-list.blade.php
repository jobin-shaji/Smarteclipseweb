@extends('layouts.eclipse')
<style>
  body {font-family:Arial;}
#alert {width:550px;height:400px;border: 1px solid;overflow:scroll}
#loader {display:none;}
.messages {min-height:40px;border-bottom:1px solid #1f1f1f;}
.date {font-size:11px;color:#1f1f1f;}

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
              <div id="alert">
            <!--Loading ANIMATION-->
              <img id="loader" src='http://opengraphicdesign.com/wp-content/uploads/2009/01/loader64.gif'>        
            <!--END LOADING ANIMATION-->                
                <div class='inner'>
                     <!-- WHERE YOU WILL LOAD CONTENT -->
                </div> 

               </div>
            </div>
            <div class="col-sm-6">
            <input type="hidden" id="lat" name="lat" value="{{$client->latitude}}">
            <input type="hidden" id="lng" name="lng" value="{{$client->longitude}}">    
            <div class="col-md-12 full-height">
                <div id="map" style="width:100%; height:400px;"></div>
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </div>               
  </div>            
</div>
@section('script')
<script async defer
   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAyB1CKiPIUXABe5DhoKPrVRYoY60aeigo&callback=initMap"></script>
<script src="{{asset('js/gps/gps-alert.js')}}"></script>

 @endsection
 @endsection