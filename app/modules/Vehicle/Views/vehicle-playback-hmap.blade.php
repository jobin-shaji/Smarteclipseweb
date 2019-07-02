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
<div class="page-wrapper_new_map">
   <div class="page-breadcrumb">
      <div class="row">
         <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Playback
               <small>Control panel</small>
            </h4>
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
      <input type="hidden" name="vid" id="vehicle_id" value="{{$Vehicle_id}}">
      <div class="card-body map_card_body">
          <div class="panel-heading playback_head">
           <div class="col-lg-12 col-md-3">
             <div class="cover_div_search playback_page">
                <div class="row">
                   <div class="col-lg-4 col-md-3">
                      <div class="form-group">
                         <label> From Date</label>
                         <input type="text" class="datetimepicker form-control" id="fromDate" name="fromDate">
                      </div>
                   </div>

                   <div class="col-lg-4 col-md-3">
                      <div class="form-group">                    
                         <label> To date</label>
                          <input type="text" class="datetimepicker form-control" id="toDate" name="toDate">
                      </div>
                   </div>

                   <div class="col-lg-3 col-md-3 pt-3 ">
                      <div class="form-group">  
                         <button class="btn btn-sm btn-info form-control btn-play-back" onclick="playback()"> <i class="fa fa-filter" style="height:23px;"></i>Playback </button>                                
                      </div>
                   </div>

                </div>
             </div>
             </div>
             <div id="chartContainer" class="playback_chart" style="height: 300px; width: 100%;"></div>
          </div>
          <div id="mapContainer" style="width:100%;height:500px;"></div>
          


      </div>
  
    <!-- ============================================================== -->
    <!-- footer -->
    <!-- ============================================================== -->
    <footer class="footer text-center">
        All Rights Reserved by VST Mobility Solutions. Designed and Developed by <a href="https://wrappixel.com">VST</a>.
    </footer>
    <!-- ============================================================== -->
    <!-- end footer -->
    <!-- ============================================================== -->
</div>
@section('script')
<script src="{{asset('js/gps/ui.js')}}"></script>
<script src="{{asset('js/canvasjs.min.js')}}"></script>
<script src="{{asset('js/gps/location-playback-hmap.js')}}"></script>

@endsection
@endsection