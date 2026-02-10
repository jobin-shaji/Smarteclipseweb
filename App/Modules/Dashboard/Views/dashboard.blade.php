@extends('layouts.eclipse')
@section('content')

<!--  -->
@include('Dashboard::partials.dashboard-root')
@include('Dashboard::partials.dashboard-dealer')
@include('Dashboard::partials.dashboard-operations')
@include('Dashboard::partials.dashboard-sub-dealer')
@include('Dashboard::partials.dashboard-trader')
@include('Dashboard::partials.dashboard-servicer')
@include('Dashboard::partials.dashboard-school-commented')
@include('Dashboard::partials.dashboard-sales')
@include('Dashboard::partials.dashboard-client')
</section>
  <style>
    .address
    { cursor: pointer; 

    }  
    .inner-left {
      float: left;
      display: block;
    }

    .box-2 {
      width: 100%;
      float: left;
      display: block;
    }

    .small-box>.view-last {
      float: left;
      width: 100%;
      margin-bottom: 0px;
    }

    .mrg-bt-0 {

      font-size: 14px;
      margin-bottom: 0px;
    }

    .a-tag {
      width: 100%;
      float: left;
      margin-top: 1px;
    }

    .small-box>.a-tag .small-box-footer1 {
      text-align: center;
      padding: 3px 0;
      color: #fff;
      color: rgba(255, 255, 255, 0.8);
      z-index: 10;
      width: 100%;
      float: left;
      background: rgba(0, 0, 0, 0.1);
    }

    .small-box>.small-box-footer2 {
      margin-bottom: -18px;
    }
  </style>
  @section('script')

  <script src="{{asset('js/gps/mdb.js')}}"></script>
  <script src="{{asset('js/gps/dashb.js')}}"></script>


@role('client')
<link rel="stylesheet" href="{{asset('css/firebaselivetrack-new-css.css')}}" type="text/css" / >

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href='https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
  <script src="{{asset('js/gps/dashb-client.js')}}"></script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key={{config('eclipse.keys.googleMap')}}&libraries=places&callback=initMap"></script>
<script type="text/javascript">
  // refresh button on the map should be hidden when the dashboard loads
  window.onload = function() {
    document.getElementById('map_refresh_button').style.display = "none";
  }
</script>
<script src="{{asset('js/gps/GoogleRadar.js')}}"></script>
<script src="{{asset('dist/js/st.action-panel.js')}}"></script>
<style type="text/css">
  #f75 {
    width: 4%;
    padding: 8% 8% 7% 3%;
    margin-right: 3%;
    float: left;
    background: #c78307;
  }

  #f50 {
    width: 4%;
    padding: 8% 8% 7% 3%;
    margin-right: 3%;
    float: left;
    background: #f79f1c;
  }

  #f25 {
    width: 4%;
    padding: 8% 8% 7% 3%;
    margin-right: 3%;
    float: left;
    background: #f51902;
  }

  #f0 {
    width: 4%;
    padding: 8% 8% 7% 3%;
    margin-right: 3%;
    float: left;
    background: #cecece;
  }

  .fuel-outer ul li:last-child {
    margin-right: 0;
  }

</style>
@endrole

<!-- @role('school')
<script src="{{asset('js/gps/dashb-client.js')}}"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{config('eclipse.keys.googleMap')}}&libraries=places&callback=initMap"></script>
<script type="text/javascript">

</script>
<script src="{{asset('js/gps/GoogleRadar.js')}}"></script>

<script src="{{asset('dist/js/st.action-panel.js')}}"></script>
<style type="text/css">
  .container-fluid {
    padding-left: 0px !important
  }
</style>
@endrole -->




@role('root')
<script src="{{asset('js/gps/dash-root.js')}}"></script>
@endrole

@role('dealer')
<script src="{{asset('js/gps/dash-dealer.js')}}"></script>
@endrole

@role('sub_dealer')
<script src="{{asset('js/gps/dash-sub-dealer.js')}}"></script>
@endrole

@endsection
@endsection
