@extends('layouts.eclipse')
@section('title')
  Driver Score
@endsection
@section('content')

<div class="page-wrapper_new">
   <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Driver Score</li>
        <b>Driver Score</b>
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
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <div class="card-body">
     <!--  <div class="panel-heading">
        <div class="cover_div_search">  -->      
          <input type="hidden" id="driver" name="driver" value="{{$id}}">
       <!--  </div>
      </div>  -->  

      <div class="row">
         <div class="loader-wrapper" id="loader-1">
            <div id="loader"></div>
          </div>  
        <div class="col-lg-6 col-md-6">
          <h3 style="text-align:center;">Driver Score</h3>
          <h6 style="text-align:center;font-size: 12px;">Note: Kindly click on the box to get the individual details of driver.</h6>
          <div >
          <canvas id="driver-behaviour"></canvas>  
          </div>
        </div>
        <div class="loader-wrapper" id="loader-1">
            <div id="loader"></div>
          </div>  
        <div class="col-lg-6 col-md-6">
          <h3 style="text-align:center;">Driver Behaviour</h3>
          <h6 style="text-align:center;font-size: 12px;">Note: Kindly click on the box to get the individual details of driver.</h6>
          <div >
          <canvas id="driver-behaviour-alerts"></canvas>  
          </div>
        </div>
      </div>    
    </div>                
  </div>
</div>


@endsection

  @section('script')
    <script src="{{asset('js/gps/mdb.js')}}"></script>
    <script src="{{asset('js/gps/driver-score.js')}}"></script>
     @endsection
