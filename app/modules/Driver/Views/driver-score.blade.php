@extends('layouts.eclipse')
@section('title')
  Driver Score
@endsection
@section('content')

<div class="page-wrapper_new">
   <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-page-heading">Driver Score</li>
        <li class="breadcrumb-item active" aria-current="page"><a href="/home">Home</a>/Driver Score</li>
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
    
                           
          <div class="row">
            <div class="col-lg-6 col-md-6">
              <h3 style="text-align:center;">Driver Score</h3>
              <div >
              <canvas id="driver-behaviour"></canvas>  
              </div>
            </div>
            <div class="col-lg-6 col-md-6">
              <h3 style="text-align:center;">Driver Behaviour</h3>
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
    <script src="{{asset('js/gps/driver-alert-score.js')}}"></script>
  @endsection