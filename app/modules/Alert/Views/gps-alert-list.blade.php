@extends('layouts.eclipse')
@section('title')
All Alerts
@endsection
@section('content')       
<div class="page-wrapper_new"> 
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Alerts</li>
      <b>Alerts</b>
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
                <table class="container">
                 
                  <tbody>
                    <tr>
                      <td class="inner"></td>
                    </tr>
                  </tbody>
                </table>
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
 <style type="text/css">

  .allert{
    background-color: #03ea3569;
  }

@charset "UTF-8";
@import url(https://fonts.googleapis.com/css?family=Open+Sans:300,400,700);

body {
  font-family: 'Open Sans', sans-serif;
  font-weight: 300;
  line-height: 2em;
  color:#A7A1AE;
  background-color:#797979;
}
.container td {
    font-weight: normal;
    font-size: 1em;
  -webkit-box-shadow: 0 2px 2px -2px #0E1119;
     -moz-box-shadow: 0 2px 2px -2px #0E1119;
          box-shadow: 0 2px 2px -2px #0E1119;
}
.container {
    text-align: left;
    overflow: hidden;
    width: 80%;
    margin: 0 auto;
  display: table;
  padding: 0 0 8em 0;
}

.container td {
    padding-bottom: 10%!important;
    padding-top: 10%;
  /*padding-left:10%;  */

}

/* Background-color of the odd rows */
.container tr:nth-child(odd) {
    background-color: #323C50;
}
.container td:first-child { 
  color: #f09b00; 
  font-weight: bold;
}
@media (max-width: 800px) {
.container td:nth-child(4),
.container th:nth-child(4) { display: none; }
}

#alert {
  width:300px;
  height:400px;
  border: 1px solid;
  overflow:scroll;
  margin-left: 10%;
  border-bottom: solid 2px white;
}
#loader {
  display:none;
}
.messages {
  min-height:40px;
  padding: 3% 0 2% 0;
  border-bottom: 2px solid white;
  cursor: pointer;
}
.date {
  font-size:16px;color:#ffffff;

}
 </style>
