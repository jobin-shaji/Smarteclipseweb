@extends('layouts.eclipse')
@section('title')
  View Geofence
@endsection
@section('content')

<!-- ============================================================== -->
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="page-wrapper_new_map">
  <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Geofence View</li>
     </ol>
     @if(Session::has('message'))
          <div class="pad margin no-print">
            <div class="callout {{ Session::get('callout-class', 'callout-success') }}" style="margin-bottom: 0!important;">
                {{ Session::get('message') }}  
            </div>
          </div>
        @endif 
    </nav>
 
            
              <input type="hidden" name="hd_id" id="g_id" value="{{$id}}">
              <div class="card geofence data_list_cover pull-right" style="width: 16rem;">
                    <div class="card-body data_list_body">                 
                     <div class="cover_ofline"><b>
                        <div class="col-sm-12 social-buttons">
                            <a class="btn btn-block btn-social btn-bitbucket track_item">
                                <i >name :</i><label id="geofence_name"></label></a>

                            <a class="btn btn-block btn-social btn-bitbucket track_item">
                                <i >created By :</i> <b><label id="user"></label></b>
                            </a>
                             <a class="btn btn-block btn-social btn-bitbucket track_item">
                                <i >created At :</i> <b><label id="created_date"></label></b>
                            </a>
                        </div>
                      </b>
                    </div>
                  </div>
                         
                  </div>

           
              <div id="map" style=" width:100%;height:520px; margin-top: 10px;"></div>

</div>
@endsection

  @section('script')
    <script src="{{asset('js/gps/geofence-details.js')}}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDl9Ioh5neacm3nsLzjFxatLh1ac86tNgE&libraries=drawing&callback=initMap"
         async defer></script>
  @endsection