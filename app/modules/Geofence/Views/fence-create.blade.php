@extends('layouts.eclipse')
@section('title')
Create Geofence
@endsection
@section('content')   
@if(Session::has('message'))
<div class="pad margin no-print">
   <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
      {{ Session::get('message') }}  
   </div>
</div>
@endif  
<section class="hilite-content">
   <!-- title row -->
   <div class="page-wrapper_new_map">
      <!-- ============================================================== -->
      <!-- Bread crumb and right sidebar toggle -->
      <!-- ============================================================== -->
      <div class="page-breadcrumb">
         <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
               <h4 class="page-title">Create Geofence</h4>
            </div>
         </div>
      </div>
      <div class="card-body map_card_body">
        <div class="panel-heading playback_head">
         <div class="cover_div_search playback_page fencepage_head">
            <div class="row">
               <div class="col-lg-8 col-md-12">
                  <div class="form-group">
                     
                     <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Add fence name" name="name" id="name" value="" required> 
                  </div>
                  @if ($errors->has('name'))
                  <span class="help-block">
                  <strong class="error-text">{{ $errors->first('name') }}</strong>
                  </span>
                  @endif
               </div>
               <div class="col-lg-4 col-md-12">
                  <div class="form-group">  
                     <button class="btn btn-xs btn-info form-control btn-play-back" id="savebutton"> <i class="fa fa-filter" style="height:23px;"></i>SAVE FENCE</button>                                
                  </div>
               </div>
            </div>
         </div>
         </div>



         <div id="map" style=" width:100%;height:540px;"></div>
      </div>
      <footer class="footer text-center">
         All Rights Reserved by VST Mobility Solutions. Designed and Developed by <a href="http://vstmobility.com">VST</a>.
      </footer>
   </div>
</section>
@section('script')
<script src="{{asset('js/gps/geofence.js')}}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDl9Ioh5neacm3nsLzjFxatLh1ac86tNgE&libraries=drawing&callback=initMap"
   async defer></script>
@endsection
@endsection