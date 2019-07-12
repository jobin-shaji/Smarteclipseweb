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
      <div class="page-breadcrumb route_breadcumb">
         <div class="row">
           
            <div class="col-lg-8">
     
                  <div style="float:left!important">
                   <div class="form-group">
                     
                     <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" placeholder="Add fence name" name="name" id="name" value="" required> 
                  </div>
               </div>
<div style="float:left!important">
                  <div class="form-group">  
                     <button class="btn btn-xs btn-info form-control" id="savebutton"> <i class="fa fa-filter" style="height:23px;"></i> SAVE FENCE</button>                                
                  </div>
                  </div>
                               <div style="float:left!important;margin:0 0 0 3%">   
<div class="form-group">
                           <form onsubmit="return locationSearch();">
                           <input type="text" class="form-control" placeholder="Search Place" name="place_name" id="search_place" value="" required>  </form>
                          </div>
                       </div>
<div style="float:left!important">
                           <div class="form-group">  
                           <button class="btn btn-xs btn-info form-control" id="search_location" typle="submit"> <i class="fa fa-filter" style="height:23px;"></i> SEARCH</button>                                
                        </div>
                      </div> 
                    </div> 
                     <div class="col-lg-4 d-flex no-block align-items-center" style="text-align:right;">
               <h4 class="page-title">Please plot points on the map to create geo fence</h4>
            </div>   
   </div>
                      

              

               </div>   
             </div>
         </div>


      </div>
      </div>


     
         <div id="map" style=" width:100%;height:540px;"></div>
   </div>
</section>
@section('script')
<script src="{{asset('js/gps/geofence.js')}}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDl9Ioh5neacm3nsLzjFxatLh1ac86tNgE&libraries=drawing,places&callback=initMap"
   async defer></script>
@endsection
@endsection