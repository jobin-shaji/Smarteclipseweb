@extends('layouts.eclipse')

@section('content')
    <meta name="viewport" content="initial-scale=1.0, 
      width=device-width" />
    <script src="http://js.api.here.com/v3/3.0/mapsjs-core.js" 
      type="text/javascript" charset="utf-8"></script>
    <script src="http://js.api.here.com/v3/3.0/mapsjs-service.js" 
      type="text/javascript" charset="utf-8"></script>
    <script src="http://js.api.here.com/v3/3.0/mapsjs-ui.js" 
      type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" type="text/css" 
      href="http://js.api.here.com/v3/3.0/mapsjs-ui.css" />
      <script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-mapevents.js"></script>


  <div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Playback
        <small>Control panel</small></h4>
           @if(Session::has('message'))
    <div class="pad margin no-print">
      <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
          {{ Session::get('message') }}  
      </div>
    </div>
    @endif  

            </div>
        </div>
    </div>
    <div class="container-fluid">
    <div class="card-body">
        <div class="table-responsive">
            <div id="zero_config_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
              <div class="row">
                <div class="col-sm-12">    

<input type="hidden" name="vid" id="vehicle_id" value="{{$Vehicle_id}}">
<section class="content box">
  <div class="row">
    <div class="col-lg-12 col-sm-12">


              <div class="col-md-8">      
         <div class="panel-heading">
                   <label> From Date</label>
                  <input type="text" class="datetimepicker" id="fromDate" name="fromDate">
                  <label> To date</label>
                  <input type="text" class="datetimepicker" id="toDate" name="toDate">

                  <button class="btn btn-xs btn-info" onclick="playback()"> <i class="fa fa-filter"></i> Playback </button>                 
              </div>  
              </div>             
             <div id="mapContainer" style="width:100%;height:500px;"></div>
        <!-- <div id="map" style="width:100%;height:500px;"></div> -->
    </div>
    <div class="iconsbg12345">
               <div class="row">
                  <div class="card card-hover" style="width:100%;-webkit-box-shadow: 1px 1px 2px 3px #ccc;
                     -moz-box-shadow: 1px 1px 2px 3px #ccc;
                     box-shadow: 1px 1px 21px 1px #ccc">
                     <div class="col-8 m-t-15">
                        <div class="bg-dark p-10 text-white text-center" style="float: left;width:50%;border-radius: 20px 0 0 0;" >
                           <img src="assets/images/network-status.png">
                            <h4 class="m-b-0 m-t-5">Network Status</h4>
                             <medium id="network_status" class="font-light">
                              <i class="fa fa-spinner" aria-hidden="true"></i>

                        </div>
                     <!-- <div id="linechart" style="width: 900px; height: 500px"></div> -->
                       
                        
                     
                     
                        
                    
                     </div>
                  </div>
               </div>
            </div>
    </div>
</section>
</div>                
              </div>
            <div class="row"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

@section('script')

<script src="{{asset('js/gps/ui.js')}}"></script>
<script src="{{asset('js/gps/location-playback-hmap.js')}}"></script>

@endsection

@endsection