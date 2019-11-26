@extends('layouts.eclipse')
@section('title')
  Go Premium
@endsection
@section('content')
@section('pre-css')
  <link href="{{asset('css/style.min2.css')}}" rel="stylesheet">
@endsection

<body>
<div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
  <h1 class="display-4" style="color:#b2bb00">Go Premium</h1>
</div>

<div class="container">
  <div class="card-deck mb-3 text-center">
 

    <div class="card mb-3 shadow-sm">
  <div style="height:72px">
  <!-- <img src="{{url('/')}}/premium/car3.jpg" class="card-img-top" alt="..."  style="width: 7rem;margin:1.5% auto;"> -->
<!--   <div class="card-body">
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
  </div> -->
</div>
      <div class="card-header">
        <h4 class="my-0 font-weight-normal">Superior</h4>
      </div>
      <?php
        $url=url()->current();
        $rayfleet_key="rayfleet";
        $eclipse_key="eclipse";
        $encryption_id=encrypt(3);
        if (strpos($url, $rayfleet_key) == true) {  ?>
          <button type="button" class="btn"><a href="{{url('/')}}/payments?plan={{$encryption_id}}"></a></button>
        <?php } 
        else if (strpos($url, $eclipse_key) == true) { ?>
          <button type="button" class="btn"><a href="{{url('/')}}/payments?plan={{$encryption_id}}">Pay Now</a></button>
        <?php }
        else { ?>
          <button type="button" class="btn"><a href="{{url('/')}}/payments?plan={{$encryption_id}}">Pay Now</a></button>
      <?php } ?> 
      
      <div class="card-body">
        <!-- <h1 class="card-title pricing-card-title">$0 <small class="text-muted">/ mo</small></h1> -->
       <ul class="list-unstyled mt-3 mb-4">
           <li><b>Everything in Fundamental +</b></li>
           <li><i class="fas fa-mobile-alt"></i>Mobile application</li>
           <li><i class="far fa-map"></i>Point of interest</li>
           <li><img src="{{url('/')}}/assets/images/route.png" style="margin:0 2%">Route Deviation[8 routes]</li>
           <li><i class="far fa-caret-square-left"></i>Route playback history(4 Months)</li>
          <li><img src="{{url('/')}}/assets/images/geofence.png" style="margin:0 2%">Geofence(8 Geofences)</li>
          <li><i class="far fa-star"></i>Driver score</li>
          <li><i class="far fa-file-alt"></i>Invoice</li>
          <li><img src="{{url('/')}}/assets/images/towing.png" style="margin:0 2%">Towing alert</li>
          <li><img src="{{url('/')}}/assets/images/radar.png" style="margin:0 2%">Radar</li>
          <li><img src="{{url('/')}}/assets/images/fuel.png" style="margin:0 2%">Fuel</li>
          <li><i class="far fa-share-square"></i>Share in webapp</li>
          <li><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>Emergency alerts</li>
          <li><img src="{{url('/')}}/assets/images/logo.png" style="margin:0 2%">Client Logo</li> 
          <li><img src="{{url('/')}}/assets/images/immobilizer.png" style="margin:0 2%">Immobilizer</li>
          <li><i class="far fa-comment-dots"></i>Daily report as SMS </li>
          <li><i class="far fa-envelope"></i>Daily report summary to reg. mail</li>
          <li><img src="{{url('/')}}/assets/images/theft.png" style="margin:0 2%">Anti-Theft Mode</li>
          <li><img src="{{url('/')}}/assets/images/ac.png" height="15px" width="15px" style="margin:0 2%">AC Status</li>
          <li style="height:0"></li> 
        </ul>
        <h6><b>Data charge:</b>  ₹1700 + Tax</h6>
        <h6><b>Server & Software charge:</b>  ₹2300 + Tax</h6>
        <h6><b>Immobilizer:</b>  ₹500 + Tax</h6>
        <h6><i>(1 year validity)</i></h6>
        <p>
  <a  data-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample2">
   Alert Reports (4 months history)
  </a>
</p>
<a data-toggle="collapse" href="#collapseExample2"><img src="{{url('/')}}/assets/images/download.gif" width="20" height="30"></a>
<div class="collapse" id="collapseExample2">
  <div class="card card-body" style="margin:0!important">
  <ul class="list-unstyled mt-3 mb-4">
          <li><img src="{{url('/')}}/assets/images/braking.png" style="margin:0 2% 0 0">Harsh Braking Alert</li>
          <li><img src="{{url('/')}}/assets/images/accelaration.png" style="margin:0 2% 0 0">Harsh Acceleration Alert</li>
          <li><img src="{{url('/')}}/assets/images/turning.png" style="margin:0 2% 0 0">Rash Turning Alert</li>
          <li><img src="{{url('/')}}/assets/images/box-open.png" style="margin:0 2% 0 0">GPS Box Opened Alert</li>
          <li><img src="{{ url('/') }}/SVG-Icons/geofence-entry.png" style="margin:0 2% 0 0" height="20px" width="20px">Geofence Entry Alert</li>
          <li><img src="{{ url('/') }}/SVG-Icons/geofence-exit.png" style="margin:0 2% 0 0" height="20px" width="20px">Geofence Exit Alert</li>
          <li><img src="{{url('/')}}/assets/images/connect-battery.png" style="margin:0 2% 0 0">Vehicle Battery Reconnect/ Connect back to main battery Alert</li>
          <li><i class="fas fa-battery-quarter"></i>Low battery Alert</li>
          <li><img src="{{url('/')}}/assets/images/low-battery.png" style="margin:0 2% 0 0">Low battery removed Alert</li>
          <li><img src="{{url('/')}}/assets/images/button.png" style="margin:0 2% 0 0">Emergency button wiredisconnect/wirecut Alert</li>
          <li><img src="{{url('/')}}/assets/images/disconnect.png" style="margin:0 2% 0 0">Disconnect from main battery Alert</li>
          <li><img src="{{url('/')}}/assets/images/overspeed.png" style="margin:0 2% 0 0">Over speed Alert</li>
          <li><img src="{{url('/')}}/assets/images/tilt.png" style="margin:0 2% 0 0">Tilt Alert</li>
          <li><img src="{{url('/')}}/assets/images/impact.png" style="margin:0 2% 0 0">Impact Alert</li>
          <li><img src="{{url('/')}}/assets/images/geo-entry.png" style="margin:0 2% 0 0">Overspeed+ GF Entry Alert</li>
          <li><img src="{{url('/')}}/assets/images/geo-exit.png" style="margin:0 2% 0 0">Overspeed + GF Exit Alert</li>
          <li><img src="{{url('/')}}/assets/images/location.png" style="margin:0 2% 0 0">Location Update Alert</li>
          <li><img src="{{url('/')}}/assets/images/location-update.png" style="margin:0 2% 0 0">Location Update (history) Alert</li>
          <li><img src="{{url('/')}}/assets/images/ignition-on.png" style="margin:0 2% 0 0">Alert – Ignition ON Alert</li>
          <li><img src="{{url('/')}}/assets/images/ignition-off.png" style="margin:0 2% 0 0">Alert – Ignition OFF Alert</li>
          <li><img src="{{url('/')}}/assets/images/state-on.png" style="margin:0 2% 0 0">Alert – Emergency state ON* Alert</li>
          <li><img src="{{url('/')}}/assets/images/state-off.png" style="margin:0 2% 0 0">Alert – emergency State OFF Alert</li>
          <li><img src="{{url('/')}}/assets/images/air.png" style="margin:0 2% 0 0">Alert Over the air parameter change Alert</li>
          <li><img src="{{url('/')}}/assets/images/towing.png" style="margin:0 2% 0 0">Towing alert</li>
          <li><img src="{{url('/')}}/assets/images/fuel.png" style="margin:0 2% 0 0">Fuel filling alert</li>
          <li><img src="{{url('/')}}/assets/images/fuel-low.png" style="margin:0 2% 0 0">Sudden decrease in fuel level alert</li>
          <li><a href="#">Contact your distributor for upgradation</a></li>
        </ul>
  </div>
</div>
         <!-- <button type="button" class="btn btn-lg btn-block btn-outline-primary">Pay Now</button> -->
      </div>

    </div>
    
    <div class="card mb-3 shadow-sm">
  <div style="height:72px">
 <!--  <img src="{{url('/')}}/premium/car4.jpg" class="card-img-top" alt="..."  style="width:7rem;margin:2% auto;"> -->
<!--   <div class="card-body">
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
  </div> -->
</div>
      <div class="card-header">
        <h4 class="my-0 font-weight-normal">PRO (White label)</h4>
      </div>
      <?php
        $encryption_id=encrypt(4);
        if (strpos($url, $rayfleet_key) == true) {  ?>
          <button type="button" class="btn"><a href="{{url('/')}}/payments?plan={{$encryption_id}}">Pay Now</a></button>
        <?php } 
        else if (strpos($url, $eclipse_key) == true) { ?>
          <button type="button" class="btn"><a href="{{url('/')}}/payments?plan={{$encryption_id}}">Pay Now</a></button>
        <?php }
        else { ?>
          <button type="button" class="btn"><a href="{{url('/')}}/payments?plan={{$encryption_id}}">Pay Now</a></button>
      <?php } ?> 
      
      <div class="card-body">
        <!-- <h1 class="card-title pricing-card-title">$0 <small class="text-muted">/ mo</small></h1> -->
        <ul class="list-unstyled mt-3 mb-4">
          <li><b>Everything in Superior +</b></li>
          <li><img src="{{url('/')}}/assets/images/route.png" style="margin:0 2%">Route Deviation[10 routes]</li>
          <li><i class="far fa-caret-square-left"></i>Route playback history(6 Months)</li>
          <li><img src="{{url('/')}}/assets/images/geofence.png" style="margin:0 2%">Geofence(10 Geofences)</li>
          <li><i class="fas fa-list"></i>Whitelist</li>
          <li><img src="{{url('/')}}/assets/images/www.png" style="margin:0 2%">Client domain</li>
          <li><img src="{{url('/')}}/assets/images/api.png" style="margin:0 2%">API access</li>
          <li><img src="{{url('/')}}/assets/images/design.png" style="margin:0 2%">Modify design(as per requirement)</li>
          <li><img src="{{url('/')}}/assets/images/custom.png" style="margin:0 2%">Custom features</li>
          <li><img src="{{url('/')}}/assets/images/database.png" style="margin:0 2%">Database backup</li>
          <li><img src="{{url('/')}}/assets/images/support.png" style="margin:0 2%">Privileged support</li>
          <li style="height:30px"></li> 
        </ul>
        <h6><b>Total charge:</b>  ₹500000 + Tax</h6>
        <p>
  <a  data-toggle="collapse" href="#collapseExample3" role="button" aria-expanded="false" aria-controls="collapseExample3">
   Alert Report (6 months history)
  </a>
</p>
<a data-toggle="collapse" href="#collapseExample3"><img src="{{url('/')}}/assets/images/download.gif" width="20" height="30"></a>
<div class="collapse" id="collapseExample3">
  <div class="card card-body" style="margin:0!important">
  <ul class="list-unstyled mt-3 mb-4">
          <li><img src="{{url('/')}}/assets/images/braking.png" style="margin:0 2% 0 0">Harsh Braking Alert</li>
          <li><img src="{{url('/')}}/assets/images/accelaration.png" style="margin:0 2% 0 0">Harsh Acceleration Alert</li>
          <li><img src="{{url('/')}}/assets/images/turning.png" style="margin:0 2% 0 0">Rash Turning Alert</li>
          <li><img src="{{url('/')}}/assets/images/box-open.png" style="margin:0 2% 0 0">GPS Box Opened Alert</li>
          <li><img src="{{ url('/') }}/SVG-Icons/geofence-entry.png" style="margin:0 2% 0 0" height="20px" width="20px">Geofence Entry Alert</li>
          <li><img src="{{ url('/') }}/SVG-Icons/geofence-exit.png" style="margin:0 2% 0 0" height="20px" width="20px">Geofence Exit Alert</li>
          <li><img src="{{url('/')}}/assets/images/connect-battery.png" style="margin:0 2% 0 0">Vehicle Battery Reconnect/ Connect back to main battery Alert</li>
          <li><i class="fas fa-battery-quarter"></i>Low battery Alert</li>
          <li><img src="{{url('/')}}/assets/images/low-battery.png" style="margin:0 2% 0 0">Low battery removed Alert</li>
          <li><img src="{{url('/')}}/assets/images/button.png" style="margin:0 2% 0 0">Emergency button wiredisconnect/wirecut Alert</li>
          <li><img src="{{url('/')}}/assets/images/disconnect.png" style="margin:0 2% 0 0">Disconnect from main battery Alert</li>
          <li><img src="{{url('/')}}/assets/images/overspeed.png" style="margin:0 2% 0 0">Over speed Alert</li>
          <li><img src="{{url('/')}}/assets/images/tilt.png" style="margin:0 2% 0 0">Tilt Alert</li>
          <li><img src="{{url('/')}}/assets/images/impact.png" style="margin:0 2% 0 0">Impact Alert</li>
          <li><img src="{{url('/')}}/assets/images/geo-entry.png" style="margin:0 2% 0 0">Overspeed+ GF Entry Alert</li>
          <li><img src="{{url('/')}}/assets/images/geo-exit.png" style="margin:0 2% 0 0">Overspeed + GF Exit Alert</li>
          <li><img src="{{url('/')}}/assets/images/location.png" style="margin:0 2% 0 0">Location Update Alert</li>
          <li><img src="{{url('/')}}/assets/images/location-update.png" style="margin:0 2% 0 0">Location Update (history) Alert</li>
          <li><img src="{{url('/')}}/assets/images/ignition-on.png" style="margin:0 2% 0 0">Alert – Ignition ON Alert</li>
          <li><img src="{{url('/')}}/assets/images/ignition-off.png" style="margin:0 2% 0 0">Alert – Ignition OFF Alert</li>
          <li><img src="{{url('/')}}/assets/images/state-on.png" style="margin:0 2% 0 0">Alert – Emergency state ON* Alert</li>
          <li><img src="{{url('/')}}/assets/images/state-off.png" style="margin:0 2% 0 0">Alert – emergency State OFF Alert</li>
          <li><img src="{{url('/')}}/assets/images/air.png" style="margin:0 2% 0 0">Alert Over the air parameter change Alert</li>
          <li><img src="{{url('/')}}/assets/images/towing.png" style="margin:0 2% 0 0">Towing alert</li>
          <li><img src="{{url('/')}}/assets/images/fuel.png" style="margin:0 2% 0 0">Fuel filling alert</li>
          <li><img src="{{url('/')}}/assets/images/fuel-low.png" style="margin:0 2% 0 0">Sudden decrease in fuel level alert</li>
          <li><img src="{{url('/')}}/assets/images/report.png" style="margin:0 2% 0 0">Customized report</li>
          <li><a href="#">Contact your distributor for upgradation</a></li>
        </ul>
  </div>
</div>
         <!-- <button type="button" class="btn btn-lg btn-block btn-outline-primary">Pay Now</button> -->
      </div>

    </div>
    
  </div>
</div>
<!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> -->
</body>
@endsection