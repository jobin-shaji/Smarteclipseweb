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
                         
                        </div>
                     </section>
                  </div>
               </div>
               <div class="row"></div>
            </div>
         </div>
      </div>
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
<script src="{{asset('js/gps/location-playback-hmap.js')}}"></script>
@endsection
@endsection