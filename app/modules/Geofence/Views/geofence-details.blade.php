@extends('layouts.eclipse')
@section('title')
  View Geofence
@endsection
@section('content')

<!-- ============================================================== -->
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper_new_map">
  <!-- ============================================================== -->
  <!-- Bread crumb and right sidebar toggle -->
  <!-- ============================================================== -->
  <div class="page-breadcrumb">
      <div class="row">
          <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">Geofence View</h4>
            
          </div>
      </div>
  </div>
  <!-- ============================================================== -->
  <!-- End Bread crumb and right sidebar toggle -->
  <!-- ============================================================== -->
  <!-- ============================================================== -->
  <!-- Container fluid  -->
  <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
 
                        
         
            
              <input type="hidden" name="hd_id" id="hd_id" value="{{$id}}">
              <div id="map" style=" width:100%;height:520px; margin-top: 10px;"></div>
       


       <footer class="footer text-center">
         All Rights Reserved by VST Mobility Solutions. Designed and Developed by <a href="http://vstmobility.com">VST</a>.
      </footer>
  
                
 

</div>
@endsection

  @section('script')
    <script src="{{asset('js/gps/geofence-details.js')}}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDl9Ioh5neacm3nsLzjFxatLh1ac86tNgE&libraries=drawing&callback=initMap"
         async defer></script>
  @endsection